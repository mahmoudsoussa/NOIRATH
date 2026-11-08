<?php
/* Template Name: Customer Care */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<main id="main" class="care-page wrap">
 <?php while ( have_posts() ) : the_post(); ?>
 <header class="care-hero"><p class="eyebrow">NOIRATH / CUSTOMER CARE</p><h1><?php echo get_the_ID() === (int) get_option( 'noirath_care_page_contact' ) ? esc_html__( "WE'RE HERE TO HELP.", 'noirath' ) : esc_html( get_the_title() ); ?></h1><p>STYLE BEYOND LIMITS <span aria-hidden="true">—</span> HERE FOR YOU.</p></header>
 <div class="care-layout"><aside class="care-sidebar"><p class="eyebrow">HOW CAN WE HELP?</p><nav aria-label="<?php esc_attr_e( 'Customer care', 'noirath' ); ?>"><?php noirath_care_navigation(); ?></nav></aside><article id="post-<?php the_ID(); ?>" <?php post_class( 'care-content' ); ?>><?php if ( get_the_ID() === (int) get_option( 'noirath_care_page_shipping-returns' ) ) : ?><div class="care-icons" aria-hidden="true"><?php echo noirath_icon( 'ship' ) . noirath_icon( 'return' ); ?></div><?php endif; ?><?php the_content(); wp_link_pages(); ?></article></div>
 <?php endwhile; ?>
</main>
<?php get_footer(); ?>
