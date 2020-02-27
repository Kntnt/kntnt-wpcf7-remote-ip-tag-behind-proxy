<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt remote ip tag behind proxy for Contact Form 7
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Ensures that the mail tag [_remote_ip] of Contact Form 7 is correctly set behind a reverse proxy.
 * Version:           1.0.0
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined( 'ABSPATH' ) || die;

add_filter( 'wpcf7_special_mail_tags', function ( $output, $name, $html ) {
    $name = preg_replace( '/^wpcf7\./', '_', $name ); // for back-compat
    if ( '_remote_ip' == $name ) {
        if ( isset( $_SERVER['HTTP_X_REAL_IP'] ) && $_SERVER['HTTP_X_REAL_IP'] ) {
            $output = $_SERVER['HTTP_X_REAL_IP'];
        }
        else if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && $_SERVER['HTTP_X_FORWARDED_FOR'] ) {
            $output = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    return $output;
}, 11, 3 );
