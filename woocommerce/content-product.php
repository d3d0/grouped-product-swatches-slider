<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible()  ) {
	return;
}
?>

<?php /* TODO */
if( $product->is_type('simple') ) {
?>
<?php /* TODO */
}
?>

<?php if( $product->is_type('grouped') ) { ?>
	<li <?php wc_product_class( '', $product ); ?>>

		<?php
		// product group children
		$children = $product->get_children();
		$count = count( $children );
		?>

		<div class="slider-container">
			<?php
				// get product group children
				foreach ($children as $key => $value) {

					// get product child
					$_product = wc_get_product( $value );

					// get product tags
					$terms = get_the_terms( $_product->get_id(), 'product_tag' );
					$term_array = array();
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					    foreach ( $terms as $term ) {
					        $term_array[] = $term->name;
					    }
					}
					// current slide
					$current = $key+1;
					// get gallery first image
					$attachment_ids = $_product->get_gallery_image_ids();
					$first_image_url = '';
					if (count($attachment_ids)>=1) {
						$first_image_url = wp_get_attachment_url( $attachment_ids[0] );
						$first_image_image =  wp_get_attachment_image($attachment_id, 'full');
					}
					// get first image
					if (!$_product->get_image_id()) { $image_url = '../wp-content/uploads/woocommerce-placeholder-600x600.png';}
					else { $image_url = wp_get_attachment_url( $_product->get_image_id() ); }
					?>
					<div class="slick-container">

						<!-- image gallery -->
						<div class="content-product__img__container">
							<figure class="content-product__img">
								<img class="content-product__img__img <?php if (!empty($attachment_ids)) echo 'content-product__img__front-image'; ?>" src="<?php echo $image_url; ?>" alt="">
								<?php if (!empty($attachment_ids) ) {?><img class="content-product__img__img" src="<?php echo $first_image_url; ?>" alt=""><?php } ?>
							</figure>
							<?php if ( $count > 1 ) { ?>
								<div class="content-product__counter"><?php echo  $current.' of '.$count; ?></div>
							<?php } ?>
							<?php
								if( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_add_wishlist_to_loop' ) ){
									echo do_shortcode( '[yith_wcwl_add_to_wishlist product_id="'. $_product->get_id() .'"]' );
								}
							?>
						</div>

						<!-- progress bar -->
						<div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>

						<!-- title + price + polarized -->
						<a href="<?php echo $_product->get_permalink(); ?>" class="content-product__link">
							<div class="content-product__text">
								<p class="content-product__text__sku">
									<?php
										echo esc_attr($_product->get_title()) . ' ';
										// polarized: custom field
										$polarized = get_post_meta( $_product->get_id(), '_product_polarized', true );
										if ( $polarized == 'yes') { ?><br><i class="content-product__text__polarized">Polarized</i><?php }
										// polarized: tag
										// if (in_array('polarized',$term_array)) { echo '<br><i class="content-product__text__polarized">Polarized</i>'; }
									?>
								</p>
								<p class="content-product__text__price">
									<?php	echo '€ '. esc_attr($_product->get_price()); ?>
								</p>
							</div>
						</a>

					</div>
				<?php
				}
			?>
		</div>
	</li>
<?php
}
?>

<?php if( $product->is_type('variable') ) {

	// display all categories / display all tags
	$terms = get_the_terms( $product->get_id(), 'product_cat' );
  $nterms = get_the_terms( $product->get_id(), 'product_tag'  );
  foreach ($terms  as $term  ) {
      $product_cat_id = $term->term_id;
      $product_cat_name = $term->name;
      // echo $product_cat_name;
  }
	// display first category
	$product_cat = get_the_terms( $product->get_id(), 'product_cat' );
  if ( $product_cat && ! is_wp_error( $product_cat ) ) {
      // echo  $product_cat[0]->name;
  }
	// echo wc_get_product_category_list($product->get_id());

	// product attributes list
	$attributes = $product->get_attributes();
	if ( $attributes ) {
		foreach ($attributes as $key => $value) {
			if($key == 'pa_brand') {
				$terms = wc_get_product_terms( get_the_ID(), $key, array( 'fields' => 'names' ) );
				$terms_values = implode(",", $terms);
			}
			else { $terms_values = NULL; }
	  }
	}
	// echo wc_display_product_attributes($product);

	// product variation attributes list
	$attributes = $product->get_variation_attributes();
	foreach ($attributes as $key => $value) { }

	// product variations
	$variations = $product->get_available_variations();
  foreach ($variations as $key => $value) { }

	?>
	<li <?php wc_product_class( '', $product ); ?>>
		<div class="slider-container">
			<?php
				// product variations
				$variations = $product->get_available_variations();
				$count = count( $variations );
				foreach ($variations as $key => $value) {
					// var_dump($key, $value);
					$current = $key+1;
					?>
					<div class="slick-container">

						<div class="content-product__img__container">
							<img class="content-product__img__img" src="<?php echo $value['image']['url']; ?>" alt="">
							<?php if ($count > 1 ) { ?>
								<div class="content-product__counter"><?php echo  $current.' of '.$count; ?></div>
							<?php } ?>
							<?php
								if( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_add_wishlist_to_loop' ) ){
									echo do_shortcode( '[yith_wcwl_add_to_wishlist product_id="'. $product->get_id() .'"]' );
								}
							?>
						</div>

						<div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>

						<a href="<?php the_permalink() ?>" class="content-product__link">
						<div class="content-product__text">
							<p class="content-product__text__sku">
								<?php
									// TITLE
									// category (or tag or attribute)
									// + sku + alias
									// + var sku + var sku alias
									// + polarized

									// TITLE > product cat
									$product_cat = get_the_terms( $product->get_id(), 'product_cat' );
								  if ( $product_cat && ! is_wp_error( $product_cat ) ) { echo  $product_cat[0]->name; }
									// TITLE > product tag
									// $product_tag = get_the_terms( $product->get_id(), 'product_tag' );
								  // if ( $product_tag && ! is_wp_error( $product_tag ) ) { echo  ' ' . $product_tag[0]->name; }
									// TITLE > product attribute
									// if ( $terms_values ) { echo  ' ' . $terms_values; }
									if ( $product->get_sku() ) echo ' ' . esc_attr($product->get_sku());
									if ( get_post_meta( $product->get_id(), '_sku_alias_modello', true ) ) echo ' ' . esc_attr(get_post_meta( $product->get_id(), '_sku_alias_modello', true ));
									if ( $value["sku"] ) echo ' ' . $value["sku"] ;
									if ( $value["_sku_alias_colore"] ) echo ' ' . $value["_sku_alias_colore"];
									if ( $value["_checkbox_polarized"] == 'yes') { ?><br><i class="content-product__text__polarized">Polarized</i><?php }
								?>
							</p>
							<p class="content-product__text__price"><?php if ( $value["display_price"]) echo '€ '. $value['display_price']; ?></p>
						</div>
						</a>

					</div>
					<?php
				}
			?>
		</div>
	</li>
<?php
}
?>
