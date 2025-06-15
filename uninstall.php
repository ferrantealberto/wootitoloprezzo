<?php
/**
 * Uninstall Script for Salient WooCommerce Product Display Enhancer
 * 
 * This file is executed when the plugin is deleted from the WordPress admin.
 * It cleans up all plugin data from the database.
 * 
 * @package Salient_WooCommerce_Product_Display_Enhancer
 * @version 2.0.0
 */

// Exit if accessed directly or not during uninstall
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

/**
 * Clean up plugin data on uninstall
 */
class Salient_WooCommerce_Enhancer_Uninstaller {
    
    /**
     * Run the uninstall process
     */
    public static function uninstall() {
        // Check if user has permission to delete plugins
        if (!current_user_can('delete_plugins')) {
            return;
        }
        
        // Delete all plugin options
        self::delete_plugin_options();
        
        // Clear any cached data
        self::clear_cache();
        
        // Remove any custom database tables if created (none in this plugin)
        // self::drop_custom_tables();
        
        // Clear any transients
        self::clear_transients();
        
        // Log uninstall if debugging is enabled
        self::log_uninstall();
    }
    
    /**
     * Delete all plugin options from wp_options table
     */
    private static function delete_plugin_options() {
        $options_to_delete = array(
            // Title Settings
            'salient_woo_title_font_size_desktop',
            'salient_woo_title_font_size_tablet', 
            'salient_woo_title_font_size_mobile',
            'salient_woo_title_font_weight',
            'salient_woo_title_color',
            'salient_woo_title_alignment',
            'salient_woo_title_margin_bottom',
            
            // Price Settings
            'salient_woo_price_font_size_desktop',
            'salient_woo_price_font_size_tablet',
            'salient_woo_price_font_size_mobile',
            'salient_woo_price_font_weight',
            'salient_woo_price_color',
            'salient_woo_price_alignment',
            'salient_woo_price_margin_bottom',
            
            // Button Settings
            'salient_woo_button_text',
            'salient_woo_button_font_size_desktop',
            'salient_woo_button_font_size_tablet',
            'salient_woo_button_font_size_mobile',
            'salient_woo_button_bg_color',
            'salient_woo_button_text_color',
            'salient_woo_button_hover_bg_color',
            'salient_woo_button_border_radius',
            'salient_woo_button_padding_horizontal',
            'salient_woo_button_padding_vertical',
            'salient_woo_button_margin_left',
            'salient_woo_button_alignment',
            
            // Container Settings
            'salient_woo_container_padding',
            'salient_woo_container_margin_top',
            'salient_woo_container_max_width',
            
            // Responsive Settings
            'salient_woo_mobile_breakpoint',
            'salient_woo_tablet_breakpoint',
            'salient_woo_enable_responsive',
            
            // Advanced Settings
            'salient_woo_hide_original_elements',
            'salient_woo_custom_css',
            
            // Plugin Meta
            'salient_woo_plugin_version',
            'salient_woo_installed_date',
            'salient_woo_last_updated'
        );
        
        // Delete each option
        foreach ($options_to_delete as $option) {
            delete_option($option);
        }
        
        // Delete any options that might have been added with prefixes
        global $wpdb;
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
                'salient_woo_%'
            )
        );
    }
    
    /**
     * Clear any cached data
     */
    private static function clear_cache() {
        // Clear WordPress object cache
        wp_cache_flush();
        
        // Clear any specific cache groups if using custom caching
        wp_cache_delete('salient_woo_settings', 'salient_woo');
        wp_cache_delete('salient_woo_css_cache', 'salient_woo');
        
        // If using third-party caching plugins, trigger cache clear
        if (function_exists('rocket_clean_domain')) {
            rocket_clean_domain(); // WP Rocket
        }
        
        if (function_exists('w3tc_flush_all')) {
            w3tc_flush_all(); // W3 Total Cache
        }
        
        if (function_exists('wp_cache_clear_cache')) {
            wp_cache_clear_cache(); // WP Super Cache
        }
        
        if (class_exists('LiteSpeed_Cache_API')) {
            LiteSpeed_Cache_API::purge_all(); // LiteSpeed Cache
        }
    }
    
    /**
     * Clear any transients set by the plugin
     */
    private static function clear_transients() {
        // Delete specific transients
        delete_transient('salient_woo_css_cache');
        delete_transient('salient_woo_settings_cache');
        delete_transient('salient_woo_compatibility_check');
        
        // Clean up any site transients
        delete_site_transient('salient_woo_global_cache');
        
        // Remove any expired transients with our prefix
        global $wpdb;
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
                '_transient_salient_woo_%',
                '_transient_timeout_salient_woo_%'
            )
        );
        
        // Clean up site transients
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
                '_site_transient_salient_woo_%',
                '_site_transient_timeout_salient_woo_%'
            )
        );
    }
    
    /**
     * Remove any custom database tables (none in this plugin, but kept for future use)
     */
    private static function drop_custom_tables() {
        global $wpdb;
        
        // Example if we had custom tables:
        // $table_name = $wpdb->prefix . 'salient_woo_custom_table';
        // $wpdb->query("DROP TABLE IF EXISTS {$table_name}");
    }
    
    /**
     * Clean up user meta related to the plugin
     */
    private static function clean_user_meta() {
        global $wpdb;
        
        // Remove any user meta keys related to the plugin
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->usermeta} WHERE meta_key LIKE %s",
                'salient_woo_%'
            )
        );
    }
    
    /**
     * Clean up post meta if any was set by the plugin
     */
    private static function clean_post_meta() {
        global $wpdb;
        
        // Remove any post meta keys related to the plugin
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE %s",
                'salient_woo_%'
            )
        );
    }
    
    /**
     * Log the uninstall process for debugging
     */
    private static function log_uninstall() {
        // Only log if debugging is enabled
        if (defined('SALIENT_WOO_DEBUG') && SALIENT_WOO_DEBUG) {
            error_log('Salient WooCommerce Product Display Enhancer: Plugin uninstalled and data cleaned up.');
        }
        
        // Could also write to a custom log file
        $log_file = WP_CONTENT_DIR . '/salient-woo-uninstall.log';
        $log_message = date('Y-m-d H:i:s') . " - Salient WooCommerce Enhancer uninstalled\n";
        
        // Only write log if the directory is writable
        if (is_writable(WP_CONTENT_DIR)) {
            file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);
        }
    }
    
    /**
     * Send anonymous usage data on uninstall (optional, with user consent)
     */
    private static function send_uninstall_feedback() {
        // Only send if user previously opted in to usage tracking
        if (get_option('salient_woo_allow_tracking', false)) {
            $data = array(
                'action' => 'uninstall',
                'plugin_version' => '2.0.0',
                'wp_version' => get_bloginfo('version'),
                'php_version' => PHP_VERSION,
                'site_url' => home_url(),
                'timestamp' => time()
            );
            
            // Send data asynchronously
            wp_remote_post('https://your-analytics-endpoint.com/uninstall', array(
                'timeout' => 5,
                'blocking' => false,
                'body' => $data
            ));
        }
    }
    
    /**
     * Create backup of settings before deletion (optional)
     */
    private static function backup_settings() {
        $backup_enabled = get_option('salient_woo_backup_on_uninstall', false);
        
        if ($backup_enabled) {
            $all_settings = array();
            
            // Collect all plugin settings
            $option_names = array(
                'salient_woo_title_font_size_desktop',
                'salient_woo_title_font_size_tablet',
                'salient_woo_title_font_size_mobile',
                // ... add all other options
            );
            
            foreach ($option_names as $option) {
                $all_settings[$option] = get_option($option);
            }
            
            // Save to uploads directory
            $upload_dir = wp_upload_dir();
            $backup_file = $upload_dir['basedir'] . '/salient-woo-backup-' . date('Y-m-d-H-i-s') . '.json';
            
            file_put_contents($backup_file, json_encode($all_settings, JSON_PRETTY_PRINT));
        }
    }
}

// Only run uninstall if this is a proper uninstall request
if (defined('WP_UNINSTALL_PLUGIN') && WP_UNINSTALL_PLUGIN) {
    // Optional: Create backup before uninstall
    Salient_WooCommerce_Enhancer_Uninstaller::backup_settings();
    
    // Run the main uninstall process
    Salient_WooCommerce_Enhancer_Uninstaller::uninstall();
    
    // Optional: Send anonymous feedback
    // Salient_WooCommerce_Enhancer_Uninstaller::send_uninstall_feedback();
}

// Clean up any remaining traces
unset($GLOBALS['salient_woo_settings']);

// Final cleanup
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}

// Log completion
if (defined('SALIENT_WOO_DEBUG') && SALIENT_WOO_DEBUG) {
    error_log('Salient WooCommerce Product Display Enhancer: Uninstall completed successfully.');
}
?>