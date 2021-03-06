<?php
/*
   Plugin Name: WooTan
   Plugin URI: http://wordpress.org/extend/plugins/wootan/
   Version: 0.2
   Author: Derwent
   Description: Tailored Woocommerce extensions for TechnoTan namely a customized shipping plugin
   Text Domain: wootan
   License: GPLv3
  */

/*
    "WordPress Plugin Template" Copyright (C) 2014 Michael Simpson  (email : michael.d.simpson@gmail.com)

    This following part of this file is part of WordPress Plugin Template for WordPress.

    WordPress Plugin Template is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WordPress Plugin Template is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Contact Form to Database Extension.
    If not, see http://www.gnu.org/licenses/gpl-3.0.html
*/

$Wootan_minimalRequiredPhpVersion = '5.0';

/**
 * Check the PHP version and give a useful error message if the user's version is less than the required version
 * @return boolean true if version check passed. If false, triggers an error which WP will handle, by displaying
 * an error message on the Admin page
 */
function Wootan_noticePhpVersionWrong() {
    global $Wootan_minimalRequiredPhpVersion;
    echo '<div class="updated fade">' .
      __('Error: plugin "WooTan" requires a newer version of PHP to be running.',  'wootan').
            '<br/>' . __('Minimal version of PHP required: ', 'wootan') . '<strong>' . $Wootan_minimalRequiredPhpVersion . '</strong>' .
            '<br/>' . __('Your server\'s PHP version: ', 'wootan') . '<strong>' . phpversion() . '</strong>' .
         '</div>';
}

function Wootan_PhpVersionCheck() {
    global $Wootan_minimalRequiredPhpVersion;
    if (version_compare(phpversion(), $Wootan_minimalRequiredPhpVersion) < 0) {
        add_action('admin_notices', 'Wootan_noticePhpVersionWrong');
        return false;
    }
    return true;
}

function Wootan_noticeWoocommerceNotInstalled() {
    echo
        '<div class="updated fade">' .
        __('Error: plugin "WooTan" requires WooCommerce to be installed',  'WooTan') .
        '</div>';
}

function Wootan_WoocommerceCheck() {
    if( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        add_action('admin_notices', 'WooTan_noticeWoocommerceNotInstalled');
        return false;
    }
    return true;
}

function Wootan_noticeLasercommerceNotInstalled() {
    echo
        '<div class="updated fade">' .
        __('Error: plugin "WooTan" requires LaserCommerce to be installed',  'WooTan') .
        '</div>';
}

function Wootan_LasercommerceCheck() {
    if( !in_array( 'lasercommerce/lasercommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        add_action('admin_notices', 'WooTan_noticeLasercommerceNotInstalled');
        return false;
    }
    return true;
}

/**
 * Initialize internationalization (i18n) for this plugin.
 * References:
 *      http://codex.wordpress.org/I18n_for_WordPress_Developers
 *      http://www.wdmac.com/how-to-create-a-po-language-translation#more-631
 * @return void
 */
function Wootan_i18n_init() {
    $pluginDir = dirname(plugin_basename(__FILE__));
    load_plugin_textdomain('wootan', false, $pluginDir . '/languages/');
}




//////////////////////////////////
// Run initialization
/////////////////////////////////

// First initialize i18n
Wootan_i18n_init();


// Next, run the version check.
// If it is successful, continue with initialization for this plugin
if (Wootan_PhpVersionCheck()) {
    // Only load and run the init function if we know PHP version can parse it
    include_once('wootan_init.php');
    Wootan_init(__FILE__);
}
