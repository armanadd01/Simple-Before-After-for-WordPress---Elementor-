<?php
/**
 * Plugin Name: Multilat Before After Image Comparison
 * Plugin URI: https://floristchapter.com
 * Description: A custom Elementor widget for before/after image comparison with advanced customization options.
 * Version: 1.0.0
 * Author: Multilat
 * Developer: Arman Habib Nahid
 * License: GPL v2 or later
 * Text Domain: multilat-before-after
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('FLORIST_BEFORE_AFTER_VERSION', '1.0.0');
define('FLORIST_BEFORE_AFTER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FLORIST_BEFORE_AFTER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Main plugin class
class Florist_Before_After_Plugin {

    public function __construct() {
        add_action('plugins_loaded', array($this, 'init'));
    }

    public function init() {
        // Check if Elementor is active
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', array($this, 'elementor_missing_notice'));
            return;
        }

        // Register widget - use both old and new methods for compatibility
        add_action('elementor/widgets/widgets_registered', array($this, 'register_widgets_old'));
        add_action('elementor/widgets/register', array($this, 'register_widgets_new'));

        // Enqueue scripts and styles
        add_action('elementor/frontend/after_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
        add_action('elementor/editor/after_enqueue_scripts', array($this, 'enqueue_editor_scripts'));

        // Admin statistics page
        if (is_admin()) {
            add_action('admin_menu', array($this, 'register_admin_menu'));
        }
    }

    public function elementor_missing_notice() {
        echo '<div class="notice notice-error"><p>' . __('Multilat Before After Image Comparison requires Elementor to be installed and activated.', 'multilat-before-after') . '</p></div>';
    }

    public function register_widgets_old() {
        require_once FLORIST_BEFORE_AFTER_PLUGIN_DIR . 'includes/class-before-after-widget.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Florist_Before_After_Widget());
    }

    public function register_widgets_new($widgets_manager) {
        require_once FLORIST_BEFORE_AFTER_PLUGIN_DIR . 'includes/class-before-after-widget.php';
        $widgets_manager->register(new Florist_Before_After_Widget());
    }

    public function enqueue_frontend_scripts() {
        wp_enqueue_style('multilat-before-after-style', FLORIST_BEFORE_AFTER_PLUGIN_URL . 'assets/css/before-after.css', array(), FLORIST_BEFORE_AFTER_VERSION);
        wp_enqueue_script('multilat-before-after-script', FLORIST_BEFORE_AFTER_PLUGIN_URL . 'assets/js/before-after.js', array('jquery'), FLORIST_BEFORE_AFTER_VERSION, true);
    }

    public function enqueue_editor_scripts() {
        wp_enqueue_style('multilat-before-after-editor-style', FLORIST_BEFORE_AFTER_PLUGIN_URL . 'assets/css/before-after-editor.css', array(), FLORIST_BEFORE_AFTER_VERSION);
    }

    public function register_admin_menu() {
        add_menu_page(
            __('Before/After Stats', 'multilat-before-after'),
            __('Before/After Stats', 'multilat-before-after'),
            'manage_options',
            'florist-before-after-stats',
            array($this, 'render_stats_page'),
            'dashicons-chart-area',
            80
        );
    }

    public function render_stats_page() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'multilat-before-after'));
        }

        $stats = get_option('florist_before_after_stats', array());
        if (!is_array($stats)) {
            $stats = array();
        }

        $total_renders = isset($stats['total_renders']) ? (int) $stats['total_renders'] : 0;
        $last_render_time = isset($stats['last_render_time']) ? $stats['last_render_time'] : __('Never', 'multilat-before-after');

        ?>
        <div class="wrap">
            <h1><?php echo esc_html(__('Before/After Image Comparison - Statistics', 'multilat-before-after')); ?></h1>
            <table class="widefat" style="max-width:600px;margin-top:20px;">
                <tbody>
                    <tr>
                        <th scope="row"><?php echo esc_html(__('Total Widget Renders', 'multilat-before-after')); ?></th>
                        <td><?php echo esc_html($total_renders); ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html(__('Last Render Time', 'multilat-before-after')); ?></th>
                        <td><?php echo esc_html($last_render_time); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
    }
}

// Initialize the plugin
new Florist_Before_After_Plugin();