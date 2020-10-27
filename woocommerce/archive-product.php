<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @see https://github.com/woocommerce/woocommerce/blob/release/4.6/templates/archive-product.php
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header();
?>
<div class="container dedone">
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

            <ul class="products columns-4">
            <?php
                // Only run on shop archive pages, not single products or other pages
                if ( is_shop() || is_product_category() || is_product_tag() ) {

                    // Products per page
                    $per_page = 24;
                    if ( get_query_var( 'taxonomy' ) ) { // If on a product taxonomy archive (category or tag)
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => $per_page,
                            'paged' => get_query_var( 'paged' ),
                            'tax_query' => array(
                                array(
                                    'taxonomy' => get_query_var( 'taxonomy' ),
                                    'field'    => 'slug',
                                    'terms'    => get_query_var( 'term' ),
                                ),
                            ),
                        );
                    } else { // On main shop page
                        $args = array(
                            'post_type' => 'product',
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'posts_per_page' => $per_page,
                            'paged' => get_query_var( 'paged' ),
                        );
                    }

                    // Set the query
                    $products = new WP_Query( $args );

                    // Standard loop
                    if ( $products->have_posts() ) :
                        while ( $products->have_posts() ) : $products->the_post();

                            /**
                      			 * Hook: woocommerce_shop_loop.
                      			 */
                      			do_action( 'woocommerce_shop_loop' );
                      			wc_get_template_part( 'content', 'product' );
                						?>

                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;

                } else { // If not on archive page (cart, checkout, etc), do normal operations
                    woocommerce_content();
                }
            ?>
            </ul>
        </div>
    </div>
</div>
<?php get_footer(); ?>
