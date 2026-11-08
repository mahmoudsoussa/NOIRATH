<?php
/** Customer care pages and contact form. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Starter copy is stored as page content, not in templates, and is editable. */
function noirath_care_starters() {
 return array(
  'shipping-returns' => array( 'Shipping & Returns', 'Shipping and returns information for NOIRATH orders.', <<<'HTML'
<p class="care-review"><strong>Information awaiting confirmation.</strong> Shipping and return terms below must be completed and reviewed before relying on this page.</p>
<p>Every NOIRATH order matters. Find the information you need about delivery, returns and getting in touch below.</p>
<h2>Shipping information</h2><h3>Destinations</h3><p>[Confirm the countries and regions you ship to, including any restrictions.]</p>
<h3>Processing &amp; delivery</h3><p>[Confirm order processing times and estimated delivery times by destination. Estimates are not guarantees.]</p>
<h3>Shipping costs</h3><p>[Confirm shipping charges, any free-shipping threshold, eligibility and exclusions.] Your available shipping options and charges will be shown at checkout.</p>
<h3>Tracking your order</h3><p>[Confirm when and how tracking information is provided and who to contact if it is unavailable.]</p>
<h2>Returns &amp; refunds</h2><h3>Return eligibility</h3><p>[Confirm which products are eligible for return, the request period and any applicable exceptions, subject to local consumer rights.]</p>
<h3>Return conditions</h3><p>[Confirm the required condition, packaging, return address and who pays return shipping.]</p>
<h3>Refund process</h3><p>[Confirm how approved refunds are issued and the expected processing time.]</p>
<h3>Damaged or incorrect products</h3><p>If your order arrives damaged or incorrect, contact us with your order number and a description. [Confirm the evidence required and the available remedies.]</p>
<h3>Request a return</h3><p>Contact our customer care team with your order number and the reason for your request. [Confirm the return request process and any deadlines.]</p>
HTML
  ),
  'contact' => array( 'Contact Us', 'Contact the NOIRATH customer care team for help with your order.', <<<'HTML'
<p>Questions about an order, a product, or something else? Our customer care team is here to help. Share a few details and we will be in touch.</p>
[noirath_contact_form]
[noirath_contact_details]
HTML
  ),
  'privacy-policy' => array( 'Privacy Policy', 'Read the NOIRATH privacy policy and learn how to contact us about your data.', <<<'HTML'
<p class="care-review"><strong>Legal review required.</strong> This is an editable starting point, not a complete policy. Confirm the bracketed details and have qualified counsel review it before publication or use.</p>
<h2>Information we collect</h2><p>Depending on how you use the site, we may collect information you provide, such as your name, contact details and messages. [Confirm all collection methods and categories.]</p>
<h2>Orders and payments</h2><p>Order information may include billing and shipping details, items purchased and transaction records. Payment providers process payment details according to their own terms. [Identify the providers and the information retained.]</p>
<h2>Cookies and analytics</h2><p>The site may use cookies and similar technologies to operate the store and, where enabled, measure use. [List cookies, analytics providers, purposes, consent choices and retention.]</p>
<h2>How we use information</h2><p>Information may be used to process orders, respond to enquiries and operate the store. [Specify all purposes, legal bases where applicable, and marketing choices.]</p>
<h2>Third-party services</h2><p>Service providers may process information to provide services to the store. [Identify providers, disclosures and any international transfers or safeguards.]</p>
<h2>WooCommerce and Printful</h2><p>WooCommerce supports store operations. If connected, Printful may receive order and delivery information needed to fulfill orders. [Describe actual data flows, roles and links to provider notices.]</p>
<h2>Security</h2><p>[Describe the security measures actually used and any relevant limitations.] No method of transmission or storage is completely secure.</p>
<h2>Your privacy rights</h2><p>[Describe applicable rights, how to exercise them, complaint options and any jurisdiction-specific details.]</p>
<h2>Data retention</h2><p>[Set out retention periods or criteria for each relevant category and any legal obligations.]</p>
<h2>Privacy requests</h2><p>[Provide the responsible entity, privacy contact details and process for requests.] You can also reach our team through the Contact Us page.</p>
HTML
  ),
  'terms-and-conditions' => array( 'Terms & Conditions', 'Review the NOIRATH website and store terms and conditions.', <<<'HTML'
<p class="care-review"><strong>Legal review required.</strong> This is an editable starting point, not complete terms. Confirm the bracketed details and have qualified counsel review it before publication or use.</p>
<h2>Introduction</h2><p>[Identify the business, its address, governing law, and the scope and effective date of these terms.]</p>
<h2>Website use</h2><p>[Describe permitted use, account responsibilities and prohibited conduct.]</p>
<h2>Products and descriptions</h2><p>We aim to describe products accurately. Images and colors may appear different depending on your screen. [Confirm your approach to errors, availability and product descriptions.]</p>
<h2>Prices and payments</h2><p>[Describe currency, taxes, accepted payment methods and how pricing errors are handled.] Applicable costs are presented at checkout.</p>
<h2>Orders and cancellations</h2><p>[Explain when orders are accepted, cancellation options and any print-on-demand limitations, subject to applicable consumer rights.]</p>
<h2>Shipping and delivery</h2><p>See Shipping &amp; Returns for delivery information. [Confirm delivery responsibilities and how delays are handled.]</p>
<h2>Returns and refunds</h2><p>See Shipping &amp; Returns for the return process. [Confirm eligibility, exceptions and statutory rights.]</p>
<h2>Intellectual property</h2><p>[Identify ownership and permitted use of the site's content, images, branding and designs.]</p>
<h2>Limitation of liability</h2><p>[Have counsel provide appropriate limitations and exceptions for each market. Do not limit rights that cannot legally be excluded.]</p>
<h2>Third-party services</h2><p>Some store services may be provided by third parties, including payment and fulfillment providers. [Identify relevant services and applicable terms.]</p>
<h2>Changes to these terms</h2><p>[Describe how and when changes are communicated and which terms apply to an order.]</p>
<h2>Contact information</h2><p>[Provide the legal entity and contact details.] For assistance, visit our Contact Us page.</p>
HTML
  ),
 );
}

/** Create missing pages only. Existing content and configured policy pages are never overwritten. */
function noirath_create_care_pages() {
 if ( get_option( 'noirath_care_pages_created' ) ) { return; }
 $success = true;
 foreach ( noirath_care_starters() as $slug => $data ) {
  $configured = 0;
  if ( 'privacy-policy' === $slug ) { $configured = (int) get_option( 'wp_page_for_privacy_policy' ); }
  if ( 'terms-and-conditions' === $slug ) { $configured = (int) get_option( 'woocommerce_terms_page_id' ); }
  $page = $configured ? get_post( $configured ) : null;
  if ( ! $page || 'page' !== $page->post_type || 'trash' === $page->post_status ) { $page = get_page_by_path( $slug, OBJECT, 'page' ); }
  if ( ! $page ) {
   $id = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => $data[0], 'post_name' => $slug, 'post_content' => $data[2], 'post_excerpt' => $data[1], 'comment_status' => 'closed' ), true );
   if ( is_wp_error( $id ) || ! $id ) { $success = false; continue; }
   update_post_meta( $id, '_wp_page_template', 'page-customer-care.php' );
   $page = get_post( $id );
  }
  update_option( 'noirath_care_page_' . $slug, $page->ID );
  if ( 'privacy-policy' === $slug && ! get_option( 'wp_page_for_privacy_policy' ) ) { update_option( 'wp_page_for_privacy_policy', $page->ID ); }
  if ( 'terms-and-conditions' === $slug && ! get_option( 'woocommerce_terms_page_id' ) ) { update_option( 'woocommerce_terms_page_id', $page->ID ); }
 }
 if ( $success ) { update_option( 'noirath_care_pages_created', '1' ); }
}
add_action( 'after_switch_theme', 'noirath_create_care_pages' );
function noirath_care_upgrade() { if ( current_user_can( 'manage_options' ) ) { noirath_create_care_pages(); } }
add_action( 'admin_init', 'noirath_care_upgrade' );

function noirath_care_page_url( $slug ) {
 $id = (int) get_option( 'noirath_care_page_' . $slug );
 if ( 'privacy-policy' === $slug && get_option( 'wp_page_for_privacy_policy' ) ) { $id = (int) get_option( 'wp_page_for_privacy_policy' ); }
 if ( 'terms-and-conditions' === $slug && get_option( 'woocommerce_terms_page_id' ) ) { $id = (int) get_option( 'woocommerce_terms_page_id' ); }
 return $id && 'publish' === get_post_status( $id ) ? get_permalink( $id ) : '';
}
function noirath_care_customizer( $customizer ) {
 $customizer->add_section( 'noirath_care', array( 'title' => __( 'NOIRATH customer care', 'noirath' ), 'priority' => 31 ) );
 $customizer->add_setting( 'noirath_support_email', array( 'default' => '', 'sanitize_callback' => 'sanitize_email' ) );
 $customizer->add_control( 'noirath_support_email', array( 'label' => __( 'Customer support email', 'noirath' ), 'description' => __( 'Receives contact form messages. If blank, the WordPress administration email is used.', 'noirath' ), 'section' => 'noirath_care', 'type' => 'email' ) );
}
add_action( 'customize_register', 'noirath_care_customizer' );
function noirath_support_email() { $email = get_theme_mod( 'noirath_support_email' ); return is_email( $email ) ? $email : get_option( 'admin_email' ); }

function noirath_contact_form() {
 $status = isset( $_GET['care_status'] ) ? sanitize_key( wp_unslash( $_GET['care_status'] ) ) : '';
 ob_start(); ?>
 <div class="care-form-wrap">
 <?php if ( 'sent' === $status ) : ?><p class="care-message" role="status">Thank you. Your message has been submitted to our mail service.</p><?php elseif ( 'invalid' === $status ) : ?><p class="care-message error" role="alert">Please complete all required fields and enter a valid email address.</p><?php elseif ( 'failed' === $status ) : ?><p class="care-message error" role="alert">Your message could not be sent. Please email us directly.</p><?php endif; ?>
 <form class="care-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
 <input type="hidden" name="action" value="noirath_contact"><input type="hidden" name="care_page" value="<?php echo esc_attr( get_the_ID() ); ?>"><?php wp_nonce_field( 'noirath_contact', 'noirath_contact_nonce' ); ?>
 <div class="care-fields"><label>Full name <span aria-hidden="true">*</span><input name="full_name" type="text" autocomplete="name" required maxlength="120"></label>
 <label>Email address <span aria-hidden="true">*</span><input name="email" type="email" autocomplete="email" required maxlength="254"></label>
 <label>Order number <span class="optional">(optional)</span><input name="order_number" type="text" maxlength="100"></label>
 <label>Subject <span aria-hidden="true">*</span><input name="subject" type="text" required maxlength="150"></label></div>
 <label>Message <span aria-hidden="true">*</span><textarea name="message" rows="7" required maxlength="5000"></textarea></label>
 <div class="care-honeypot" aria-hidden="true"><label>Leave this field empty<input name="website" type="text" tabindex="-1" autocomplete="off"></label></div>
 <button class="button" type="submit">SEND MESSAGE</button></form></div>
 <?php return ob_get_clean();
}
add_shortcode( 'noirath_contact_form', 'noirath_contact_form' );
function noirath_contact_details() {
 $email = noirath_support_email(); ob_start(); ?><div class="care-contact-details"><div><h2>Contact our team</h2><?php if ( is_email( $email ) ) : ?><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a><?php endif; ?></div><div><h2>Follow NOIRATH</h2><div class="care-socials"><?php foreach ( array( 'instagram', 'tiktok', 'pinterest', 'facebook' ) as $social ) { $url = get_theme_mod( 'noirath_' . $social ); if ( $url ) { echo '<a href="' . esc_url( $url ) . '">' . esc_html( ucfirst( $social ) ) . ' ↗</a>'; } } ?></div></div></div><?php return ob_get_clean();
}
add_shortcode( 'noirath_contact_details', 'noirath_contact_details' );
function noirath_handle_contact() {
 $page_id = isset( $_POST['care_page'] ) ? absint( $_POST['care_page'] ) : 0;
 // Only redirect to a published local page, never to a supplied URL.
 $redirect = $page_id && 'publish' === get_post_status( $page_id ) && 'page' === get_post_type( $page_id ) ? get_permalink( $page_id ) : home_url( '/' );
 $redirect = remove_query_arg( 'care_status', $redirect );
 $nonce = isset( $_POST['noirath_contact_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['noirath_contact_nonce'] ) ) : '';
 if ( ! wp_verify_nonce( $nonce, 'noirath_contact' ) ) { wp_die( esc_html__( 'Your session has expired. Please go back and try again.', 'noirath' ), '', array( 'response' => 403 ) ); }
 $name = isset( $_POST['full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['full_name'] ) ) : '';
 $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
 $order = isset( $_POST['order_number'] ) ? sanitize_text_field( wp_unslash( $_POST['order_number'] ) ) : '';
 $subject = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
 $message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
 $spam = ! empty( $_POST['website'] );
 if ( ! $name || ! is_email( $email ) || ! $subject || ! $message || strlen( $name ) > 120 || strlen( $email ) > 254 || strlen( $order ) > 100 || strlen( $subject ) > 150 || strlen( $message ) > 5000 ) { $status = 'invalid'; }
 elseif ( $spam ) { $status = 'sent'; }
 else {
  $body = "Name: $name\nEmail: $email\nOrder number: $order\n\n$message";
  $sent = wp_mail( noirath_support_email(), '[NOIRATH contact] ' . $subject, $body, array( 'Reply-To: ' . $email ) );
  $status = $sent ? 'sent' : 'failed';
 }
 wp_safe_redirect( add_query_arg( 'care_status', $status, $redirect ), 303 ); exit;
}
add_action( 'admin_post_noirath_contact', 'noirath_handle_contact' );
add_action( 'admin_post_nopriv_noirath_contact', 'noirath_handle_contact' );

/** Simple description when no common SEO plugin is managing metadata. */
function noirath_care_meta_description() {
 if ( ! is_page() || defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) ) { return; }
 $id = get_queried_object_id();
 foreach ( noirath_care_starters() as $slug => $data ) {
  if ( $id === (int) get_option( 'noirath_care_page_' . $slug ) ) {
   $description = get_post_field( 'post_excerpt', $id );
   if ( $description ) { echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $description ) ) . '">' . "\n"; }
   break;
  }
 }
}
add_action( 'wp_head', 'noirath_care_meta_description', 1 );

function noirath_care_navigation() {
 $labels = array( 'shipping-returns' => 'Shipping & Returns', 'contact' => 'Contact Us', 'privacy-policy' => 'Privacy Policy', 'terms-and-conditions' => 'Terms & Conditions' );
 echo '<ul class="care-links">';
 foreach ( $labels as $slug => $label ) {
  $url = noirath_care_page_url( $slug );
  if ( ! $url ) { continue; }
  $current = get_queried_object_id() === (int) url_to_postid( $url );
  echo '<li><a href="' . esc_url( $url ) . '"' . ( $current ? ' aria-current="page"' : '' ) . '>' . esc_html( $label ) . '</a></li>';
 }
 echo '</ul>';
}
