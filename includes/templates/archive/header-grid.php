<?php
/*
 * Header Grid for Templates
 */
if ( $parent == 'header' || $parent == 'headerANDfooter' ):
    if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ): 
        ?>
        <section class="wpcd_archive_section wpcd_clearfix">
        <?php

            $terms = get_terms( 'wpcd_coupon_category' );
            if ( !empty( $terms ) && !is_wp_error( $terms ) && !$disable_menu ):

                $pageNum=(get_query_var('paged')) ? get_query_var('paged') : 1;
                $current_url = get_pagenum_link($pageNum);
                $current_url_final = wpcd_preparationMenuLinks( $current_url );
                $current_url_final_all = $current_url_final['all'];
                $current_url_final_sin = $current_url_final['sin'];

        ?>
            <div class="wpcd_div_nav_block">
                <div class="wpcd_cats">
                    <ul id="wpcd_cat_ul">
                        <li>
                            <?php 
                                if( ! isset( $_GET['wpcd_category'] ) || $_GET['wpcd_category'] == '' ) {
                                    $wpcd_dropdown_content = ' active';
                                } else {
                                    $wpcd_dropdown_content = '';
                                }
                            ?>
                            <a class="wpcd_category<?php echo $wpcd_dropdown_content; ?>" data-category="all" href="<?php echo $current_url_final_all; ?>">
                                <?php echo __( 'All Coupons', 'wpcd-coupon' ); ?>
                            </a>
                        </li>
                        <?php foreach ( $terms as $term ): 
                            if( isset( $_GET['wpcd_category'] ) && $_GET['wpcd_category'] == $term->slug ) {
                                $wpcd_dropdown_content = ' active';
                            } else {
                                $wpcd_dropdown_content = '';
                            }
                        ?>
                            <li>
                                <a class="wpcd_category<?php echo $wpcd_dropdown_content; ?>" data-category="<?php echo $term->slug; ?>"
                                   href="<?php echo $current_url_final_sin . 'wpcd_category=' . $term->slug; ?>"><?php echo $term->name; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
                    <div id="wpcd_searchbar">
                        <ul id="wpcd_cat_ul_search">
                            <li class="wpcd_searchbar_search">
                                <input type="text" placeholder="Search">
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="wpcd_cat_ul_border"></div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
        <div class="wpcd_coupon_archive_container_main">
            <div class="wpcd_coupon_loader wpcd_coupon_hidden_loader">
                <img src="<?php echo WPCD_Plugin::instance()->plugin_assets . 'img/loading.gif'; ?>">
            </div>
            <div class="wpcd_coupon_archive_container">
    <?php endif; ?>
    <ul id="wpcd_coupon_ul" class="wpcd_clearfix">
<?php endif; ?>