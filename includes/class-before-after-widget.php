<?php
if (!defined('ABSPATH')) {
    exit;
}

class Florist_Before_After_Widget extends \Elementor\Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
    }

    public function get_name() {
        return 'multilat_before_after';
    }

    public function get_title() {
        return __('Multilat Before After Image Comparison', 'multilat-before-after');
    }

    public function get_icon() {
        return 'eicon-image';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_script_depends() {
        return ['multilat-before-after-script'];
    }

    public function get_style_depends() {
        return ['multilat-before-after-style'];
    }

    protected function _register_controls() {
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'multilat-before-after'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'before_image',
            [
                'label' => __('Before Image', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'after_image',
            [
                'label' => __('After Image', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'orientation',
            [
                'label' => __('Orientation', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => __('Horizontal', 'multilat-before-after'),
                    'vertical' => __('Vertical', 'multilat-before-after'),
                ],
            ]
        );

        $this->add_control(
            'default_position',
            [
                'label' => __('Default Slider Position (%)', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
            ]
        );

        $this->add_control(
            'move_slider_on_hover',
            [
                'label' => __('Move Slider on Hover', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => __('Automatically move the slider when hovering over the image', 'multilat-before-after'),
            ]
        );

        $this->add_control(
            'click_to_move',
            [
                'label' => __('Click to Move', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => __('Allow clicking on the image to move the slider', 'multilat-before-after'),
            ]
        );

        $this->end_controls_section();

        // Style Tab - Slider
        $this->start_controls_section(
            'slider_section',
            [
                'label' => __('Slider', 'multilat-before-after'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'handle_size',
            [
                'label' => __('Handle Size', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fba-handle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'handle_color',
            [
                'label' => __('Handle Color', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .fba-handle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'handle_icon',
            [
                'label' => __('Handle Icon', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-arrows-alt-h',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'handle_icon_color',
            [
                'label' => __('Handle Icon Color', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .fba-handle i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .fba-handle svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .fba-handle svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'handle_border_color',
            [
                'label' => __('Handle Border Color', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .fba-handle' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'handle_border_width',
            [
                'label' => __('Handle Border Width', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fba-handle' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'handle_border_radius',
            [
                'label' => __('Handle Border Radius', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fba-handle' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'handle_padding',
            [
                'label' => __('Handle Padding', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .fba-handle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __('Icon Size', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .fba-handle i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .fba-handle svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => __('Icon Padding', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .fba-handle i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .fba-handle svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'handle_box_shadow',
                'label' => __('Handle Box Shadow', 'multilat-before-after'),
                'selector' => '{{WRAPPER}} .fba-handle',
            ]
        );

        $this->add_control(
            'handle_ripple',
            [
                'label' => __('Handle Ripple Effect', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'handle_backdrop_blur',
            [
                'label' => __('Handle Backdrop Blur', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .fba-handle' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_control(
            'handle_glow_color',
            [
                'label' => __('Handle Glow Color', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'description' => __('Adds a soft outer glow using box-shadow.', 'multilat-before-after'),
                'selectors' => [
                    '{{WRAPPER}} .fba-handle' => 'box-shadow: 0 0 15px {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'show_handle_bar',
            [
                'label' => __('Show Handle Bar', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'handle_bar_color',
            [
                'label' => __('Handle Bar Color', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .fba-handle-bar' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_handle_bar' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'handle_bar_width',
            [
                'label' => __('Handle Bar Width', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fba-handle-bar' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_handle_bar' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Labels
        $this->start_controls_section(
            'labels_section',
            [
                'label' => __('Labels', 'multilat-before-after'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'show_labels',
            [
                'label' => __('Show Labels', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'swap_labels',
            [
                'label' => __('Swap Before/After Text', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => __('When enabled, the left label will use the After text and the right label will use the Before text.', 'multilat-before-after'),
                'condition' => [
                    'show_labels' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_visibility_mode',
            [
                'label' => __('Label Visibility', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'always',
                'options' => [
                    'always' => __('Always Visible', 'multilat-before-after'),
                    'hover' => __('Show on Hover', 'multilat-before-after'),
                    'move' => __('Show After Moving Slider', 'multilat-before-after'),
                ],
                'condition' => [
                    'show_labels' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'before_label',
            [
                'label' => __('Before Label', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Before', 'multilat-before-after'),
                'condition' => [
                    'show_labels' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'after_label',
            [
                'label' => __('After Label', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('After', 'multilat-before-after'),
                'condition' => [
                    'show_labels' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => __('Typography', 'multilat-before-after'),
                'selector' => '{{WRAPPER}} .fba-label',
                'condition' => [
                    'show_labels' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => __('Label Color', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .fba-label' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_labels' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_bg_color',
            [
                'label' => __('Label Background Color', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.7)',
                'selectors' => [
                    '{{WRAPPER}} .fba-label' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_labels' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_padding',
            [
                'label' => __('Label Padding', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '5',
                    'right' => '10',
                    'bottom' => '5',
                    'left' => '10',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .fba-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_labels' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_border_radius',
            [
                'label' => __('Label Border Radius', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fba-label' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_labels' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Animation
        $this->start_controls_section(
            'animation_section',
            [
                'label' => __('Animation', 'multilat-before-after'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'transition_duration',
            [
                'label' => __('Transition Duration (ms)', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 300,
                'min' => 0,
                'max' => 2000,
            ]
        );

        $this->add_control(
            'easing',
            [
                'label' => __('Easing', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'ease',
                'options' => [
                    'ease' => __('Ease', 'multilat-before-after'),
                    'linear' => __('Linear', 'multilat-before-after'),
                    'ease-in' => __('Ease In', 'multilat-before-after'),
                    'ease-out' => __('Ease Out', 'multilat-before-after'),
                    'ease-in-out' => __('Ease In Out', 'multilat-before-after'),
                    'cubic-bezier(0.68, -0.55, 0.265, 1.55)' => __('Bounce', 'multilat-before-after'),
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __('Hover Animation', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => __('None', 'multilat-before-after'),
                    'fade' => __('Fade', 'multilat-before-after'),
                    'zoom' => __('Zoom', 'multilat-before-after'),
                    'slide' => __('Slide', 'multilat-before-after'),
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Overlay Effects
        $this->start_controls_section(
            'overlay_section',
            [
                'label' => __('Overlay Effects', 'multilat-before-after'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => __('Overlay Color', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.3)',
                'selectors' => [
                    '{{WRAPPER}} .fba-container.fba-has-overlay .fba-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'overlay_opacity',
            [
                'label' => __('Overlay Opacity', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fba-container.fba-has-overlay .fba-overlay' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'overlay_blend_mode',
            [
                'label' => __('Overlay Blend Mode', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal' => __('Normal', 'multilat-before-after'),
                    'multiply' => __('Multiply', 'multilat-before-after'),
                    'screen' => __('Screen', 'multilat-before-after'),
                    'overlay' => __('Overlay', 'multilat-before-after'),
                    'darken' => __('Darken', 'multilat-before-after'),
                    'lighten' => __('Lighten', 'multilat-before-after'),
                    'color-dodge' => __('Color Dodge', 'multilat-before-after'),
                    'color-burn' => __('Color Burn', 'multilat-before-after'),
                    'hard-light' => __('Hard Light', 'multilat-before-after'),
                    'soft-light' => __('Soft Light', 'multilat-before-after'),
                    'difference' => __('Difference', 'multilat-before-after'),
                    'exclusion' => __('Exclusion', 'multilat-before-after'),
                    'hue' => __('Hue', 'multilat-before-after'),
                    'saturation' => __('Saturation', 'multilat-before-after'),
                    'color' => __('Color', 'multilat-before-after'),
                    'luminosity' => __('Luminosity', 'multilat-before-after'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .fba-container.fba-has-overlay .fba-overlay' => 'mix-blend-mode: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Container
        $this->start_controls_section(
            'container_section',
            [
                'label' => __('Container', 'multilat-before-after'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'container_background',
                'label' => __('Background', 'multilat-before-after'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .fba-container',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'label' => __('Border', 'multilat-before-after'),
                'selector' => '{{WRAPPER}} .fba-container',
            ]
        );

        $this->add_control(
            'container_border_radius',
            [
                'label' => __('Border Radius', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .fba-container' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'label' => __('Box Shadow', 'multilat-before-after'),
                'selector' => '{{WRAPPER}} .fba-container',
            ]
        );

        $this->add_control(
            'container_padding',
            [
                'label' => __('Padding', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .fba-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Responsive Tab
        $this->start_controls_section(
            'responsive_section',
            [
                'label' => __('Responsive', 'multilat-before-after'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => __('Height', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 400,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fba-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mobile_orientation',
            [
                'label' => __('Mobile Orientation', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => __('Horizontal', 'multilat-before-after'),
                    'vertical' => __('Vertical', 'multilat-before-after'),
                ],
                'description' => __('Orientation to use on mobile devices', 'multilat-before-after'),
            ]
        );

        $this->add_control(
            'hide_on_mobile',
            [
                'label' => __('Hide on Mobile', 'multilat-before-after'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => __('Hide the before/after slider on mobile devices', 'multilat-before-after'),
            ]
        );

        $this->end_controls_section();
    }

    // New Elementor versions call register_controls(), so delegate to the existing method
    protected function register_controls() {
        $this->_register_controls();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['before_image']['url']) || empty($settings['after_image']['url'])) {
            echo '<div class="fba-error">' . __('Please select both Before and After images.', 'multilat-before-after') . '</div>';
            return;
        }

        $orientation = isset($settings['orientation']) ? $settings['orientation'] : 'horizontal';
        $default_position = isset($settings['default_position']['size']) ? $settings['default_position']['size'] : 50;
        $transition_duration = isset($settings['transition_duration']) ? $settings['transition_duration'] : 300;
        $easing = isset($settings['easing']) ? $settings['easing'] : 'ease';
        $move_slider_on_hover = isset($settings['move_slider_on_hover']) ? $settings['move_slider_on_hover'] : 'no';
        $click_to_move = isset($settings['click_to_move']) ? $settings['click_to_move'] : 'yes';

        $this->add_render_attribute('container', 'class', 'fba-container fba-has-overlay');

        $this->add_render_attribute('container', 'data-orientation', $orientation);
        $this->add_render_attribute('container', 'data-default-position', $default_position);
        $this->add_render_attribute('container', 'data-transition-duration', $transition_duration);
        $this->add_render_attribute('container', 'data-easing', $easing);
        $this->add_render_attribute('container', 'data-move-on-hover', $move_slider_on_hover);
        $this->add_render_attribute('container', 'data-click-to-move', $click_to_move);

        // Mobile responsiveness
        $mobile_orientation = isset($settings['mobile_orientation']) ? $settings['mobile_orientation'] : 'horizontal';
        $hide_on_mobile = isset($settings['hide_on_mobile']) ? $settings['hide_on_mobile'] : 'no';

        if ($hide_on_mobile === 'yes') {
            $this->add_render_attribute('container', 'class', 'elementor-hidden-mobile');
        }

        $this->add_render_attribute('container', 'data-mobile-orientation', $mobile_orientation);

        $label_visibility_mode = isset($settings['label_visibility_mode']) ? $settings['label_visibility_mode'] : 'always';
        $this->add_render_attribute('container', 'data-label-visibility', $label_visibility_mode);

        // Basic usage statistics tracking
        $stats = get_option('florist_before_after_stats', array());
        if (!is_array($stats)) {
            $stats = array();
        }
        $total_renders = isset($stats['total_renders']) ? (int) $stats['total_renders'] : 0;
        $stats['total_renders'] = $total_renders + 1;
        $stats['last_render_time'] = current_time('mysql');
        update_option('florist_before_after_stats', $stats);

        $handle_class = 'fba-handle';
        if (!empty($settings['handle_ripple']) && $settings['handle_ripple'] === 'yes') {
            $handle_class .= ' fba-handle--ripple';
        }

        ?>
        <div <?php echo $this->get_render_attribute_string('container'); ?>>
            <div class="fba-wrapper">

                <?php if (!isset($settings['show_handle_bar']) || $settings['show_handle_bar'] === 'yes') : ?>
                    <div class="fba-handle-bar"></div>
                <?php endif; ?>
                <div class="fba-image fba-before-image">
                    <img src="<?php echo esc_url($settings['before_image']['url']); ?>" alt="<?php echo esc_attr(isset($settings['before_label']) ? $settings['before_label'] : 'Before'); ?>">
                </div>
                <div class="fba-image fba-after-image">
                    <img src="<?php echo esc_url($settings['after_image']['url']); ?>" alt="<?php echo esc_attr(isset($settings['after_label']) ? $settings['after_label'] : 'After'); ?>">
                </div>
                <?php if (isset($settings['show_labels']) && $settings['show_labels'] === 'yes') : ?>
                    <?php
                    $before_text = isset($settings['before_label']) ? $settings['before_label'] : __('Before', 'multilat-before-after');
                    $after_text  = isset($settings['after_label']) ? $settings['after_label'] : __('After', 'multilat-before-after');

                    if (!empty($settings['swap_labels']) && $settings['swap_labels'] === 'yes') {
                        $left_text  = $after_text;
                        $right_text = $before_text;
                    } else {
                        $left_text  = $before_text;
                        $right_text = $after_text;
                    }
                    ?>
                    <div class="fba-label fba-before-label"><?php echo esc_html($left_text); ?></div>
                    <div class="fba-label fba-after-label"><?php echo esc_html($right_text); ?></div>
                <?php endif; ?>

                <div class="<?php echo esc_attr($handle_class); ?>">

                    <?php
                    if (!empty($settings['handle_icon']['value'])) {
                        if (class_exists('\Elementor\Icons_Manager')) {
                            \Elementor\Icons_Manager::render_icon(
                                $settings['handle_icon'],
                                ['aria-hidden' => 'true']
                            );
                        } else {
                            echo '<i class="' . esc_attr($settings['handle_icon']['value']) . '"></i>';
                        }
                    }
                    ?>
                </div>
                <div class="fba-overlay"></div>
            </div>
        </div>
        <?php
    }

    protected function _content_template() {
        ?>
        <#
        if (!settings.before_image.url || !settings.after_image.url) {
            #>
            <div class="fba-error"><?php echo __('Please select both Before and After images.', 'multilat-before-after'); ?></div>
            <#
            return;
        }
        #>
        <div class="fba-container" data-orientation="{{ settings.orientation }}" data-default-position="{{ settings.default_position.size }}" data-transition-duration="{{ settings.transition_duration }}" data-easing="{{ settings.easing }}" data-move-on-hover="{{ settings.move_slider_on_hover }}" data-click-to-move="{{ settings.click_to_move }}" data-mobile-orientation="{{ settings.mobile_orientation }}" data-label-visibility="{{ settings.label_visibility_mode }}">
            <div class="fba-wrapper">

                <div class="fba-image fba-before-image">
                    <img src="{{ settings.before_image.url }}" alt="{{ settings.before_label }}">
                </div>
                <div class="fba-image fba-after-image">
                    <img src="{{ settings.after_image.url }}" alt="{{ settings.after_label }}">
                </div>
                <# if (settings.show_labels === 'yes') { #>
                    <#
                    var beforeText = settings.before_label ? settings.before_label : 'Before';
                    var afterText  = settings.after_label ? settings.after_label : 'After';

                    var leftText, rightText;
                    if (settings.swap_labels === 'yes') {
                        leftText  = afterText;
                        rightText = beforeText;
                    } else {
                        leftText  = beforeText;
                        rightText = afterText;
                    }
                    #>
                    <div class="fba-label fba-before-label">{{{ leftText }}}</div>
                    <div class="fba-label fba-after-label">{{{ rightText }}}</div>
                <# } #>

                <div class="fba-handle <# if (settings.handle_ripple === 'yes') { #>fba-handle--ripple<# } #>">

                    <# if (settings.handle_icon && settings.handle_icon.value) { #>
                        {{{ elementor.helpers.renderIcon( view, settings.handle_icon, { 'aria-hidden': true }, 'i', 'object' ).value }}}
                    <# } #>
                </div>

                <div class="fba-overlay"></div>
            </div>
        </div>
        <?php
    }
}