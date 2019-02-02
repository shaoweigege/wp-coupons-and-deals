<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 8/25/17
 * Time: 11:31 PM
 */
/**
 *
 * This exits from the script if it's accessed
 * directly from somewhere else.
 *
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('wpcd_coupon_thumbnail_img')) {
    include WPCD_Plugin::instance()->plugin_includes . 'functions/wpcd-coupon-thumbnail-img.php';
}

global $coupon_id, $max_num_page;
$title = get_the_title();
$link = get_post_meta($coupon_id, 'coupon_details_link', true);
$coupon_code = get_post_meta($coupon_id, 'coupon_details_coupon-code-text', true);
$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
$coupon_thumbnail = wpcd_coupon_thumbnail_img($coupon_id);
$discount_text = get_post_meta($coupon_id, 'coupon_details_discount-text', true);
$coupon_type = get_post_meta($coupon_id, 'coupon_details_coupon-type', true);
$description = get_post_meta($coupon_id, 'coupon_details_description', true);
$deal_text = get_post_meta($coupon_id, 'coupon_details_deal-button-text', true);
$coupon_hover_text = get_option('wpcd_coupon-hover-text');
$deal_hover_text = get_option('wpcd_deal-hover-text');
$button_class = 'wpcd-btn-' . $coupon_id;
$no_expiry = get_option('wpcd_no-expiry-message');
$expire_text = get_option('wpcd_expire-text');
$expired_text = get_option('wpcd_expired-text');
$hide_coupon_text = get_option('wpcd_hidden-coupon-text');
$hidden_coupon_hover_text = get_option('wpcd_hidden-coupon-hover-text');
$copy_button_text = get_option('wpcd_copy-button-text');
$coupon_title_tag = get_option('wpcd_coupon-title-tag', 'h1');
$disable_coupon_title_link = get_option('wpcd_disable-coupon-title-link');
$coupon_share = get_option('wpcd_coupon-social-share');
$show_expiration = get_post_meta($coupon_id, 'coupon_details_show-expiration', true);
$today = date('d-m-Y');
$expire_date = get_post_meta($coupon_id, 'coupon_details_expire-date', true);
$expire_date_format = date("F jS Y", strtotime($expire_date));
$never_expire = get_post_meta($coupon_id, 'coupon_details_never-expire-check', true);
$expire_time = get_post_meta($coupon_id, 'coupon_details_expire-time', true);
$hide_coupon = get_post_meta($coupon_id, 'coupon_details_hide-coupon', true);
$wpcd_coupon_image_id = get_post_meta($coupon_id, 'coupon_details_coupon-image-input', true);
$wpcd_coupon_image_src = wp_get_attachment_image_src($wpcd_coupon_image_id, 'full');
$wpcd_show_print = get_post_meta($coupon_id, 'coupon_details_coupon-image-print', true);
$wpcd_image_width = get_post_meta($coupon_id, 'coupon_details_coupon-image-width', true);
$wpcd_image_height = get_post_meta($coupon_id, 'coupon_details_coupon-image-height', true);
$disable_menu = get_option('wpcd_disable-menu-archive-code');
$template = new WPCD_Template_Loader();
$coupon_categories = get_the_terms($coupon_id, 'wpcd_coupon_category');
$coupon_categories_class = '';
$post_id = get_the_ID();

if ($coupon_categories && count($coupon_categories) > 0) {
    foreach ($coupon_categories as $category) {
        $coupon_categories_class .= ' ' . $category->slug;
    }
}

if (is_array($wpcd_coupon_image_src)) {
    $wpcd_coupon_image_src = $wpcd_coupon_image_src[0];
} else {
    $wpcd_coupon_image_src = '';
}

$wpcd_coupon_template = get_post_meta($coupon_id, 'coupon_details_coupon-template', true);
$wpcd_template_five_theme = get_post_meta($coupon_id, 'coupon_details_template-five-theme', true);
$wpcd_coupon_thumbnail = $featured_img_url;
$wpcd_template_six_theme = get_post_meta($coupon_id, 'coupon_details_template-six-theme', true);
$wpcd_dummy_coupon_img = WPCD_Plugin::instance()->plugin_assets . 'img/coupon-200x200.png';
$wpcd_text_to_show = get_option('wpcd_text-to-show');
$wpcd_custom_text = get_option('wpcd_custom-text');
$dt_coupon_type_name = get_option('wpcd_dt-coupon-type-text');
$dt_deal_type_name = get_option('wpcd_dt-deal-type-text');

if ($wpcd_text_to_show == 'description') {
    $wpcd_custom_text = $description;
} else {
    if (empty($wpcd_custom_text)) {
        $wpcd_custom_text = __("Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon');
    }
}

/*
 * to build the parent elment
 * header and in the bottom footer
 */
global $parent;
include('header-default.php');
?>
<?php if ($coupon_type === 'Image'): ?>
    <?php include('coupon_type__image.php'); ?>
<?php else: ?>
    <!--  Template Seven Start -->
    <section
            class="wpcd_seven wpcd-coupon-id-<?php echo $coupon_id; ?> wpcd_item <?php echo $coupon_categories_class; ?>"
            wpcd-data-search="<?php echo $title; ?>">
        <div class="wpcd_seven_container">
            <div class="wpcd_seven_couponBox">
                <div class="wpcd_seven_percentAndPic">
                    <div class="wpcd_seven_percentOff">
                        <p><?php echo $discount_text; ?></p>
                    </div>

                    <div class="wpcd_seven_productPic">
                        <?php if ($coupon_thumbnail): ?>
                            <a href="<?php echo $link; ?>" target="_blank">
                                <img src="<?php echo $coupon_thumbnail; ?>"
                                     alt="<?php _e('Coupon image not uploaded', 'wpcd-coupon'); ?>" alt="Product-pic">
                            </a>
                        <?php else: ?>
                            <img src="http://rdironworks.com/wp-content/uploads/2017/12/dummy-200x200.png"
                                 alt="Product-pic">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="wpcd_seven_headingAndExpire">
                    <div class="wpcd_seven_heading">
                        <?php
                        if ('on' === $disable_coupon_title_link) { ?>
                        <<?php echo esc_html($coupon_title_tag); ?> class="wpcd-new-title">
                        <?php echo $title; ?>
                    </<?php echo esc_html($coupon_title_tag); ?>> <?php
                    } else { ?>
                    <<?php echo esc_html($coupon_title_tag); ?> class="wpcd-new-title">
                    <a href="<?php echo esc_url($link); ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
                </<?php echo esc_html($coupon_title_tag); ?>> <?php
                } ?>
                <p><?php echo wpautop($description, false); ?></p>
                <div class="wpcd_seven_expire">
                    <p>
                        <?php
                        if ($coupon_type == 'Coupon') {
                        if ($show_expiration == 'Show') {
                        if (!empty($expire_date)) {
                        if (strtotime($expire_date) >= strtotime($today)) { ?>
                        <span class="wpcd-coupon-seven-countdown">
                    <p class="wpcd-new-expire-text">
                        <?php
                        if (!empty($expire_text)) {
                            echo $expire_text . ' ' . $expire_date_format;
                        } else {
                            echo __('Expires on: ', 'wpcd-coupon') . $expire_date_format;
                        }
                        ?>
                    </p>
                    </span>
                    <?php } elseif (strtotime($expire_date) < strtotime($today)) { ?>
                        <span class="wpcd-coupon-seven-countdown">
                                <p class="wpcd-new-expired-text">
                                    <?php
                                    if (!empty($expired_text)) {
                                        echo $expired_text . ' ' . $expire_date_format;
                                    } else {
                                        echo __('Expired on: ', 'wpcd-coupon') . $expire_date_format;
                                    }
                                    ?>
                                </p>
                                </span>
                    <?php }
                    } else { ?>
                        <span class="wpcd-coupon-seven-countdown">
                            <p class="wpcd-new-expire-text">
                                <?php if (!empty($no_expiry)) {
                                    echo $no_expiry;
                                } else {
                                    echo __("Doesn't expire", 'wpcd-coupon');
                                } ?>
                            </p>
                        </span>
                    <?php }
                    } else {
                        echo '';
                    }

                    } elseif ($coupon_type == 'Deal') {
                        if ($show_expiration == 'Show') {
                            if (!empty($expire_date)) {
                                if (strtotime($expire_date) >= strtotime($today)) { ?>
                                    <p class="wpcd-new-expire-text">
                                        <?php
                                        if (!empty($expire_text)) {
                                            echo $expire_text . ' ' . $expire_date_format;
                                        } else {
                                            echo __('Expires on: ', 'wpcd-coupon') . $expire_date_format;
                                        }
                                        ?>
                                    </p>
                                <?php } elseif (strtotime($expire_date) < strtotime($today)) { ?>
                                    <p class="wpcd-new-expired-text">
                                        <?php
                                        if (!empty($expired_text)) {
                                            echo $expired_text . ' ' . $expire_date_format;
                                        } else {
                                            echo __('Expired on: ', 'wpcd-coupon') . $expire_date_format;
                                        }
                                        ?>
                                    </p>
                                <?php }

                            } else { ?>

                                <p class="wpcd-new-expire-text">

                                    <?php if (!empty($no_expiry)) {
                                        echo $no_expiry;
                                    } else {
                                        echo __("Doesn't expire", 'wpcd-coupon');
                                    }
                                    ?>
                                </p>

                            <?php }
                        } else {
                            echo '';
                        }
                    } ?>
                    </p>
                </div>
            </div>
        </div>
        <?php if ($coupon_type == 'Coupon') : ?>
            <?php if (!empty($coupon_code)) : ?>
                <div class="wpcd_seven_buttonSociaLikeDislike">
                    <div class="wpcd_seven_btn">
                        <a href="<?php echo $link; ?>"
                           title="<?php echo $coupon_code; ?>"><?php echo $coupon_code; ?></a>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($coupon_type == 'Deal') : ?>
            <?php if (!empty($deal_text)) : ?>
                <div class="wpcd_seven_buttonSociaLikeDislike">
                    <div class="wpcd_seven_btn">
                        <a href="<?php echo $link; ?>"
                           title="<?php echo $deal_text; ?>"><?php echo $deal_text; ?></a>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>
    <!--  Template Seven End -->
<?php endif; ?>
<?php include('footer-default.php'); ?>