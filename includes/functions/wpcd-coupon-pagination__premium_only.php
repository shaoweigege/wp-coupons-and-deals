<?php
/**
 * Function for Create of Links by number page and current URL
 * 
 * @since 2.7.3
 * @param string $current_url, $necessary_page_num
 * @return string
 */
if( !function_exists( 'wpcd_generatePageUrl' ) ) {
    function wpcd_generatePageUrl( $current_url, $necessary_page_num ) {
        $current_url_new = '';
        $pos1 = strpos( $current_url, '?' );

        if( $pos1 === false ) {
            $current_url_new = $current_url . '?wpcd_page_num=' . $necessary_page_num;
        } else {
            $pos2 = strpos( $current_url, 'wpcd_page_num' );
            if( $pos2 === false ) {
                $current_url_new .= $current_url . '&wpcd_page_num=' . $necessary_page_num;
            } else {
                $current_url_one_del = explode( '?', $current_url );
                if( is_array( $current_url_one_del ) ) {
                    $current_url_params = $current_url_one_del[1];
                    $current_url_params_del = explode( '&', $current_url_params );
                    if( is_array( $current_url_params_del ) ) {
                        $current_url_params_new_arr = array();
                        foreach ($current_url_params_del as $single_par) {
                            $pos3 = strpos( $single_par, 'wpcd_page_num=' );
                            if( $pos3 !== false ) {
                                $current_url_params_new_arr[] = 'wpcd_page_num=' . $necessary_page_num;
                            } else {
                                $current_url_params_new_arr[] .= $single_par;
                            }
                        }
                        $current_url_params_new = implode( '&', $current_url_params_new_arr );
                        $current_url_new = $current_url_one_del[0] . '?' . $current_url_params_new;
                    }
                }
            }
        }
        return $current_url_new;
    }
}

/**
 * Function for Create Pagination for Arhive, Category and Vendor pages
 * 
 * @since 2.7.3
 * @param int $max_num_page, int $end_size, int $mid_size, bool $prev_next, bool $show_all
 * @return string
 */           
if( !function_exists( 'wpcd_generatePagination' ) ) {
    function wpcd_generatePagination( $max_num_page, $end_size = 1, $mid_size = 2, $prev_next = true, $show_all = false ) {
        $pageNum=( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $current_url = get_pagenum_link( $pageNum );
        if( $max_num_page < 2 ) {
            return;
        }
        $current = 1;
        if( isset( $_GET['wpcd_page_num'] ) && ! empty( $_GET['wpcd_page_num'] ) && absint( $_GET['wpcd_page_num'] ) == $_GET['wpcd_page_num'] ) $current = absint( $_GET['wpcd_page_num'] );
        $page_links = array();
        if ( $prev_next && $current && 1 < $current ) :
            $current_minus_one = $current - 1;
            $page_links[] = '<a class="prev page-numbers" href="' . esc_url( wpcd_generatePageUrl( $current_url, $current_minus_one ) ) . '">« Prev</a>';
        endif;
        for ( $n = 1; $n <= $max_num_page; $n++ ) :
            if ( $n == $current ) :
                $page_links[] = "<span class='page-numbers current'>" . number_format_i18n( $n ) . "</span>";
                $dots = true;
            else :
                if ( $show_all || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $max_num_page - $end_size ) ) :

                    $page_links[] = "<a class='page-numbers' href='" . esc_url( wpcd_generatePageUrl($current_url, $n) ) . "'>" . number_format_i18n( $n ) . "</a>";
                    $dots = true;
                elseif ( $dots && ! $show_all ) :
                    $page_links[] = '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>';
                    $dots = false;
                endif;
            endif;
        endfor;
        if ( $prev_next && $current && $current < $max_num_page ) :
            
            $current_plus_one = $current + 1;
            $page_links[] = '<a class="next page-numbers" href="' . esc_url( wpcd_generatePageUrl($current_url, $current_plus_one) ) . '">Next »</a>';
        endif;

        if( is_array( $page_links ) && count( $page_links ) > 0 ) {
            return implode(' ', $page_links);
        } 
    }
}


/**
 * This function execute preparation of category links for archive, category and vendor menus
 *
 * @since 2.7.3
 * @return string
 */
if( ! function_exists( 'wpcd_preparationMenuLinks' ) ) {
    function wpcd_preparationMenuLinks( $wpcd_term_field_name ) {
        $pageNum = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $current_url = get_pagenum_link( $pageNum );
        $pos = strpos( $current_url, '?' );
        $current_url_final = array();
        if( $pos !== false ) {
            $current_url_exp = explode( '?', $current_url );
            $current_url_exp[1] = html_entity_decode( $current_url_exp[1] );
            if( strpos( $current_url_exp[1], $wpcd_term_field_name ) !== false || strpos( $current_url_exp[1], 'wpcd_page_num' ) !== false) {
                $parametrs_arr = explode('&', $current_url_exp[1]);
                if( is_array( $parametrs_arr ) && count( $parametrs_arr ) > 0 ) {
                    $parametrs_arr_new = array();
                    foreach ( $parametrs_arr as $single_par ) {
                        if( strpos( $single_par, $wpcd_term_field_name ) !== false) {
                            continue;
                        } 
                        if ( strpos( $single_par, $wpcd_term_field_name ) !== false ) {
                            continue;
                        }
                        $parametrs_arr_new[] = $single_par;
                    }

                    if( count( $parametrs_arr_new ) > 0) {
                        $parametrs_new = implode( '&', $parametrs_arr_new );
                        $current_url_final['sin'] = $current_url_exp[0] . '?' . $parametrs_new . '&';
                        $current_url_final['all'] = $current_url_exp[0] . '?' . $parametrs_new;
                    } else {
                        $current_url_final['all'] = $current_url_exp[0];
                        $current_url_final['sin'] = $current_url_exp[0] . '?';
                    }

                }
            } else {
                $current_url_final['all'] = $current_url_exp[0] . '?' . $current_url_exp[1];
                $current_url_final['sin'] = $current_url_exp[0] . '?' . $current_url_exp[1] . '&';
            }
        } else {
            $current_url_final['all'] = $current_url;
            $current_url_final['sin'] = $current_url. '?';
        }

        return $current_url_final;
    }
}