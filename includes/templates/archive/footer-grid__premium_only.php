<?php
/*
 * Footer Grid for Templates
 */
if ( $parent == 'footer' || $parent == 'headerANDfooter' ): 
    if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ):
        echo "</ul>";
    endif;
?>                
    <div id="wpcd_coupon_pagination_wr" class="wpcd_coupon_pagination wpcd_clearfix" wpcd-data-action="wpcd_coupons_category_action">
        
        <?php
            if( ! WPCD_Amp::wpcd_amp_is() ) {
                $add_args = array();
            
                $archive_category_setting = get_option( 'wpcd_archive-munu-categories' );
                if( $archive_category_setting == 'vendor' ) {
                    $wpcd_coupon_taxonomy = WPCD_Plugin::VENDOR_TAXONOMY;
                    $wpcd_term_field_name = 'wpcd_vendor';
                } else {
                    $wpcd_coupon_taxonomy = WPCD_Plugin::CUSTOM_TAXONOMY;
                    $wpcd_term_field_name = 'wpcd_category';
                }

                if ( isset( $_POST[$wpcd_term_field_name] ) && ! empty( $_POST[$wpcd_term_field_name] ) && 
                        sanitize_text_field( $_POST[$wpcd_term_field_name] ) === $_POST[$wpcd_term_field_name] ) {
                    if ( get_term_by('slug', sanitize_text_field( $_POST[$wpcd_term_field_name] ), $wpcd_coupon_taxonomy ) ) {
                        $add_args[$wpcd_term_field_name] = sanitize_text_field( $_POST[$wpcd_term_field_name] );
                    }
                } elseif ( isset($_GET[$wpcd_term_field_name] ) && ! empty( $_GET[$wpcd_term_field_name] ) && 
                        sanitize_text_field( $_GET[$wpcd_term_field_name] ) === $_GET[$wpcd_term_field_name] ) {
                    if ( get_term_by( 'slug', sanitize_text_field( $_GET[$wpcd_term_field_name] ), $wpcd_coupon_taxonomy ) ) {
                        $add_args[$wpcd_term_field_name] = sanitize_text_field( $_GET[$wpcd_term_field_name] );
                    }
                }
                
                if ( isset( $_POST['wpcd_page_num'] ) && ! empty( $_POST['wpcd_page_num'] ) && 
                        absint( $_POST['wpcd_page_num'] ) == $_POST['wpcd_page_num'] ) {
                    $current = absint( $_POST['wpcd_page_num'] );
                } elseif ( isset( $_GET['wpcd_page_num'] ) && ! empty( $_GET['wpcd_page_num'] ) && 
                        absint( $_GET['wpcd_page_num'] ) == $_GET['wpcd_page_num'] ) {
                    $current = absint( $_GET['wpcd_page_num'] );
                } else {
                    $current = 1;
                }

                if( isset( $_POST['search_text'] ) && ! empty( $_POST['search_text'] ) && 
                        sanitize_text_field( $_POST['search_text'] ) === trim( $_POST['search_text'] ) ) {
                    $add_args['search_text'] = sanitize_text_field( $_POST['search_text'] );
                }
            
                echo paginate_links( 
                    array(
                        'base'      => '?wpcd_page_num=%#%',
                        'format'    => '?page=%#%',
                        'add_args'  => $add_args,
                        'current'   => $current,
                        'total'     => $max_num_page,
                        'prev_next' => true,
                        'prev_text' => __( '« Prev', 'wpcd-coupon' ),
                        'next_text' => __( 'Next »', 'wpcd-coupon' ),
                    )
                );  

                if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ) {
                    echo '</div></div> <!-- wpcd_coupon_archive_container -->';
                    echo '</div> <!-- wpcd_coupon_archive_container_main -->';
                }
                
            } else {
                echo wpcd_generatePagination( $max_num_page );
                echo "</div>";
            }
        ?>
</section>
<?php endif; ?>