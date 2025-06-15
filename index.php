<?php
/**
 * Plugin Name: Salient WooCommerce Product Display Enhancer - Responsive
 * Plugin URI: https://example.com/plugins/salient-woocommerce-product-display-enhancer
 * Description: Plugin WooCommerce avanzato per il tema Salient con controlli completi dal backend e design responsive per tutti i dispositivi.
 * Version: 2.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * Text Domain: salient-woocommerce-product-display-enhancer
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * WC requires at least: 3.0
 * WC tested up to: 8.0
 *
 * @package Salient_WooCommerce_Product_Display_Enhancer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Salient_WooCommerce_Product_Display_Enhancer {

    /**
     * Constructor.
     */
    public function __construct() {
        // Check if WooCommerce is active
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            
            // Initialize plugin
            add_action('init', array($this, 'init'));
            
            // Add admin menu
            add_action('admin_menu', array($this, 'add_admin_menu'));
            
            // Register settings
            add_action('admin_init', array($this, 'register_settings'));
            
            // Add admin scripts and styles
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
            
            // Remove default WooCommerce elements
            $this->remove_default_elements();
            
            // Add custom elements
            $this->add_custom_elements();
            
            // Add custom CSS
            add_action('wp_head', array($this, 'add_custom_css'));
            
            // Add responsive CSS
            add_action('wp_head', array($this, 'add_responsive_css'));
            
            // Load Google Fonts if Poppins is selected
            add_action('wp_enqueue_scripts', array($this, 'enqueue_google_fonts'));
        }
    }

    /**
     * Initialize plugin.
     */
    public function init() {
        // Set default options if they don't exist
        $this->set_default_options();
    }

    /**
     * Set default plugin options.
     */
    private function set_default_options() {
        $defaults = array(
            // Title Settings
            'title_font_size_desktop' => '18',
            'title_font_size_tablet' => '16',
            'title_font_size_mobile' => '14',
            'title_font_weight' => '600',
            'title_font_family' => 'inherit',
            'title_color' => '#333333',
            'title_alignment' => 'center',
            'title_margin_bottom' => '8',
            
            // Price Settings
            'price_font_size_desktop' => '16',
            'price_font_size_tablet' => '14',
            'price_font_size_mobile' => '13',
            'price_font_weight' => '500',
            'price_font_family' => 'inherit',
            'price_color' => '#e74c3c',
            'price_alignment' => 'center',
            'price_margin_bottom' => '12',
            
            // Button Settings
            'button_text' => 'Vai al prodotto',
            'button_font_size_desktop' => '14',
            'button_font_size_tablet' => '13',
            'button_font_size_mobile' => '12',
            'button_font_family' => 'inherit',
            'button_bg_color' => '#3498db',
            'button_text_color' => '#ffffff',
            'button_hover_bg_color' => '#2980b9',
            'button_border_radius' => '4',
            'button_padding_horizontal' => '16',
            'button_padding_vertical' => '10',
            'button_margin_left' => '8',
            'button_alignment' => 'center',
            
            // Container Settings
            'container_padding' => '12',
            'container_margin_top' => '10',
            'container_max_width' => '100',
            
            // Responsive Settings
            'mobile_breakpoint' => '768',
            'tablet_breakpoint' => '1024',
            'enable_responsive' => '1',
            
            // Advanced Settings
            'hide_original_elements' => '1',
            'custom_css' => ''
        );

        foreach ($defaults as $option => $value) {
            if (get_option('salient_woo_' . $option) === false) {
                update_option('salient_woo_' . $option, $value);
            }
        }
    }

    /**
     * Enqueue Google Fonts if needed
     */
    public function enqueue_google_fonts() {
        $fonts_needed = array();
        
        // Check if any element uses Poppins
        if (get_option('salient_woo_title_font_family') === 'Poppins' ||
            get_option('salient_woo_price_font_family') === 'Poppins' ||
            get_option('salient_woo_button_font_family') === 'Poppins') {
            $fonts_needed[] = 'Poppins:300,400,500,600,700';
        }
        
        // Enqueue Google Fonts if needed
        if (!empty($fonts_needed)) {
            wp_enqueue_style(
                'salient-woo-google-fonts',
                'https://fonts.googleapis.com/css2?family=' . implode('&family=', $fonts_needed) . '&display=swap',
                array(),
                '1.0'
            );
        }
    }

    /**
     * Remove default WooCommerce elements.
     */
    private function remove_default_elements() {
        if (get_option('salient_woo_hide_original_elements', '1') === '1') {
            remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            
            // Remove Salient theme specific elements
            add_action('init', array($this, 'remove_theme_elements'));
        }
    }

    /**
     * Remove theme specific elements.
     */
    public function remove_theme_elements() {
        remove_action('nectar_woo_shop_loop_item_price', 'woocommerce_template_loop_price', 10);
        remove_action('nectar_woo_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
    }

    /**
     * Add custom elements.
     */
    private function add_custom_elements() {
        add_action('woocommerce_after_shop_loop_item', array($this, 'add_product_info_container'), 5);
        add_action('woocommerce_after_shop_loop_item', array($this, 'add_go_to_product_button'), 11);
    }

    /**
     * Add product info container with title and price.
     */
    public function add_product_info_container() {
        global $product;
        
        if (!$product) {
            return;
        }
        
        echo '<div class="salient-custom-product-info">';
        echo '<h2 class="salient-product-title">' . esc_html(get_the_title()) . '</h2>';
        echo '<div class="salient-product-price">' . $product->get_price_html() . '</div>';
        echo '</div>';
    }

    /**
     * Add "Go to Product" button.
     */
    public function add_go_to_product_button() {
        global $product;
        
        if (!$product) {
            return;
        }
        
        $button_text = get_option('salient_woo_button_text', 'Vai al prodotto');
        
        echo '<div class="salient-button-container">';
        echo '<a href="' . esc_url(get_permalink($product->get_id())) . '" class="button salient-go-to-product">' . esc_html($button_text) . '</a>';
        echo '</div>';
    }

    /**
     * Get alignment value for CSS (converts text alignment to flex alignment)
     */
    private function get_flex_alignment($alignment) {
        switch ($alignment) {
            case 'left':
                return 'flex-start';
            case 'right':
                return 'flex-end';
            case 'center':
            default:
                return 'center';
        }
    }

    /**
     * Add custom CSS based on admin settings.
     */
    public function add_custom_css() {
        $css = $this->generate_css();
        
        if (!empty($css)) {
            echo '<style type="text/css" id="salient-woo-custom-css">' . $css . '</style>';
        }
    }

    /**
     * Add responsive CSS.
     */
    public function add_responsive_css() {
        if (get_option('salient_woo_enable_responsive', '1') === '1') {
            $responsive_css = $this->generate_responsive_css();
            
            if (!empty($responsive_css)) {
                echo '<style type="text/css" id="salient-woo-responsive-css">' . $responsive_css . '</style>';
            }
        }
    }

    /**
     * Generate main CSS based on settings.
     */
    private function generate_css() {
        ob_start();
        ?>
        
        /* Salient Product Enhancer - Custom Styles */
        .salient-custom-product-info {
            padding: <?php echo esc_attr(get_option('salient_woo_container_padding', '12')); ?>px 0;
            text-align: <?php echo esc_attr(get_option('salient_woo_title_alignment', 'center')); ?>;
            width: 100%;
            max-width: <?php echo esc_attr(get_option('salient_woo_container_max_width', '100')); ?>%;
            margin: <?php echo esc_attr(get_option('salient_woo_container_margin_top', '10')); ?>px auto 0;
            box-sizing: border-box;
        }
        
        .salient-product-title {
            font-size: <?php echo esc_attr(get_option('salient_woo_title_font_size_desktop', '18')); ?>px !important;
            font-weight: <?php echo esc_attr(get_option('salient_woo_title_font_weight', '600')); ?> !important;
            font-family: <?php echo esc_attr(get_option('salient_woo_title_font_family', 'inherit')); ?> !important;
            margin-bottom: <?php echo esc_attr(get_option('salient_woo_title_margin_bottom', '8')); ?>px !important;
            color: <?php echo esc_attr(get_option('salient_woo_title_color', '#333333')); ?> !important;
            text-align: <?php echo esc_attr(get_option('salient_woo_title_alignment', 'center')); ?> !important;
            line-height: 1.4 !important;
            margin-top: 0 !important;
            padding: 0 !important;
        }
        
        .salient-product-price {
            font-size: <?php echo esc_attr(get_option('salient_woo_price_font_size_desktop', '16')); ?>px !important;
            color: <?php echo esc_attr(get_option('salient_woo_price_color', '#e74c3c')); ?> !important;
            font-weight: <?php echo esc_attr(get_option('salient_woo_price_font_weight', '500')); ?> !important;
            font-family: <?php echo esc_attr(get_option('salient_woo_price_font_family', 'inherit')); ?> !important;
            margin-bottom: <?php echo esc_attr(get_option('salient_woo_price_margin_bottom', '12')); ?>px !important;
            text-align: <?php echo esc_attr(get_option('salient_woo_price_alignment', 'center')); ?> !important;
            line-height: 1.4 !important;
        }
        
        /* CORREZIONE ALLINEAMENTO PULSANTE - Sovrascrive CSS statico */
        .salient-button-container,
        .woocommerce ul.products li.product .salient-button-container {
            text-align: <?php echo esc_attr(get_option('salient_woo_button_alignment', 'center')); ?> !important;
            justify-content: <?php echo esc_attr($this->get_flex_alignment(get_option('salient_woo_button_alignment', 'center'))); ?> !important;
            margin-top: 10px;
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 8px !important;
        }
        
        .salient-go-to-product {
            margin-left: <?php echo esc_attr(get_option('salient_woo_button_margin_left', '8')); ?>px !important;
            background-color: <?php echo esc_attr(get_option('salient_woo_button_bg_color', '#3498db')); ?> !important;
            color: <?php echo esc_attr(get_option('salient_woo_button_text_color', '#ffffff')); ?> !important;
            border-radius: <?php echo esc_attr(get_option('salient_woo_button_border_radius', '4')); ?>px !important;
            padding: <?php echo esc_attr(get_option('salient_woo_button_padding_vertical', '10')); ?>px <?php echo esc_attr(get_option('salient_woo_button_padding_horizontal', '16')); ?>px !important;
            font-size: <?php echo esc_attr(get_option('salient_woo_button_font_size_desktop', '14')); ?>px !important;
            font-family: <?php echo esc_attr(get_option('salient_woo_button_font_family', 'inherit')); ?> !important;
            text-decoration: none !important;
            display: inline-block !important;
            transition: all 0.3s ease !important;
            border: none !important;
            cursor: pointer !important;
        }
        
        .salient-go-to-product:hover {
            background-color: <?php echo esc_attr(get_option('salient_woo_button_hover_bg_color', '#2980b9')); ?> !important;
            color: <?php echo esc_attr(get_option('salient_woo_button_text_color', '#ffffff')); ?> !important;
            text-decoration: none !important;
        }
        
        <?php if (get_option('salient_woo_hide_original_elements', '1') === '1'): ?>
        /* Hide original WooCommerce elements */
        .woocommerce ul.products li.product h2.woocommerce-loop-product__title,
        .woocommerce ul.products li.product .price,
        .product-meta {
            display: none !important;
        }
        <?php endif; ?>
        
        /* Button alignment fixes with correct margin handling */
        .woocommerce ul.products li.product .add_to_cart_button,
        .woocommerce ul.products li.product .salient-go-to-product {
            display: inline-block !important;
            vertical-align: top !important;
        }
        
        /* Special margin handling for left alignment */
        <?php if (get_option('salient_woo_button_alignment', 'center') === 'left'): ?>
        .salient-button-container .salient-go-to-product {
            margin-left: 0 !important;
            margin-right: <?php echo esc_attr(get_option('salient_woo_button_margin_left', '8')); ?>px !important;
        }
        <?php elseif (get_option('salient_woo_button_alignment', 'center') === 'center'): ?>
        .salient-button-container .salient-go-to-product {
            margin-left: <?php echo esc_attr(get_option('salient_woo_button_margin_left', '8')); ?>px !important;
            margin-right: 0 !important;
        }
        <?php endif; ?>
        
        /* Ensure our custom elements are shown */
        .salient-custom-product-info {
            display: block !important;
        }
        
        <?php
        $custom_css = get_option('salient_woo_custom_css', '');
        if (!empty($custom_css)) {
            echo "/* Custom CSS */\n" . wp_strip_all_tags($custom_css);
        }
        ?>
        
        <?php
        return ob_get_clean();
    }

    /**
     * Generate responsive CSS.
     */
    private function generate_responsive_css() {
        $mobile_breakpoint = get_option('salient_woo_mobile_breakpoint', '768');
        $tablet_breakpoint = get_option('salient_woo_tablet_breakpoint', '1024');
        
        ob_start();
        ?>
        
        /* Tablet Styles */
        @media (max-width: <?php echo esc_attr($tablet_breakpoint); ?>px) {
            .salient-product-title {
                font-size: <?php echo esc_attr(get_option('salient_woo_title_font_size_tablet', '16')); ?>px !important;
            }
            
            .salient-product-price {
                font-size: <?php echo esc_attr(get_option('salient_woo_price_font_size_tablet', '14')); ?>px !important;
            }
            
            .salient-go-to-product {
                font-size: <?php echo esc_attr(get_option('salient_woo_button_font_size_tablet', '13')); ?>px !important;
                padding: <?php echo esc_attr(get_option('salient_woo_button_padding_vertical', '10') - 1); ?>px <?php echo esc_attr(get_option('salient_woo_button_padding_horizontal', '16') - 2); ?>px !important;
            }
            
            .salient-custom-product-info {
                padding: <?php echo esc_attr(get_option('salient_woo_container_padding', '12') - 2); ?>px 0;
            }
            
            /* Maintain alignment on tablet */
            .salient-button-container,
            .woocommerce ul.products li.product .salient-button-container {
                justify-content: <?php echo esc_attr($this->get_flex_alignment(get_option('salient_woo_button_alignment', 'center'))); ?> !important;
            }
        }
        
        /* Mobile Styles */
        @media (max-width: <?php echo esc_attr($mobile_breakpoint); ?>px) {
            .salient-product-title {
                font-size: <?php echo esc_attr(get_option('salient_woo_title_font_size_mobile', '14')); ?>px !important;
                line-height: 1.3 !important;
                margin-bottom: <?php echo esc_attr(get_option('salient_woo_title_margin_bottom', '8') - 2); ?>px !important;
            }
            
            .salient-product-price {
                font-size: <?php echo esc_attr(get_option('salient_woo_price_font_size_mobile', '13')); ?>px !important;
                margin-bottom: <?php echo esc_attr(get_option('salient_woo_price_margin_bottom', '12') - 2); ?>px !important;
            }
            
            .salient-go-to-product {
                font-size: <?php echo esc_attr(get_option('salient_woo_button_font_size_mobile', '12')); ?>px !important;
                padding: <?php echo esc_attr(get_option('salient_woo_button_padding_vertical', '10') - 2); ?>px <?php echo esc_attr(get_option('salient_woo_button_padding_horizontal', '16') - 4); ?>px !important;
                margin-left: <?php echo esc_attr(get_option('salient_woo_button_margin_left', '8') - 2); ?>px !important;
            }
            
            .salient-custom-product-info {
                padding: <?php echo esc_attr(get_option('salient_woo_container_padding', '12') - 4); ?>px 0;
                margin: <?php echo esc_attr(get_option('salient_woo_container_margin_top', '10') - 2); ?>px auto 0;
            }
            
            .salient-button-container {
                margin-top: 8px;
            }
            
            /* Maintain alignment on mobile */
            .salient-button-container,
            .woocommerce ul.products li.product .salient-button-container {
                justify-content: <?php echo esc_attr($this->get_flex_alignment(get_option('salient_woo_button_alignment', 'center'))); ?> !important;
                flex-direction: column !important;
            }
            
            /* Make buttons stack on mobile if needed */
            .woocommerce ul.products li.product .add_to_cart_button,
            .woocommerce ul.products li.product .salient-go-to-product {
                display: block !important;
                width: 100% !important;
                margin: 5px 0 !important;
                text-align: center !important;
            }
        }
        
        /* Extra small mobile devices */
        @media (max-width: 480px) {
            .salient-product-title {
                font-size: <?php echo esc_attr(get_option('salient_woo_title_font_size_mobile', '14') - 1); ?>px !important;
            }
            
            .salient-product-price {
                font-size: <?php echo esc_attr(get_option('salient_woo_price_font_size_mobile', '13') - 1); ?>px !important;
            }
            
            .salient-go-to-product {
                font-size: <?php echo esc_attr(get_option('salient_woo_button_font_size_mobile', '12') - 1); ?>px !important;
                padding: 8px 12px !important;
            }
        }
        
        <?php
        return ob_get_clean();
    }

    /**
     * Add admin menu.
     */
    public function add_admin_menu() {
        add_options_page(
            'Salient WooCommerce Enhancer',
            'Salient WooCommerce',
            'manage_options',
            'salient-woo-enhancer',
            array($this, 'admin_page')
        );
    }

    /**
     * Register plugin settings.
     */
    public function register_settings() {
        // Title Settings
        register_setting('salient_woo_settings', 'salient_woo_title_font_size_desktop');
        register_setting('salient_woo_settings', 'salient_woo_title_font_size_tablet');
        register_setting('salient_woo_settings', 'salient_woo_title_font_size_mobile');
        register_setting('salient_woo_settings', 'salient_woo_title_font_weight');
        register_setting('salient_woo_settings', 'salient_woo_title_font_family');
        register_setting('salient_woo_settings', 'salient_woo_title_color');
        register_setting('salient_woo_settings', 'salient_woo_title_alignment');
        register_setting('salient_woo_settings', 'salient_woo_title_margin_bottom');
        
        // Price Settings
        register_setting('salient_woo_settings', 'salient_woo_price_font_size_desktop');
        register_setting('salient_woo_settings', 'salient_woo_price_font_size_tablet');
        register_setting('salient_woo_settings', 'salient_woo_price_font_size_mobile');
        register_setting('salient_woo_settings', 'salient_woo_price_font_weight');
        register_setting('salient_woo_settings', 'salient_woo_price_font_family');
        register_setting('salient_woo_settings', 'salient_woo_price_color');
        register_setting('salient_woo_settings', 'salient_woo_price_alignment');
        register_setting('salient_woo_settings', 'salient_woo_price_margin_bottom');
        
        // Button Settings
        register_setting('salient_woo_settings', 'salient_woo_button_text');
        register_setting('salient_woo_settings', 'salient_woo_button_font_size_desktop');
        register_setting('salient_woo_settings', 'salient_woo_button_font_size_tablet');
        register_setting('salient_woo_settings', 'salient_woo_button_font_size_mobile');
        register_setting('salient_woo_settings', 'salient_woo_button_font_family');
        register_setting('salient_woo_settings', 'salient_woo_button_bg_color');
        register_setting('salient_woo_settings', 'salient_woo_button_text_color');
        register_setting('salient_woo_settings', 'salient_woo_button_hover_bg_color');
        register_setting('salient_woo_settings', 'salient_woo_button_border_radius');
        register_setting('salient_woo_settings', 'salient_woo_button_padding_horizontal');
        register_setting('salient_woo_settings', 'salient_woo_button_padding_vertical');
        register_setting('salient_woo_settings', 'salient_woo_button_margin_left');
        register_setting('salient_woo_settings', 'salient_woo_button_alignment');
        
        // Container Settings
        register_setting('salient_woo_settings', 'salient_woo_container_padding');
        register_setting('salient_woo_settings', 'salient_woo_container_margin_top');
        register_setting('salient_woo_settings', 'salient_woo_container_max_width');
        
        // Responsive Settings
        register_setting('salient_woo_settings', 'salient_woo_mobile_breakpoint');
        register_setting('salient_woo_settings', 'salient_woo_tablet_breakpoint');
        register_setting('salient_woo_settings', 'salient_woo_enable_responsive');
        
        // Advanced Settings
        register_setting('salient_woo_settings', 'salient_woo_hide_original_elements');
        register_setting('salient_woo_settings', 'salient_woo_custom_css');
    }

    /**
     * Admin page content.
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>Salient WooCommerce Product Display Enhancer</h1>
            
            <div class="salient-admin-container">
                <form method="post" action="options.php">
                    <?php settings_fields('salient_woo_settings'); ?>
                    <?php do_settings_sections('salient_woo_settings'); ?>
                    
                    <div class="salient-tabs">
                        <div class="salient-tab-nav">
                            <button type="button" class="salient-tab-button active" data-tab="title">Titolo Prodotto</button>
                            <button type="button" class="salient-tab-button" data-tab="price">Prezzo</button>
                            <button type="button" class="salient-tab-button" data-tab="button">Pulsante</button>
                            <button type="button" class="salient-tab-button" data-tab="container">Container</button>
                            <button type="button" class="salient-tab-button" data-tab="responsive">Responsive</button>
                            <button type="button" class="salient-tab-button" data-tab="advanced">Avanzate</button>
                        </div>
                        
                        <!-- Title Settings Tab -->
                        <div id="tab-title" class="salient-tab-content active">
                            <h2>Impostazioni Titolo Prodotto</h2>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">Font Family</th>
                                    <td>
                                        <select name="salient_woo_title_font_family">
                                            <option value="inherit" <?php selected(get_option('salient_woo_title_font_family', 'inherit'), 'inherit'); ?>>Eredita dal tema</option>
                                            <option value="Arial, sans-serif" <?php selected(get_option('salient_woo_title_font_family', 'inherit'), 'Arial, sans-serif'); ?>>Arial</option>
                                            <option value="Helvetica, sans-serif" <?php selected(get_option('salient_woo_title_font_family', 'inherit'), 'Helvetica, sans-serif'); ?>>Helvetica</option>
                                            <option value="Georgia, serif" <?php selected(get_option('salient_woo_title_font_family', 'inherit'), 'Georgia, serif'); ?>>Georgia</option>
                                            <option value="Times, serif" <?php selected(get_option('salient_woo_title_font_family', 'inherit'), 'Times, serif'); ?>>Times</option>
                                            <option value="Poppins, sans-serif" <?php selected(get_option('salient_woo_title_font_family', 'inherit'), 'Poppins, sans-serif'); ?>>Poppins</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Dimensione Font Desktop (px)</th>
                                    <td><input type="number" name="salient_woo_title_font_size_desktop" value="<?php echo esc_attr(get_option('salient_woo_title_font_size_desktop', '18')); ?>" min="10" max="50" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Dimensione Font Tablet (px)</th>
                                    <td><input type="number" name="salient_woo_title_font_size_tablet" value="<?php echo esc_attr(get_option('salient_woo_title_font_size_tablet', '16')); ?>" min="10" max="50" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Dimensione Font Mobile (px)</th>
                                    <td><input type="number" name="salient_woo_title_font_size_mobile" value="<?php echo esc_attr(get_option('salient_woo_title_font_size_mobile', '14')); ?>" min="10" max="50" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Peso Font</th>
                                    <td>
                                        <select name="salient_woo_title_font_weight">
                                            <option value="300" <?php selected(get_option('salient_woo_title_font_weight', '600'), '300'); ?>>Light (300)</option>
                                            <option value="400" <?php selected(get_option('salient_woo_title_font_weight', '600'), '400'); ?>>Normal (400)</option>
                                            <option value="500" <?php selected(get_option('salient_woo_title_font_weight', '600'), '500'); ?>>Medium (500)</option>
                                            <option value="600" <?php selected(get_option('salient_woo_title_font_weight', '600'), '600'); ?>>Semi-Bold (600)</option>
                                            <option value="700" <?php selected(get_option('salient_woo_title_font_weight', '600'), '700'); ?>>Bold (700)</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Colore Titolo</th>
                                    <td><input type="color" name="salient_woo_title_color" value="<?php echo esc_attr(get_option('salient_woo_title_color', '#333333')); ?>" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Allineamento</th>
                                    <td>
                                        <select name="salient_woo_title_alignment">
                                            <option value="left" <?php selected(get_option('salient_woo_title_alignment', 'center'), 'left'); ?>>Sinistra</option>
                                            <option value="center" <?php selected(get_option('salient_woo_title_alignment', 'center'), 'center'); ?>>Centro</option>
                                            <option value="right" <?php selected(get_option('salient_woo_title_alignment', 'center'), 'right'); ?>>Destra</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Margine Inferiore (px)</th>
                                    <td><input type="number" name="salient_woo_title_margin_bottom" value="<?php echo esc_attr(get_option('salient_woo_title_margin_bottom', '8')); ?>" min="0" max="50" /></td>
                                </tr>
                            </table>
                        </div>
                        
                        <!-- Price Settings Tab -->
                        <div id="tab-price" class="salient-tab-content">
                            <h2>Impostazioni Prezzo</h2>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">Font Family</th>
                                    <td>
                                        <select name="salient_woo_price_font_family">
                                            <option value="inherit" <?php selected(get_option('salient_woo_price_font_family', 'inherit'), 'inherit'); ?>>Eredita dal tema</option>
                                            <option value="Arial, sans-serif" <?php selected(get_option('salient_woo_price_font_family', 'inherit'), 'Arial, sans-serif'); ?>>Arial</option>
                                            <option value="Helvetica, sans-serif" <?php selected(get_option('salient_woo_price_font_family', 'inherit'), 'Helvetica, sans-serif'); ?>>Helvetica</option>
                                            <option value="Georgia, serif" <?php selected(get_option('salient_woo_price_font_family', 'inherit'), 'Georgia, serif'); ?>>Georgia</option>
                                            <option value="Times, serif" <?php selected(get_option('salient_woo_price_font_family', 'inherit'), 'Times, serif'); ?>>Times</option>
                                            <option value="Poppins, sans-serif" <?php selected(get_option('salient_woo_price_font_family', 'inherit'), 'Poppins, sans-serif'); ?>>Poppins</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Dimensione Font Desktop (px)</th>
                                    <td><input type="number" name="salient_woo_price_font_size_desktop" value="<?php echo esc_attr(get_option('salient_woo_price_font_size_desktop', '16')); ?>" min="10" max="50" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Dimensione Font Tablet (px)</th>
                                    <td><input type="number" name="salient_woo_price_font_size_tablet" value="<?php echo esc_attr(get_option('salient_woo_price_font_size_tablet', '14')); ?>" min="10" max="50" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Dimensione Font Mobile (px)</th>
                                    <td><input type="number" name="salient_woo_price_font_size_mobile" value="<?php echo esc_attr(get_option('salient_woo_price_font_size_mobile', '13')); ?>" min="10" max="50" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Peso Font</th>
                                    <td>
                                        <select name="salient_woo_price_font_weight">
                                            <option value="300" <?php selected(get_option('salient_woo_price_font_weight', '500'), '300'); ?>>Light (300)</option>
                                            <option value="400" <?php selected(get_option('salient_woo_price_font_weight', '500'), '400'); ?>>Normal (400)</option>
                                            <option value="500" <?php selected(get_option('salient_woo_price_font_weight', '500'), '500'); ?>>Medium (500)</option>
                                            <option value="600" <?php selected(get_option('salient_woo_price_font_weight', '500'), '600'); ?>>Semi-Bold (600)</option>
                                            <option value="700" <?php selected(get_option('salient_woo_price_font_weight', '500'), '700'); ?>>Bold (700)</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Colore Prezzo</th>
                                    <td><input type="color" name="salient_woo_price_color" value="<?php echo esc_attr(get_option('salient_woo_price_color', '#e74c3c')); ?>" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Allineamento</th>
                                    <td>
                                        <select name="salient_woo_price_alignment">
                                            <option value="left" <?php selected(get_option('salient_woo_price_alignment', 'center'), 'left'); ?>>Sinistra</option>
                                            <option value="center" <?php selected(get_option('salient_woo_price_alignment', 'center'), 'center'); ?>>Centro</option>
                                            <option value="right" <?php selected(get_option('salient_woo_price_alignment', 'center'), 'right'); ?>>Destra</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Margine Inferiore (px)</th>
                                    <td><input type="number" name="salient_woo_price_margin_bottom" value="<?php echo esc_attr(get_option('salient_woo_price_margin_bottom', '12')); ?>" min="0" max="50" /></td>
                                </tr>
                            </table>
                        </div>
                        
                        <!-- Button Settings Tab -->
                        <div id="tab-button" class="salient-tab-content">
                            <h2>Impostazioni Pulsante</h2>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">Testo Pulsante</th>
                                    <td><input type="text" name="salient_woo_button_text" value="<?php echo esc_attr(get_option('salient_woo_button_text', 'Vai al prodotto')); ?>" class="regular-text" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Font Family</th>
                                    <td>
                                        <select name="salient_woo_button_font_family">
                                            <option value="inherit" <?php selected(get_option('salient_woo_button_font_family', 'inherit'), 'inherit'); ?>>Eredita dal tema</option>
                                            <option value="Arial, sans-serif" <?php selected(get_option('salient_woo_button_font_family', 'inherit'), 'Arial, sans-serif'); ?>>Arial</option>
                                            <option value="Helvetica, sans-serif" <?php selected(get_option('salient_woo_button_font_family', 'inherit'), 'Helvetica, sans-serif'); ?>>Helvetica</option>
                                            <option value="Georgia, serif" <?php selected(get_option('salient_woo_button_font_family', 'inherit'), 'Georgia, serif'); ?>>Georgia</option>
                                            <option value="Times, serif" <?php selected(get_option('salient_woo_button_font_family', 'inherit'), 'Times, serif'); ?>>Times</option>
                                            <option value="Poppins, sans-serif" <?php selected(get_option('salient_woo_button_font_family', 'inherit'), 'Poppins, sans-serif'); ?>>Poppins</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Dimensione Font Desktop (px)</th>
                                    <td><input type="number" name="salient_woo_button_font_size_desktop" value="<?php echo esc_attr(get_option('salient_woo_button_font_size_desktop', '14')); ?>" min="10" max="30" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Dimensione Font Tablet (px)</th>
                                    <td><input type="number" name="salient_woo_button_font_size_tablet" value="<?php echo esc_attr(get_option('salient_woo_button_font_size_tablet', '13')); ?>" min="10" max="30" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Dimensione Font Mobile (px)</th>
                                    <td><input type="number" name="salient_woo_button_font_size_mobile" value="<?php echo esc_attr(get_option('salient_woo_button_font_size_mobile', '12')); ?>" min="10" max="30" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Colore Sfondo</th>
                                    <td><input type="color" name="salient_woo_button_bg_color" value="<?php echo esc_attr(get_option('salient_woo_button_bg_color', '#3498db')); ?>" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Colore Testo</th>
                                    <td><input type="color" name="salient_woo_button_text_color" value="<?php echo esc_attr(get_option('salient_woo_button_text_color', '#ffffff')); ?>" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Colore Sfondo Hover</th>
                                    <td><input type="color" name="salient_woo_button_hover_bg_color" value="<?php echo esc_attr(get_option('salient_woo_button_hover_bg_color', '#2980b9')); ?>" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Raggio Bordo (px)</th>
                                    <td><input type="number" name="salient_woo_button_border_radius" value="<?php echo esc_attr(get_option('salient_woo_button_border_radius', '4')); ?>" min="0" max="50" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Padding Orizzontale (px)</th>
                                    <td><input type="number" name="salient_woo_button_padding_horizontal" value="<?php echo esc_attr(get_option('salient_woo_button_padding_horizontal', '16')); ?>" min="5" max="50" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Padding Verticale (px)</th>
                                    <td><input type="number" name="salient_woo_button_padding_vertical" value="<?php echo esc_attr(get_option('salient_woo_button_padding_vertical', '10')); ?>" min="5" max="30" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Margine Sinistro (px)</th>
                                    <td><input type="number" name="salient_woo_button_margin_left" value="<?php echo esc_attr(get_option('salient_woo_button_margin_left', '8')); ?>" min="0" max="50" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Allineamento</th>
                                    <td>
                                        <select name="salient_woo_button_alignment">
                                            <option value="left" <?php selected(get_option('salient_woo_button_alignment', 'center'), 'left'); ?>>Sinistra</option>
                                            <option value="center" <?php selected(get_option('salient_woo_button_alignment', 'center'), 'center'); ?>>Centro</option>
                                            <option value="right" <?php selected(get_option('salient_woo_button_alignment', 'center'), 'right'); ?>>Destra</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <!-- Container Settings Tab -->
                        <div id="tab-container" class="salient-tab-content">
                            <h2>Impostazioni Container</h2>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">Padding Container (px)</th>
                                    <td><input type="number" name="salient_woo_container_padding" value="<?php echo esc_attr(get_option('salient_woo_container_padding', '12')); ?>" min="0" max="50" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Margine Superiore (px)</th>
                                    <td><input type="number" name="salient_woo_container_margin_top" value="<?php echo esc_attr(get_option('salient_woo_container_margin_top', '10')); ?>" min="0" max="50" /></td>
                                </tr>
                                <tr>
                                    <th scope="row">Larghezza Massima (%)</th>
                                    <td><input type="number" name="salient_woo_container_max_width" value="<?php echo esc_attr(get_option('salient_woo_container_max_width', '100')); ?>" min="50" max="100" /></td>
                                </tr>
                            </table>
                        </div>
                        
                        <!-- Responsive Settings Tab -->
                        <div id="tab-responsive" class="salient-tab-content">
                            <h2>Impostazioni Responsive</h2>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">Abilita Responsive</th>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="salient_woo_enable_responsive" value="1" <?php checked(get_option('salient_woo_enable_responsive', '1'), '1'); ?> />
                                            Abilita CSS responsive per dispositivi mobili
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Breakpoint Mobile (px)</th>
                                    <td>
                                        <input type="number" name="salient_woo_mobile_breakpoint" value="<?php echo esc_attr(get_option('salient_woo_mobile_breakpoint', '768')); ?>" min="320" max="1024" />
                                        <p class="description">Dispositivi con larghezza inferiore a questo valore useranno gli stili mobile</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Breakpoint Tablet (px)</th>
                                    <td>
                                        <input type="number" name="salient_woo_tablet_breakpoint" value="<?php echo esc_attr(get_option('salient_woo_tablet_breakpoint', '1024')); ?>" min="768" max="1200" />
                                        <p class="description">Dispositivi con larghezza inferiore a questo valore useranno gli stili tablet</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <!-- Advanced Settings Tab -->
                        <div id="tab-advanced" class="salient-tab-content">
                            <h2>Impostazioni Avanzate</h2>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">Nascondi Elementi Originali</th>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="salient_woo_hide_original_elements" value="1" <?php checked(get_option('salient_woo_hide_original_elements', '1'), '1'); ?> />
                                            Nascondi titolo e prezzo originali di WooCommerce
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">CSS Personalizzato</th>
                                    <td>
                                        <textarea name="salient_woo_custom_css" rows="10" cols="50" class="large-text code"><?php echo esc_textarea(get_option('salient_woo_custom_css', '')); ?></textarea>
                                        <p class="description">Aggiungi CSS personalizzato che sovrascriverà gli stili predefiniti</p>
                                        
                                        <h4>CSS di esempio per forzare centratura pulsanti:</h4>
                                        <textarea readonly rows="8" cols="50" class="large-text code" style="background: #f0f0f0; cursor: text;">
/* Forza centratura assoluta del pulsante */
.salient-button-container,
.woocommerce ul.products li.product .salient-button-container {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    text-align: center !important;
    width: 100% !important;
}

.salient-go-to-product {
    margin: 0 auto !important;
}</textarea>
                                        <p class="description">Copia e incolla questo CSS nell'area sopra per forzare la centratura completa dei pulsanti.</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <?php submit_button('Salva Impostazioni'); ?>
                </form>
                
                <div class="salient-preview">
                    <h3>Anteprima Live</h3>
                    <div class="salient-preview-container">
                        <div class="salient-custom-product-info">
                            <h2 class="salient-product-title">Titolo Prodotto di Esempio</h2>
                            <div class="salient-product-price">€29.99</div>
                        </div>
                        <div class="salient-button-container">
                            <a href="#" class="button salient-go-to-product">Vai al prodotto</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Enqueue admin scripts and styles.
     */
    public function admin_enqueue_scripts($hook) {
        if ($hook !== 'settings_page_salient-woo-enhancer') {
            return;
        }
        
        wp_enqueue_script('salient-woo-admin', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), '2.0.0', true);
        wp_enqueue_style('salient-woo-admin', plugin_dir_url(__FILE__) . 'css/admin.css', array(), '2.0.0');
    }
}

// Initialize the plugin
new Salient_WooCommerce_Product_Display_Enhancer();
?>