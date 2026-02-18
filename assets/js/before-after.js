(function($) {
    'use strict';

    var FloristBeforeAfter = function(element) {
        this.element = $(element);

        // If the element itself is the container, use it directly; otherwise look for a nested container
        if (this.element.hasClass('fba-container')) {
            this.container = this.element;
        } else {
            this.container = this.element.find('.fba-container');
        }

        this.wrapper = this.container.find('.fba-wrapper');
        this.handle = this.container.find('.fba-handle');
        this.handleBar = this.container.find('.fba-handle-bar');

        this.beforeImage = this.container.find('.fba-before-image');
        this.afterImage = this.container.find('.fba-after-image');
        this.orientation = this.container.data('orientation') || 'horizontal';
        this.defaultPosition = this.container.data('default-position') || 50;
        this.transitionDuration = this.container.data('transition-duration') || 300;
        this.easing = this.container.data('easing') || 'ease';
        this.moveOnHover = this.container.data('move-on-hover') === 'yes';
        this.clickToMove = this.container.data('click-to-move') === 'yes';
        this.mobileOrientation = this.container.data('mobile-orientation') || 'horizontal';
        // Prefer attribute read to avoid jQuery .data() caching issues (Elementor can update attributes live)
        this.labelVisibility = this.container.attr('data-label-visibility') || this.container.data('label-visibility') || 'always';

        this.isDragging = false;
        this.startPos = 0;
        this.currentPos = this.defaultPosition;

        this.init();
    };

    FloristBeforeAfter.prototype.init = function() {
        this.checkMobileOrientation();
        this.applyLabelVisibilityMode();
        this.setInitialPosition();
        this.bindEvents();
    };

    FloristBeforeAfter.prototype.applyLabelVisibilityMode = function() {
        // Re-read from attribute in case Elementor updated it
        this.labelVisibility = this.container.attr('data-label-visibility') || this.labelVisibility || 'always';

        this.container.removeClass('fba-label-visibility-always fba-label-visibility-hover fba-label-visibility-move');
        this.container.addClass('fba-label-visibility-' + this.labelVisibility);

        if (this.labelVisibility !== 'move') {
            this.container.removeClass('fba-labels-visible');
        }
    };

    FloristBeforeAfter.prototype.checkMobileOrientation = function() {
        if (window.innerWidth <= 768 && this.mobileOrientation !== this.orientation) {
            this.orientation = this.mobileOrientation;
            this.container.attr('data-orientation', this.orientation);
        }
    };

    FloristBeforeAfter.prototype.setInitialPosition = function() {
        this.updatePosition(this.defaultPosition);
    };

    FloristBeforeAfter.prototype.revealLabelsIfNeeded = function() {
        // Re-check current mode (Elementor can change it without a full reload)
        this.applyLabelVisibilityMode();

        if (this.labelVisibility === 'move') {
            this.container.addClass('fba-labels-visible');
        }
    };

    FloristBeforeAfter.prototype.bindEvents = function() {
        var self = this;

        this.handle.on('mousedown touchstart', function(e) {
            self.startDrag(e);
        });

        $(document).on('mousemove touchmove', function(e) {
            if (self.isDragging) {
                self.drag(e);
            }
        });

        $(document).on('mouseup touchend', function(e) {
            if (self.isDragging) {
                self.endDrag(e);
            }
        });

        this.container.on('click', function(e) {
            if (self.clickToMove && !self.isDragging) {
                self.handleClick(e);
            }
        });

        if (this.moveOnHover) {
            this.container.on('mousemove', function(e) {
                if (!self.isDragging) {
                    self.handleHover(e);
                }
            });
        }

        // Touch events
        this.handle.on('touchstart', function(e) {
            e.preventDefault();
            self.startDrag(e);
        });

        // Responsive handling
        $(window).on('resize', function() {
            self.checkMobileOrientation();
            self.updatePosition(self.currentPos);
        });
    };

    FloristBeforeAfter.prototype.startDrag = function(e) {
        e.preventDefault();
        this.isDragging = true;
        this.handle.addClass('dragging');

        this.revealLabelsIfNeeded();

        var event = e.type === 'touchstart' ? e.touches[0] : e;
        this.startPos = this.orientation === 'horizontal' ? event.clientX : event.clientY;
    };

    FloristBeforeAfter.prototype.drag = function(e) {
        if (!this.isDragging) return;

        e.preventDefault();
        var event = e.type === 'touchmove' ? e.touches[0] : e;
        var currentPos = this.orientation === 'horizontal' ? event.clientX : event.clientY;
        var delta = currentPos - this.startPos;
        var containerSize = this.orientation === 'horizontal' ? this.container.width() : this.container.height();
        var newPos = this.currentPos + (delta / containerSize) * 100;

        newPos = Math.max(0, Math.min(100, newPos));
        this.updatePosition(newPos);
    };

    FloristBeforeAfter.prototype.endDrag = function(e) {
        this.isDragging = false;
        this.handle.removeClass('dragging');
    };

    FloristBeforeAfter.prototype.handleClick = function(e) {
        var rect = this.container[0].getBoundingClientRect();

        var clickPos = this.orientation === 'horizontal' ?
            e.clientX - rect.left :
            e.clientY - rect.top;
        var containerSize = this.orientation === 'horizontal' ? rect.width : rect.height;
        var newPos = (clickPos / containerSize) * 100;

        this.revealLabelsIfNeeded();
        this.animateToPosition(newPos);
    };

    FloristBeforeAfter.prototype.handleHover = function(e) {
        var rect = this.container[0].getBoundingClientRect();

        var hoverPos = this.orientation === 'horizontal' ?
            e.clientX - rect.left :
            e.clientY - rect.top;
        var containerSize = this.orientation === 'horizontal' ? rect.width : rect.height;
        var newPos = (hoverPos / containerSize) * 100;

        newPos = Math.max(0, Math.min(100, newPos));
        this.revealLabelsIfNeeded();
        this.updatePosition(newPos);
    };

    FloristBeforeAfter.prototype.updatePosition = function(position) {
        // Clamp to the valid 0–100 range so edge logic is reliable
        position = Math.max(0, Math.min(100, position));
        this.currentPos = position;

        if (this.orientation === 'horizontal') {
            this.afterImage.css('clip-path', 'inset(0 ' + (100 - position) + '% 0 0)');
            this.handle.css('left', position + '%');
            if (this.handleBar.length) {
                this.handleBar.css('left', position + '%');
            }
        } else {
            this.afterImage.css('clip-path', 'inset(0 0 ' + (100 - position) + '% 0)');
            this.handle.css('top', position + '%');
            if (this.handleBar.length) {
                this.handleBar.css('top', position + '%');
            }
        }

        // Always hide the label on the empty side
        this.container.removeClass('fba-left-only fba-right-only fba-middle-left fba-middle-right');

        // Use a threshold because drag/click math often produces fractional values
        var edgeThreshold = 1;

        if (position <= edgeThreshold) {
            // Bar at far left - only right side (After) is visible
            this.container.addClass('fba-left-only');
        } else if (position >= 100 - edgeThreshold) {
            // Bar at far right - only left side (Before) is visible
            this.container.addClass('fba-right-only');
        } else if (position < 50) {
            // In middle, but more right side visible - hide left label
            this.container.addClass('fba-middle-right');
        } else {
            // In middle, but more left side visible - hide right label
            this.container.addClass('fba-middle-left');
        }
    };

    FloristBeforeAfter.prototype.animateToPosition = function(position) {
        var self = this;
        var startPos = this.currentPos;
        var startTime = null;

        function animate(currentTime) {
            if (startTime === null) startTime = currentTime;
            var elapsed = currentTime - startTime;
            var progress = Math.min(elapsed / self.transitionDuration, 1);

            // Easing function
            var easedProgress = self.applyEasing(progress);

            var currentPosition = startPos + (position - startPos) * easedProgress;
            self.updatePosition(currentPosition);

            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        }

        requestAnimationFrame(animate);
    };

    FloristBeforeAfter.prototype.applyEasing = function(t) {
        switch (this.easing) {
            case 'linear':
                return t;
            case 'ease-in':
                return t * t;
            case 'ease-out':
                return t * (2 - t);
            case 'ease-in-out':
                return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
            case 'cubic-bezier(0.68, -0.55, 0.265, 1.55)':
                // Bounce easing approximation
                var c4 = (2 * Math.PI) / 3;
                return t === 0 ? 0 : t === 1 ? 1 : Math.pow(2, -10 * t) * Math.sin((t * 10 - 0.75) * c4) + 1;
            default: // ease
                return t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        $('.fba-container').each(function() {
            new FloristBeforeAfter(this);
        });
    });

    // Re-initialize for Elementor live preview
    $(window).on('elementor/frontend/init', function() {
        if (window.elementorFrontend && window.elementorFrontend.hooks && window.elementorFrontend.hooks.addAction) {
            window.elementorFrontend.hooks.addAction('frontend/element_ready/multilat_before_after.default', function($element) {
                new FloristBeforeAfter($element[0]);
            });
        }
    });

})(jQuery);