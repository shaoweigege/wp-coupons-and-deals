<?php
/*
 * Header for Templates
 */
if ( $parent == 'header' || $parent == 'headerANDfooter' ):
    if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ):
        ?>
        <section class="wpcd_archive_section wpcd_clearfix">
            <?php
            global $current_url;
            $terms = get_terms( 'wpcd_coupon_category' );
            if ( !empty( $terms ) && !is_wp_error( $terms ) && !$disable_menu ):
                ?>
                <div class="wpcd_div_nav_block">
                    <div class="wpcd_cats">
                        <ul id="wpcd_cat_ul" class="wpcd_dropdown wpcd_categories_in_dropdown" style="display: none;">
                            <a href="javascript:void(0)" class="wpcd_dropbtn">
                                <?php echo __( 'Categories', 'wpcd-coupon' ); ?>
                            </a>
                            <div class="wpcd_dropdown-content">
                                <li>
                                    <a class="wpcd_category" data-category="all" href="<?php echo $current_url; ?>">
                                        <?php echo __( 'All Coupons', 'wpcd-coupon' ); ?>
                                    </a>
                                </li>
                                <?php foreach ( $terms as $term ): ?>
                                    <li>
                                        <a class="wpcd_category" data-category="<?php echo $term->slug; ?>"
                                           href="<?php echo $current_url . '?wpcd_category=' . $term->slug; ?>"><?php echo $term->name; ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </div>
                        </ul>
                        <ul id="wpcd_cat_ul" class="wpcd_categories_full">
                            <li>
                                <a class="wpcd_category" data-category="all" href="<?php echo $current_url; ?>">
                                    <?php echo __( 'All Coupons', 'wpcd-coupon' ); ?>
                                </a>
                            </li>
                            <?php foreach ( $terms as $term ): ?>
                                <li>
                                    <a class="wpcd_category" data-category="<?php echo $term->slug; ?>"
                                       href="<?php echo $current_url . '?wpcd_category=' . $term->slug; ?>"><?php echo $term->name; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div id="wpcd_searchbar">
                        <ul id="wpcd_cat_ul">
                            <li class="wpcd_searchbar_search">
                                <input type="text" placeholder="Search">
                            </li>
                        </ul>
                        <!--
                        <ul id="wpcd_cat_ul" class="wpcd_search2">
                            <li class="wpcd_searchbar_search">
                                <input type="text" placeholder="Search">
                            </li>
                            <span id="wpcd_searchbar_search_close" class="dashicons dashicons-dismiss"></span>
                        </ul>
                        -->
                    </div>
                </div>
                <div class="wpcd_cat_ul_border"></div>
            <?php endif; ?>
        <div class="wpcd_coupon_archive_container_main">
            <div class="wpcd_coupon_loader wpcd_coupon_hidden_loader">
                <img src="<?php echo WPCD_Plugin::instance()->plugin_assets . 'img/loading.gif'; ?>">
            </div>
            <div id="wpcd_coupon_archive_container">
    <?php endif; ?>
<?php endif; ?>