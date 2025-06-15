<?php
/**
 * Configuration file for Salient WooCommerce Product Display Enhancer
 * 
 * This file contains all the configuration constants and default values
 * for the Salient WooCommerce Product Display Enhancer plugin.
 * 
 * @package Salient_WooCommerce_Product_Display_Enhancer
 * @version 2.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Plugin Configuration Class
 */
class Salient_WooCommerce_Enhancer_Config {
    
    /**
     * Plugin version
     */
    const VERSION = '2.0.0';
    
    /**
     * Minimum required versions
     */
    const MIN_PHP_VERSION = '7.0';
    const MIN_WP_VERSION = '5.0';
    const MIN_WC_VERSION = '3.0';
    
    /**
     * Plugin paths and URLs
     */
    public static function get_plugin_url() {
        return plugin_dir_url(__FILE__);
    }
    
    public static function get_plugin_path() {
        return plugin_dir_path(__FILE__);
    }
    
    /**
     * Default plugin settings
     */
    public static function get_default_settings() {
        return array(
            // Title Settings
            'title_font_size_desktop' => 18,
            'title_font_size_tablet' => 16,
            'title_font_size_mobile' => 14,
            'title_font_weight' => 600,
            'title_color' => '#333333',
            'title_alignment' => 'center',
            'title_margin_bottom' => 8,
            
            // Price Settings
            'price_font_size_desktop' => 16,
            'price_font_size_tablet' => 14,
            'price_font_size_mobile' => 13,
            'price_font_weight' => 500,
            'price_color' => '#e74c3c',
            'price_alignment' => 'center',
            'price_margin_bottom' => 12,
            
            // Button Settings
            'button_text' => 'Vai al prodotto',
            'button_font_size_desktop' => 14,
            'button_font_size_tablet' => 13,
            'button_font_size_mobile' => 12,
            'button_bg_color' => '#3498db',
            'button_text_color' => '#ffffff',
            'button_hover_bg_color' => '#2980b9',
            'button_border_radius' => 4,
            'button_padding_horizontal' => 16,
            'button_padding_vertical' => 10,
            'button_margin_left' => 8,
            'button_alignment' => 'center',
            
            // Container Settings
            'container_padding' => 12,
            'container_margin_top' => 10,
            'container_max_width' => 100,
            
            // Responsive Settings
            'mobile_breakpoint' => 768,
            'tablet_breakpoint' => 1024,
            'enable_responsive' => true,
            
            // Advanced Settings
            'hide_original_elements' => true,
            'custom_css' => ''
        );
    }
    
    /**
     * Responsive breakpoints
     */
    const BREAKPOINTS = array(
        'mobile' => 768,
        'tablet' => 1024,
        'desktop' => 1025,
        'large_desktop' => 1200,
        'extra_large' => 1400
    );
    
    /**
     * Supported font weights
     */
    const FONT_WEIGHTS = array(
        '300' => 'Light',
        '400' => 'Normal', 
        '500' => 'Medium',
        '600' => 'Semi-Bold',
        '700' => 'Bold'
    );
    
    /**
     * Alignment options
     */
    const ALIGNMENTS = array(
        'left' => 'Sinistra',
        'center' => 'Centro',
        'right' => 'Destra'
    );
    
    /**
     * Color palette for quick selection
     */
    const COLOR_PALETTE = array(
        '#333333', // Dark gray
        '#666666', // Medium gray
        '#999999', // Light gray
        '#ffffff', // White
        '#000000', // Black
        '#e74c3c', // Red
        '#3498db', // Blue
        '#2ecc71', // Green
        '#f39c12', // Orange
        '#9b59b6', // Purple
        '#1abc9c', // Turquoise
        '#34495e'  // Dark blue-gray
    );
    
    /**
     * Validation rules for settings
     */
    const VALIDATION_RULES = array(
        'font_size' => array(
            'min' => 8,
            'max' => 50,
            'type' => 'integer'
        ),
        'font_weight' => array(
            'allowed' => array('300', '400', '500', '600', '700'),
            'type' => 'string'
        ),
        'color' => array(
            'pattern' => '/^#[a-fA-F0-9]{6}$/',
            'type' => 'string'
        ),
        'alignment' => array(
            'allowed' => array('left', 'center', 'right'),
            'type' => 'string'
        ),
        'margin' => array(
            'min' => 0,
            'max' => 100,
            'type' => 'integer'
        ),
        'padding' => array(
            'min' => 0,
            'max' => 50,
            'type' => 'integer'
        ),
        'border_radius' => array(
            'min' => 0,
            'max' => 50,
            'type' => 'integer'
        ),
        'percentage' => array(
            'min' => 10,
            'max' => 100,
            'type' => 'integer'
        ),
        'breakpoint' => array(
            'min' => 320,
            'max' => 1920,
            'type' => 'integer'
        )
    );
    
    /**
     * Cache settings
     */
    const CACHE_SETTINGS = array(
        'css_cache_duration' => 3600, // 1 hour
        'settings_cache_duration' => 1800, // 30 minutes
        'compatibility_cache_duration' => 86400 // 24 hours
    );
    
    /**
     * Performance settings
     */
    const PERFORMANCE_SETTINGS = array(
        'enable_css_minification' => true,
        'enable_js_minification' => true,
        'enable_gzip_compression' => true,
        'enable_browser_caching' => true,
        'critical_css_inline' => true
    );
    
    /**
     * Security settings
     */
    const SECURITY_SETTINGS = array(
        'sanitize_custom_css' => true,
        'validate_color_codes' => true,
        'escape_output' => true,
        'verify_nonces' => true,
        'check_capabilities' => true
    );
    
    /**
     * Compatibility settings
     */
    const COMPATIBILITY = array(
        'themes' => array(
            'salient' => array(
                'tested' => true,
                'version' => '15.0',
                'specific_css' => true
            ),
            'storefront' => array(
                'tested' => true,
                'version' => '4.0',
                'specific_css' => false
            ),
            'astra' => array(
                'tested' => true,
                'version' => '3.0',
                'specific_css' => false
            )
        ),
        'plugins' => array(
            'woocommerce' => array(
                'min_version' => '3.0',
                'max_version' => '8.0',
                'required' => true
            ),
            'elementor' => array(
                'min_version' => '3.0',
                'max_version' => false,
                'required' => false
            ),
            'wpml' => array(
                'min_version' => '4.0',
                'max_version' => false,
                'required' => false
            )
        )
    );
    
    /**
     * Debug settings
     */
    const DEBUG_SETTINGS = array(
        'log_errors' => true,
        'log_warnings' => false,
        'log_info' => false,
        'log_file' => 'salient-woo-enhancer.log',
        'max_log_size' => 1048576 // 1MB
    );
    
    /**
     * Admin interface settings
     */
    const ADMIN_SETTINGS = array(
        'auto_save_interval' => 5000, // 5 seconds
        'preview_update_delay' => 300, // 300ms
        'form_validation_delay' => 500, // 500ms
        'enable_live_preview' => true,
        'enable_keyboard_shortcuts' => true
    );
    
    /**
     * Feature flags
     */
    const FEATURE_FLAGS = array(
        'enable_animations' => true,
        'enable_auto_save' => true,
        'enable_backup' => true,
        'enable_import_export' => true,
        'enable_analytics' => false,
        'enable_a_b_testing' => false
    );
    
    /**
     * API endpoints (if needed)
     */
    const API_ENDPOINTS = array(
        'analytics' => 'https://api.example.com/analytics',
        'support' => 'https://api.example.com/support',
        'updates' => 'https://api.example.com/updates'
    );
    
    /**
     * Get setting value with fallback to default
     */
    public static function get_setting($key, $default = null) {
        $defaults = self::get_default_settings();
        $value = get_option('salient_woo_' . $key, $default);
        
        return $value !== null ? $value : ($defaults[$key] ?? $default);
    }
    
    /**
     * Validate setting value
     */
    public static function validate_setting($key, $value) {
        // Get the setting type from key
        $type = self::get_setting_type($key);
        $rules = self::VALIDATION_RULES[$type] ?? null;
        
        if (!$rules) {
            return $value; // No validation rules, return as is
        }
        
        switch ($rules['type']) {
            case 'integer':
                $value = intval($value);
                if (isset($rules['min']) && $value < $rules['min']) {
                    $value = $rules['min'];
                }
                if (isset($rules['max']) && $value > $rules['max']) {
                    $value = $rules['max'];
                }
                break;
                
            case 'string':
                $value = sanitize_text_field($value);
                if (isset($rules['allowed']) && !in_array($value, $rules['allowed'])) {
                    $defaults = self::get_default_settings();
                    $value = $defaults[$key] ?? $rules['allowed'][0];
                }
                if (isset($rules['pattern']) && !preg_match($rules['pattern'], $value)) {
                    $defaults = self::get_default_settings();
                    $value = $defaults[$key] ?? '';
                }
                break;
        }
        
        return $value;
    }
    
    /**
     * Get setting type from key
     */
    private static function get_setting_type($key) {
        if (strpos($key, 'font_size') !== false) return 'font_size';
        if (strpos($key, 'font_weight') !== false) return 'font_weight';
        if (strpos($key, 'color') !== false) return 'color';
        if (strpos($key, 'alignment') !== false) return 'alignment';
        if (strpos($key, 'margin') !== false) return 'margin';
        if (strpos($key, 'padding') !== false) return 'padding';
        if (strpos($key, 'border_radius') !== false) return 'border_radius';
        if (strpos($key, 'max_width') !== false) return 'percentage';
        if (strpos($key, 'breakpoint') !== false) return 'breakpoint';
        
        return 'string'; // Default fallback
    }
    
    /**
     * Get all CSS selectors used by the plugin
     */
    public static function get_css_selectors() {
        return array(
            'product_info' => '.salient-custom-product-info',
            'product_title' => '.salient-product-title',
            'product_price' => '.salient-product-price',
            'button_container' => '.salient-button-container',
            'go_to_product_button' => '.salient-go-to-product',
            'woo_products' => '.woocommerce ul.products',
            'woo_product_item' => '.woocommerce ul.products li.product'
        );
    }
    
    /**
     * Get plugin capabilities required
     */
    public static function get_required_capabilities() {
        return array(
            'manage_options', // For admin settings
            'edit_theme_options', // For CSS modifications
            'manage_woocommerce' // For WooCommerce integration
        );
    }
    
    /**
     * Check if debug mode is enabled
     */
    public static function is_debug_enabled() {
        return defined('SALIENT_WOO_DEBUG') && SALIENT_WOO_DEBUG;
    }
    
    /**
     * Get log file path
     */
    public static function get_log_file_path() {
        $upload_dir = wp_upload_dir();
        return $upload_dir['basedir'] . '/' . self::DEBUG_SETTINGS['log_file'];
    }
    
    /**
     * Get cache keys used by the plugin
     */
    public static function get_cache_keys() {
        return array(
            'css_cache' => 'salient_woo_css_cache',
            'settings_cache' => 'salient_woo_settings_cache',
            'compatibility_cache' => 'salient_woo_compatibility_cache'
        );
    }
}

// Define global constants if not already defined
if (!defined('SALIENT_WOO_VERSION')) {
    define('SALIENT_WOO_VERSION', Salient_WooCommerce_Enhancer_Config::VERSION);
}

if (!defined('SALIENT_WOO_PLUGIN_URL')) {
    define('SALIENT_WOO_PLUGIN_URL', Salient_WooCommerce_Enhancer_Config::get_plugin_url());
}

if (!defined('SALIENT_WOO_PLUGIN_PATH')) {
    define('SALIENT_WOO_PLUGIN_PATH', Salient_WooCommerce_Enhancer_Config::get_plugin_path());
}

// Debug mode check
if (!defined('SALIENT_WOO_DEBUG')) {
    define('SALIENT_WOO_DEBUG', WP_DEBUG && WP_DEBUG_LOG);
}

// Performance mode
if (!defined('SALIENT_WOO_PERFORMANCE_MODE')) {
    define('SALIENT_WOO_PERFORMANCE_MODE', !WP_DEBUG);
}
?>