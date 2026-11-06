# NOIRATH WordPress theme

An installable, responsive WooCommerce theme for NOIRATH. Theme source is in `noirath-theme/`; upload `noirath-theme.zip` via **Appearance → Themes → Add New → Upload Theme**. Requires WordPress 6.2+, PHP 7.4+ and the official WooCommerce plugin for shopping features.

## Install and configure

1. Install and activate WooCommerce; complete its setup wizard, including shop, cart, checkout and account pages, payment methods, taxes, shipping zones and return policies. Install and activate the theme ZIP. Assign a homepage under **Settings → Reading**; the theme displays its editorial homepage when a static front page is selected. Alternatively WordPress will use the homepage template when the latest posts are shown.
2. In **Appearance → Customize → NOIRATH homepage**, change the hero and season photos, editorial copy, social URLs and newsletter shortcode. The default editorial photos are included; the supplied official logo is included unmodified. Create menus under **Appearance → Menus** (or the menu section of the Customizer) and assign Primary and Footer locations. Create customer-service pages and update footer links as needed; the default links expect `/contact/` and `/shipping-returns/`. Set the privacy page under Settings and terms page in WooCommerce.
3. Create `men`, `women`, and `unisex` product categories, or assign your own menu links. Category cards fall back to the shop when these categories do not exist. Add WooCommerce product filter blocks/widgets to **Appearance → Widgets → Shop filters**. Attribute filters require configured attributes and an appropriate WooCommerce filter widget/block. The announcement and benefit statements are presentation copy; configure shipping and return terms to match them.
4. Add products in **Products → Add New** or sync them from Printful. Set real prices, images, inventory and attributes in WooCommerce. For sizes and colors, create a variable product, configure attributes used for variations, and set up each variation's price and image as appropriate. WooCommerce renders the variation selectors, cart and checkout. The homepage bestseller grid uses WooCommerce's actual sales data; it may be empty until products have sales. No products or prices are hardcoded.
5. To enable newsletter signup, install a newsletter provider plugin and paste its form shortcode in the Customizer. Set social URLs there to show the corresponding links. Newsletter submissions are handled by the chosen plugin, not the theme.

## Printful

Install and connect the **official Printful integration for WooCommerce**, then follow Printful's onboarding and sync instructions. Printful and WooCommerce, not this theme, handle synchronization, order import, fulfillment, status and tracking where supported. Configure Printful shipping and tax settings and confirm product variants, prices and fulfillment behavior in both dashboards. The theme uses standard WooCommerce product templates and variation controls; it works without Printful connected. No Printful API or fulfillment functionality is implemented in the theme.

## Notes

- Wishlist selections are stored locally in the visitor's browser, are not synced between devices, and can be lost when browser data is cleared. The heart icon opens the wishlist. Product detail links act as the product preview; there is no modal quick view. WooCommerce supplies add-to-cart buttons and the full product page, including variation selections.
- Elementor can be used for page content; the custom front-page template intentionally owns the homepage layout. Customizer controls cover its primary copy and two photographs. The default category and brand panels reuse these photographs.
- The included logo is the exact uploaded file, with its original background and proportions. The included editorial images are generated assets and can be replaced.
- Theme does not bundle WooCommerce, Printful, a newsletter service, payment providers, or fonts; typography uses local system fallbacks for speed. Social links are displayed as text.
- Validate checkout, payment, shipping, emails, Printful sync and tracking on a staging site before launch. Theme behavior depends on installed plugin versions and store configuration.

## Development

Edit files in `noirath-theme/`. Build the upload archive from the repository root with `zip -r noirath-theme.zip noirath-theme`. PHP files should be linted with `php -l` and tested with current WordPress and WooCommerce on a staging server.
