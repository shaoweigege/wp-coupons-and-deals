<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 8/25/17
 * Time: 11:31 PM
 */

if ( !function_exists( 'wpcd_coupon_thumbnail_img' ) ) {
	include WPCD_Plugin::instance()->plugin_includes . 'functions/wpcd-coupon-thumbnail-img.php';
}

global $coupon_id, $parent, $max_num_page;
$title                     = get_the_title();
$link                      = get_post_meta( $coupon_id, 'coupon_details_link', true );
$coupon_code               = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$coupon_thumbnail          = wpcd_coupon_thumbnail_img( $coupon_id );
$discount_text             = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$coupon_type               = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$description               = get_post_meta( $coupon_id, 'coupon_details_description', true );
$deal_text                 = get_post_meta( $coupon_id, 'coupon_details_deal-button-text', true );
$coupon_hover_text         = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text           = get_option( 'wpcd_deal-hover-text' );
$button_class              = 'wpcd-btn-' . $coupon_id;
$no_expiry                 = get_option( 'wpcd_no-expiry-message' );
$expire_text               = get_option( 'wpcd_expire-text' );
$expired_text              = get_option( 'wpcd_expired-text' );
$hide_coupon_text          = get_option( 'wpcd_hidden-coupon-text' );
$hidden_coupon_hover_text  = get_option( 'wpcd_hidden-coupon-hover-text' );
$copy_button_text          = get_option( 'wpcd_copy-button-text' );
$coupon_title_tag          = get_option( 'wpcd_coupon-title-tag', 'h1' );
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$coupon_share              = get_option( 'wpcd_coupon-social-share' );
$show_expiration           = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                     = date( 'd-m-Y' );
$expire_date               = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expireDateFormat          = get_option( 'wpcd_expiry-date-format' );
$expire_time               = get_post_meta( $coupon_id, 'coupon_details_expire-time', true );
$never_expire              = get_post_meta( $coupon_id, 'coupon_details_never-expire-check', true );
$hide_coupon               = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_coupon_image_id      = get_post_meta( $coupon_id, 'coupon_details_coupon-image-input', true );
$wpcd_coupon_image_src     = wp_get_attachment_image_src( $wpcd_coupon_image_id, 'full' );
$wpcd_show_print           = get_post_meta( $coupon_id, 'coupon_details_coupon-image-print', true );
$wpcd_image_width          = get_post_meta( $coupon_id, 'coupon_details_coupon-image-width', true );
$wpcd_image_height         = get_post_meta( $coupon_id, 'coupon_details_coupon-image-height', true );
$template                  = new WPCD_Template_Loader();
if ( is_array( $wpcd_coupon_image_src ) ) {
	$wpcd_coupon_image_src = $wpcd_coupon_image_src[0];
} else {
	$wpcd_coupon_image_src = '';
}
if( ! $link && WPCD_Amp::wpcd_amp_is() ) $link = "#";

$expireDateFormatFun = wpcd_getExpireDateFormatFun( $expireDateFormat );
if ( ! empty( $expire_date ) && (string)(int)$expire_date == $expire_date ) {
    $expire_date = date( $expireDateFormatFun, $expire_date );
} elseif ( ! empty( $expire_date ) ) {
    $expire_date = date( $expireDateFormatFun, strtotime( $expire_date ) );
}
$expire_date_format = date( "m/d/Y", strtotime( $expire_date ) );

$wpcd_coupon_template     = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );
$wpcd_template_five_theme = get_post_meta( $coupon_id, 'coupon_details_template-five-theme', true ); // the color of five theme
$wpcd_template_six_theme  = get_post_meta( $coupon_id, 'coupon_details_template-six-theme', true ); // the color of the theme six
$wpcd_dummy_coupon_img   = WPCD_Plugin::instance()->plugin_assets . 'img/coupon-200x200.png';

$wpcd_text_to_show = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text  = get_option( 'wpcd_custom-text' );

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}
$coupon_code = ( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) );
$deal_text = ( ! empty( $deal_text ) ? $deal_text : __( 'Claim This Deal', 'wpcd-coupon' ) );
$coupon_hover_text = ( ! empty( $coupon_hover_text ) ) ? $coupon_hover_text : __( 'Click To Copy Coupon', 'wpcd-coupon' );
$deal_hover_text = ( !empty( $deal_hover_text ) ) ? $deal_hover_text : __( 'Click Here To Get This Deal' );

include('header-category__premium_only.php');
?>
<?php if ( $coupon_type === 'Image' ): ?>
<?php 
    include('coupon_type__image.php'); 
    if ( WPCD_Amp::wpcd_amp_is() ) {
        WPCD_Amp::instance()->setCss( 'shortcode_image' );
    } 
?>
<?php else: ?>
<!--- Template Seven start -->
        <section class="wpcd_seven wpcd-coupon-id-<?php echo $coupon_id; ?> wpcd_item"
                 wpcd-data-search="<?php echo $title;?>">
            <div class="wpcd_seven_container">
                <div class="wpcd_seven_couponBox">
                    <div class="wpcd_seven_percentAndPic">
                        <div class="wpcd_seven_percentOff">
                            <p><?php echo $discount_text; ?></p>
                        </div>

                        <div class="wpcd_seven_productPic">
                            <?php if($coupon_thumbnail): ?>
                                <a href="<?php echo $link; ?>" target="_blank">
                                    <img src="<?php echo $coupon_thumbnail; ?>"
                                         alt="<?php _e( 'Coupon image not uploaded', 'wpcd-coupon' ); ?>" alt="Product-pic">
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="wpcd_seven_headingAndExpire">
                        <div class="wpcd_seven_heading">
                        <?php
                            if ( 'on' === $disable_coupon_title_link ) { ?>
                                <<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-new-title">
                                    <?php echo $title; ?>
                                </<?php echo esc_html( $coupon_title_tag ); ?>> <?php
                            } else { ?>
                                <<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-new-title">
                                    <a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
                                </<?php echo esc_html( $coupon_title_tag ); ?>> <?php
                            }?>
                            <div class="wpcd-coupon-description">
                                <span class="wpcd-full-description"><?php echo wpautop( $description, false );?></span>
                                <span class="wpcd-short-description"></span>
                                <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
                                    <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
                                    <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($coupon_type == 'Coupon') : ?>
                        <?php if (!empty($coupon_code)) : ?>
                            <div class="wpcd_seven_buttonSociaLikeDislike wpcd_template_seven_archive_button">
                                <?php if ( $hide_coupon === 'Yes' && ! WPCD_Amp::wpcd_amp_is() ): ?>
                                    <?php
                                    $template->get_template_part( 'hide-coupon3__premium_only' );
                                    ?>
                                <?php else: ?>
                                    <div class="wpcd_seven_btn">
                                        <a class="masterTooltip <?php echo $button_class; ?>" 
                                            href="<?php echo $link; ?>"
                                            target="_blank"
                                            title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                                             echo $coupon_hover_text;
                                                         }
                                                     ?>"
                                            data-clipboard-text="<?php echo $coupon_code; ?>"
                                            data-title-ab="<?php echo $coupon_code; ?>"><?php echo $coupon_code; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($coupon_type == 'Deal') : ?>
                        <?php if (!empty($deal_text)) : ?>
                            <div class="wpcd_seven_buttonSociaLikeDislike">
                                <div class="wpcd_seven_btn">
                                    <a class="masterTooltip" 
                                        href="<?php echo $link; ?>"
                                        target="_blank"
                                        title="<?php echo $deal_hover_text; ?>"
                                        data-title-ab="<?php echo $deal_text; ?>"><?php echo $deal_text; ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="wpcd_seven_expire_correct_box">
                        <div class="wpcd_seven_expire">
                                <p>
                                <?php if( ! empty( trim( $expire_date ) ) && $never_expire != 'on' ) : ?>
                                    <?php if( ! WPCD_Amp::wpcd_amp_is() ) { ?>
                                        <?php
                                        if ( ! empty( $expire_text ) ) {
                                            echo $expire_text;
                                        } else {
                                            echo __( 'Expires on: ', 'wpcd-coupon' );
                                        }
                                        ?>
                                        <span class="wpcd-coupon-seven-countdown" data-countdown_coupon="<?php echo $expire_date_format . ' ' . $expire_time; ?>" id="clock_seven_<?php echo $coupon_id; ?>"></span>
                                    <?php } else { 
                                        if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                                            <span class="wpcd-coupon-expire">
                                                <?php
                                                if ( ! empty( $expire_text ) ) {
                                                    echo $expire_text . ' ' . $expire_date;
                                                } else {
                                                    echo __( 'Expires on: ', 'wpcd-coupon' ) . $expire_date;
                                                }
                                                ?>
                                            </span>
                                        <?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                                            <span class="wpcd-coupon-expired">
                                                <?php
                                                if ( ! empty( $expired_text ) ) {
                                                    echo $expired_text . ' ' . $expire_date;
                                                } else {
                                                    echo __( 'Expired on: ', 'wpcd-coupon' ) . $expire_date;
                                                }
                                                ?>
                                            </span>
                                        <?php } ?>
                                    <?php } ?>
                                <?php else : ?>
                                    <b class="never-expire">
                                        <?php if ( ! empty( $no_expiry ) ) : ?>
                                                <b><?php echo $no_expiry; ?></b>
                                        <?php else : ?>
                                                <b><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></b>
                                        <?php endif; ?>
                                    </b>
                                <?php endif; ?> 
                            </p>
                        </div>
                    </div>
                    <div class="wpcd_seven_couponBox_both"></div>
                    <script type="text/javascript">
                        var clip = new Clipboard('.<?php echo $button_class; ?>');
                    </script>
                    <div class="clearfix"></div>
                    <?php
                    if( !WPCD_Amp::wpcd_amp_is() ):
                        if ( $coupon_share === 'on' ) {
                            $template->get_template_part('social-share');
                        }
                        $template->get_template_part('vote-system');
                    endif;
                    ?>
                    </div>
            </div>    
        </section>
	 <!--  Template Seven End -->
    <?php endif; ?>
<?php include('footer-category__premium_only.php'); ?>
