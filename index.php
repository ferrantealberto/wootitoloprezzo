<?php
/**
 * Plugin Name: Salient WooCommerce Product Display Enhancer
 * Plugin URI: https://example.com/plugins/salient-woocommerce-product-display-enhancer
 * Description: Enhances WooCommerce product display for Salient theme by adding product title and price below product image, and a "Vai al prodotto" button next to Add to Cart.
 * Version: 1.0.1
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
            // Remove default WooCommerce title and price
            remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            
            // Remove any duplicate elements that might be added by the theme
            add_action('init', array($this, 'remove_duplicate_elements'));
            
            // Add title and price below product image
            add_action('woocommerce_after_shop_loop_item', array($this, 'add_product_title_and_price'), 5);
            
            // Add "Go to Product" button
            add_action('woocommerce_after_shop_loop_item', array($this, 'add_go_to_product_button'), 11);
            
            // Add custom CSS
            add_action('wp_head', array($this, 'add_custom_css'));
        }
    }

    /**
     * Remove duplicate elements that might be added by the theme.
     */
    public function remove_duplicate_elements() {
        // Specific to Salient theme - remove any duplicate elements
        remove_action('nectar_woo_shop_loop_item_price', 'woocommerce_template_loop_price', 10);
        remove_action('nectar_woo_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
        
        // For additional theme-specific elements, you may need to add more removals here
        // This covers common scenarios but might need adjustment for your specific setup
    }

    /**
     * Add product title and price below product image.
     */
    public function add_product_title_and_price() {
        global $product;
        
        if (!$product) {
            return;
        }
        
        echo '<div class="salient-custom-product-info">';
        echo '<h2 class="salient-product-title">' . get_the_title() . '</h2>';
        echo '<div class="salient-product-price">' . $product->get_price_html() . '</div>';
        echo '</div>';
    }

    /**
     * Add "Go to Product" button next to Add to Cart button.
     */
    public function add_go_to_product_button() {
        global $product;
        
        if (!$product) {
            return;
        }
        
        echo '<a href="' . esc_url(get_permalink($product->get_id())) . '" class="button salient-go-to-product">' . esc_html__('Vai al prodotto', 'salient-woocommerce-product-display-enhancer') . '</a>';
    }

    /**
     * Add custom CSS.
     */
    public function add_custom_css() {
        ?>
        <style type="text/css">
            /* Product information container */
            .salient-custom-product-info {
                padding: 10px 0;
                text-align: center;
                width: 100%;
                margin-top: 10px;
            }
            
            /* Product title */
            .salient-product-title {
                font-size: 16px;
                font-weight: 600;
                margin-bottom: 5px;
                color: #333;
                text-align: center;
            }
            
            /* Product price */
            .salient-product-price {
                font-size: 14px;
                color: #e74c3c;
                font-weight: 500;
                margin-bottom: 10px;
                text-align: center;
            }
            
            /* Go to Product button */
            .salient-go-to-product {
                margin-left: 5px !important;
                background-color: #3498db !important;
                color: #fff !important;
            }
            
            .salient-go-to-product:hover {
                background-color: #2980b9 !important;
            }
            
            /* Fix for button alignment */
            .woocommerce ul.products li.product .add_to_cart_button,
            .woocommerce ul.products li.product .salient-go-to-product {
                display: inline-block !important;
                margin-top: 10px !important;
            }
            
            /* Remove duplicate elements */
            .woocommerce ul.products li.product h2.woocommerce-loop-product__title,
            .woocommerce ul.products li.product .price {
                display: none !important;
            }
            
            /* Ensure our custom elements are shown */
            .salient-custom-product-info {
                display: block !important;
            }
            
            /* Additional Salient theme specific fixes */
            .product-meta {
                display: none !important;
            }
            
            /* Make sure buttons are properly aligned */
            .woocommerce-loop-product__link {
                display: block;
                margin-bottom: 10px;
            }
        </style>
        <?php
    }
}

// Initialize the plugin
new Salient_WooCommerce_Product_Display_Enhancer();
