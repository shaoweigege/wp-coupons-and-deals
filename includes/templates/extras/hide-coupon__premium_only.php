<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 9/10/17
 * Time: 8:43 PM
 */

global $coupon_id, $num_coupon;

$title                    = get_the_title();
$description              = get_post_meta( $coupon_id, 'coupon_details_description', true );
$discount_text            = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$featured_img_url         = get_the_post_thumbnail_url( get_the_ID(), 'large' );
$coupon_type              = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$link                     = get_post_meta( $coupon_id, 'coupon_details_link', true );
$coupon_code              = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$deal_text                = get_post_meta( $coupon_id, 'coupon_details_deal-button-text', true );
$coupon_hover_text        = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text          = get_option( 'wpcd_deal-hover-text' );
$button_class             = 'wpcd-btn-' . $coupon_id;
$no_expiry                = get_option( 'wpcd_no-expiry-message' );
$expire_text              = get_option( 'wpcd_expire-text' );
$expired_text             = get_option( 'wpcd_expired-text' );
$hide_coupon_text         = get_option( 'wpcd_hidden-coupon-text' );
$hidden_coupon_hover_text = get_option( 'wpcd_hidden-coupon-hover-text' );
$copy_button_text         = get_option( 'wpcd_copy-button-text' );
$show_expiration          = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                    = date( 'd-m-Y' );
$expire_date              = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$hide_coupon              = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );

$wpcd_text_to_show       = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text        = get_option( 'wpcd_custom-text' );
$wpcd_enable_goto_button = get_option( 'wpcd_popup-goto-link' );
$wpcd_custom_goto        = get_option( 'wpcd_popup-goto-custom-text' );

$new_coupon_id         = $coupon_id;
$wpcd_coupon_template  = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );
$wpcd_coupon_thumbnail = $featured_img_url;

$archive_category_setting = get_option( 'wpcd_archive-munu-categories' );
if( $archive_category_setting == 'vendor' ) {
    $wpcd_coupon_taxonomy = WPCD_Plugin::VENDOR_TAXONOMY;
    $wpcd_term_field_name = 'wpcd_vendor';
} else {
    $wpcd_coupon_taxonomy = WPCD_Plugin::CUSTOM_TAXONOMY;
    $wpcd_term_field_name = 'wpcd_category';
}

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}

$wpcd_show_coupon_popup = ! empty( $_GET['wpcd_coupon'] ) && $_GET['wpcd_coupon'] == $coupon_id;

if ( isset( $_POST['wpcd_page_num'] ) && ! empty( $_POST['wpcd_page_num'] ) && absint( $_POST['wpcd_page_num'] ) == $_POST['wpcd_page_num'] ) {
    $wpcd_page_num = '&wpcd_page_num=' . absint( $_POST['wpcd_page_num'] );
} elseif ( isset( $_GET['wpcd_page_num'] ) && ! empty( $_GET['wpcd_page_num'] ) && absint( $_GET['wpcd_page_num'] ) == $_GET['wpcd_page_num'] ) {
    $wpcd_page_num = '&wpcd_page_num=' . absint( $_GET['wpcd_page_num'] );
} else {
    $wpcd_page_num = '';
}

if ( isset( $_POST[$wpcd_term_field_name] ) && ! empty( $_POST[$wpcd_term_field_name] ) && sanitize_text_field( $_POST[$wpcd_term_field_name] ) === $_POST[$wpcd_term_field_name] ) {
    $wpcd_data_taxonomy = '&' . $wpcd_term_field_name . '=' . sanitize_text_field( $_POST[$wpcd_term_field_name] );
} elseif ( isset( $_GET[$wpcd_term_field_name] ) && ! empty( $_GET[$wpcd_term_field_name] ) && sanitize_text_field( $_GET[$wpcd_term_field_name] ) === $_GET[$wpcd_term_field_name] ) {
    $wpcd_data_taxonomy = '&' . $wpcd_term_field_name . '=' . sanitize_text_field( $_GET[$wpcd_term_field_name] );
} else {
    $wpcd_data_taxonomy = '';
}

?>


    <div class="coupon-code-wpcd coupon-detail wpcd-coupon-id-<?php echo $new_coupon_id; ?> wpcd-coupon-button-type">
        <a data-type="code" data-coupon-id="<?php echo $new_coupon_id; ?>"
           href="?wpcd_coupon=<?php echo $new_coupon_id; echo $wpcd_data_taxonomy; echo $wpcd_page_num; ?>" class="coupon-button coupon-code-wpcd masterTooltip"
           id="coupon-button-<?php echo $new_coupon_id; ?>" title="<?php if ( ! empty( $hidden_coupon_hover_text ) ) {
			echo $hidden_coupon_hover_text;
		} else {
			_e( 'Click Here to Show Code', 'wpcd-coupon' );
		} ?>" data-position="top center" data-inverted="" data-aff-url="<?php echo $link; ?>"
           onClick="return wpcd_openCouponAffLink(this,  '<?php echo $new_coupon_id; ?>', '<?php echo $wpcd_term_field_name;?>' )" target="_blank">
            <span class="code-text-wpcd" rel="nofollow"><?php echo( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) ); ?></span>
            <span class="get-code-wpcd">
        <?php
        if ( ! empty( $hide_coupon_text ) ) {
	        echo $hide_coupon_text;
        } else {
	        echo __( 'Show Code', 'wpcd-coupon' );
        }

        ?>
        </span>

        </a>
    </div>

    <!-- Coupon Popup -->
    <section id="wpcd_coupon_popup_<?php echo $new_coupon_id; ?>" class="wpcd_coupon_popup_wr" style="display:none">
        <div class="wpcd_coupon_popup_layer"></div>
        <div class="wpcd_coupon_popup_inner">
            <div class="wpcd_coupon_popup_top_head">
                <p class="wpcd_coupon_popup_title">
					<?php echo get_the_title( $new_coupon_id ) ?>
                </p>
                <span class="wpcd_coupon_popup_close">&times;</span>
            </div>
            <div class="wpcd_coupon_popup_copy_main">
                <div class="wpcd_coupon_popup_copy_text">
                    <p><?php echo $wpcd_custom_text; ?></p>
                </div>
                <div class="wpcd_coupon_popup_copy_code_wr">
                    <span class="wpcd_coupon_popup_copy_code_span"><?php echo( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) ); ?></span>
                    <span class="wpcd_coupon_top_copy_span wpcd_coupon_top_copy_span_<?php echo $new_coupon_id; ?>"
                          data-clipboard-text="<?php echo( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) ); ?>"><?php if ( ! empty( $copy_button_text ) ) {
							echo $copy_button_text;
						} else {
							echo __( 'Copy', 'wpcd-coupon' );
						} ?></span>
                    <span id="coupon_code_<?php echo $new_coupon_id; ?>"
                          style="display:none;"><?php echo( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) ); ?></span>
                </div>
				<?php
				$copy_button_text = get_option( 'wpcd_copy-button-text' );
				$after_copy_text  = get_option( 'wpcd_after-copy-text' );

				if ( ! empty( $copy_button_text ) ) {
					$button_text = $copy_button_text;
				} else {
					$button_text = __( 'Copy', 'wpcd-coupon' );
				}

				if ( ! empty( $after_copy_text ) ) {
					$after_copy = $after_copy_text;
				} else {
					$after_copy = __( 'Copied', 'wpcd-coupon' );
				}
				?>
                <script type="text/javascript">

                    var clip = new Clipboard('.wpcd_coupon_top_copy_span_<?php echo $new_coupon_id; ?>');
                    clip.on("success", function () {

                        document.querySelector('.wpcd_coupon_top_copy_span_<?php echo $new_coupon_id; ?>').innerText = '<?php echo $after_copy; ?>';
                        setTimeout(function () {
                            document.querySelector('.wpcd_coupon_top_copy_span_<?php echo $new_coupon_id; ?>').innerText = '<?php echo $button_text; ?>';
                        }, 500);

                    });
                </script>
	            <?php if ( $wpcd_enable_goto_button === 'on' ) { ?>
                    <a target="_blank" rel="nofollow" class="wpcd_popup-go-link" href="<?php echo $link; ?>">
			            <?php

			            if ( ! empty( $wpcd_custom_goto ) ) {
				            echo $wpcd_custom_goto;
			            } else {
				            echo __( 'Go to Offer', 'wpcd-coupon' );
			            }

			            ?>
                    </a>
	            <?php } ?>
            </div>
        </div>
    </section>


<?php if ( isset( $_GET['wpcd_coupon'] ) && $_GET['wpcd_coupon'] != '' && $_GET['wpcd_coupon'] == $new_coupon_id ) { ?>

    <script type="text/javascript">
        function open_wpcd_popup(id) {
            jQuery("#wpcd_coupon_popup_" + id).fadeIn();
        }

        open_wpcd_popup("<?php echo $new_coupon_id; ?>");
    </script>

<?php } ?>
