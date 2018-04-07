<?php
/*
Plugin Name: Organize Series Addon - Extra Tokens
Description: This addon for the Organize Series plugin provides Extra %tokens% for customizing the auto-inserted output of series related information.
Version: 0.8.3.rc.000
Author: Darren Ethier
Author URI: http://organizeseries.com
*/

/* LICENSE */
//"Organize Series Plugin" and all addons for it created by this author are copyright (c) 2007-2012 Darren Ethier. This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
//
//It goes without saying that this is a plugin for WordPress and I have no interest in developing it for other platforms so please, don't ask ;).

define('OS_ET_VERSION', '0.8.3.rc.000');
$plugin_path = plugin_dir_path(__FILE__);
require __DIR__ . '/vendor/autoload.php';

/**
 * This takes allows OS core to take care of the PHP version check
 * and also ensures we're only using the new style of bootstrapping if the verison of OS core with it is active.
 */
add_action('AHOS__bootstrapped', function() use ($plugin_path){
    require $plugin_path . 'bootstrap.php';
});

//fallback on loading legacy-includes.php in case the bootstrapped stuff isn't ready yet.
if (! defined('OS_ET_LEGACY_LOADED')) {
    require_once $plugin_path . 'legacy-includes.php';
}