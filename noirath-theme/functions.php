<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
define( 'NOIRATH_VERSION', '1.1.0' );
function noirath_setup() {
 load_theme_textdomain( 'noirath', get_template_directory() . '/languages' );
 add_theme_support( 'title-tag' ); add_theme_support( 'post-thumbnails' ); add_theme_support( 'automatic-feed-links' ); add_theme_support( 'custom-logo' );
 add_theme_support( 'woocommerce', array( 'thumbnail_image_width' => 600, 'single_image_width' => 900, 'product_grid' => array( 'default_columns' => 4 ) ) );
 add_theme_support( 'wc-product-gallery-zoom' ); add_theme_support( 'wc-product-gallery-lightbox' ); add_theme_support( 'wc-product-gallery-slider' );
 register_nav_menus( array( 'primary' => __( 'Primary navigation', 'noirath' ), 'footer' => __( 'Footer navigation', 'noirath' ) ) );
} add_action( 'after_setup_theme', 'noirath_setup' );
function noirath_assets() { wp_enqueue_style( 'noirath-style', get_stylesheet_uri(), array(), NOIRATH_VERSION ); wp_enqueue_script( 'noirath-script', get_template_directory_uri() . '/assets/theme.js', array(), NOIRATH_VERSION, true ); } add_action( 'wp_enqueue_scripts', 'noirath_assets' );
function noirath_widgets() { register_sidebar( array( 'name' => __( 'Shop filters', 'noirath' ), 'id' => 'shop-sidebar', 'before_widget' => '<section class="widget">', 'after_widget' => '</section>', 'before_title' => '<h3>', 'after_title' => '</h3>' ) ); } add_action( 'widgets_init', 'noirath_widgets' );
function noirath_customize( $wp_customize ) {
 $wp_customize->add_section( 'noirath_home', array( 'title' => __( 'NOIRATH homepage', 'noirath' ), 'priority' => 30 ) );
 $fields = array( 'hero_image' => array( 'Hero image', 'image' ), 'season_image' => array( 'Season image', 'image' ), 'hero_title' => array( 'Hero headline', 'text' ), 'hero_text' => array( 'Hero description', 'textarea' ), 'season_title' => array( 'Season headline', 'text' ), 'season_text' => array( 'Season description', 'text' ), 'philosophy' => array( 'Philosophy text', 'textarea' ), 'vision' => array( 'Vision text', 'textarea' ), 'newsletter_shortcode' => array( 'Newsletter form shortcode', 'text' ), 'instagram' => array( 'Instagram URL', 'url' ), 'tiktok' => array( 'TikTok URL', 'url' ), 'pinterest' => array( 'Pinterest URL', 'url' ), 'facebook' => array( 'Facebook URL', 'url' ) );
 foreach ( $fields as $id => $field ) { $sanitize = 'image' === $field[1] || 'url' === $field[1] ? 'esc_url_raw' : ( 'textarea' === $field[1] ? 'sanitize_textarea_field' : 'sanitize_text_field' ); $wp_customize->add_setting( 'noirath_' . $id, array( 'sanitize_callback' => $sanitize ) ); if ( 'image' === $field[1] ) { $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'noirath_' . $id, array( 'label' => $field[0], 'section' => 'noirath_home' ) ) ); } else { $wp_customize->add_control( 'noirath_' . $id, array( 'label' => $field[0], 'section' => 'noirath_home', 'type' => $field[1] ) ); } }
} add_action( 'customize_register', 'noirath_customize' );
function noirath_value( $key, $default ) { $value = get_theme_mod( 'noirath_' . $key ); return $value ? $value : $default; }
function noirath_shop_url() { return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ); }
function noirath_category_url( $slug ) { $term = get_term_by( 'slug', $slug, 'product_cat' ); if ( $term && ! is_wp_error( $term ) ) { $url = get_term_link( $term ); if ( ! is_wp_error( $url ) ) { return $url; } } return noirath_shop_url(); }
function noirath_icon( $name ) { $paths = array( 'search' => '<circle cx="11" cy="11" r="7"/><path d="m16 16 5 5"/>', 'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-5 3-7 8-7s8 2 8 7"/>', 'heart' => '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21l8.8-8.6a5.5 5.5 0 0 0 0-7.8z"/>', 'bag' => '<path d="M4 8h16l-1 13H5L4 8zM8 8V6a4 4 0 0 1 8 0v2"/>', 'ship' => '<path d="M2 5h13v12H2zM15 9h4l3 4v4h-7z"/><circle cx="6" cy="19" r="2"/><circle cx="18" cy="19" r="2"/>', 'quality' => '<circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/>', 'return' => '<path d="M3 10a9 9 0 1 1 2 7M3 4v6h6"/>', 'lock' => '<rect x="5" y="10" width="14" height="11"/><path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3"/>' ); return '<svg class="icon" viewBox="0 0 24 24" aria-hidden="true">' . ( isset( $paths[ $name ] ) ? $paths[ $name ] : '' ) . '</svg>'; }
function noirath_product_actions() { global $product; if ( ! $product ) return; echo '<button type="button" class="wishlist-button" data-id="' . esc_attr( $product->get_id() ) . '" aria-label="' . esc_attr__( 'Toggle wishlist', 'noirath' ) . '" aria-pressed="false">♡</button>'; } add_action( 'woocommerce_before_shop_loop_item_title', 'noirath_product_actions', 5 );
function noirath_quick_view() { global $product; if ( $product ) echo '<a class="quick-view" href="' . esc_url( get_permalink( $product->get_id() ) ) . '">' . esc_html__( 'View details', 'noirath' ) . '</a>'; } add_action( 'woocommerce_after_shop_loop_item', 'noirath_quick_view', 15 );
function noirath_fallback_menu() { echo '<ul><li><a href="' . esc_url( noirath_category_url( 'men' ) ) . '">Men</a></li><li><a href="' . esc_url( noirath_category_url( 'women' ) ) . '">Women</a></li><li><a href="' . esc_url( noirath_shop_url() ) . '">New Arrivals</a></li><li><a href="' . esc_url( noirath_shop_url() ) . '">Collections</a></li><li><a href="' . esc_url( home_url( '/#philosophy' ) ) . '">About</a></li></ul>'; }
function noirath_wishlist_page() {
 if ( ! isset( $_GET['noirath_wishlist'] ) ) return;
 get_header(); echo '<main id="main" class="content-area wrap"><h1>YOUR WISHLIST</h1><div id="noirath-wishlist-list">';
 if ( class_exists( 'WooCommerce' ) && isset( $_GET['ids'] ) ) { $ids = array_filter( array_map( 'absint', explode( ',', sanitize_text_field( wp_unslash( $_GET['ids'] ) ) ) ) ); if ( $ids ) echo do_shortcode( '[products columns="4" ids="' . esc_attr( implode( ',', $ids ) ) . '"]' ); }
 echo '</div><p><a href="' . esc_url( noirath_shop_url() ) . '">Continue shopping</a></p></main>'; get_footer(); exit;
} add_action( 'template_redirect', 'noirath_wishlist_page' );

require_once get_template_directory() . '/inc/customer-care.php';
