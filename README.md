# Florist Before After – Elementor Image Comparison Widget

This plugin adds a flexible **before / after image comparison** widget for Elementor.

It is based on the original "Simple Before After for WordPress – Elementor" idea, and has been extended with additional customization options and a small statistics panel in the WordPress admin.

## Features

- **Horizontal or vertical slider** orientation
- **Default slider position** control
- Optional **move on hover** and **click to move** behaviors
- Customizable **handle**:
  - Size, color, border, radius
  - Padding
  - Icon (with full SVG support), icon color, icon size and padding
  - Optional **ripple**, **backdrop blur**, and **glow** effects
- Optional **handle bar** running through the image, with color and width controls
- Customizable **container** background, border, radius, padding and box‑shadow
- Optional **overlay** with color, opacity and blend‑mode controls
- **Responsive** height and mobile orientation options

## Labels (Before / After text)

The widget provides a dedicated **Labels** section under the Style tab:

- Toggle **Show Labels** on/off
- Set custom **Before Label** and **After Label** texts
- **Swap Before/After Text** option
  - When enabled, the left label uses the After text and the right label uses the Before text
- **Label Visibility** modes:
  - **Always Visible** – labels are always shown
  - **Show on Hover** – labels fade in when the mouse is over the widget
  - **Show After Moving Slider** – labels appear after the user first interacts with the slider

To keep the labels logically correct with respect to the visible side:

- When the slider handle is near the **far left** edge, only the **right‑side** label is shown
- When the slider handle is near the **far right** edge, only the **left‑side** label is shown
- In the **middle range**, both labels are visible (subject to the selected visibility mode)

This makes it clear which side (before or after) is currently visible when the handle is parked at either edge.

## Admin Statistics

The plugin tracks basic usage statistics for the widget:

- **Total renders** of the before/after widget
- **Last render time**

These stats are displayed on a dedicated page under the WordPress admin menu for this plugin.

## License

This plugin is released under the **MIT License**. See `LICENSE.md` for full details.

