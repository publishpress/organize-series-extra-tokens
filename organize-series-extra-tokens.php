<?php
/*
Plugin Name: Organize Series Addon - Extra Tokens
Description: This addon for the Organize Series plugin provides Extra %tokens% for customizing the auto-inserted output of series related information.
Version: 0.7
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

//ALWAYS CHECK TO MAKE SURE ORGANIZE SERIES IS RUNNING FIRST //
add_action('plugins_loaded', 'orgseries_extra_tokens_check');

if ( file_exists(WP_PLUGIN_DIR . '/organize-series/inc/pue-client.php') ) {
	//let's get the client api key for updates
	$series_settings = get_option('org_series_options');
	$api_key = $series_settings['orgseries_api'];
	$host_server_url = 'http://organizeseries.com';
	$plugin_slug = 'organize-series-extra-tokens';
	$options = array(
		'apikey' => $api_key,
		'lang_domain' => 'organize-series'
	);
	
	require( WP_PLUGIN_DIR . '/organize-series/inc/pue-client.php' );
	$check_for_updates = new PluginUpdateEngineChecker($host_server_url, $plugin_slug, $options);
}

//* ALL HOOKS AND FILTERS HERE */

//all inits
add_action('init', 'orgseries_extra_tokens_register_textdomain');

add_filter('post_orgseries_token_replace', 'orgseries_extra_tokens',10,5);
add_action('orgseries_token_description', 'orgseries_extra_tokens_description');
//A hook for adding new template field to Series Options page
add_action('plist_ptitle_template_unpublished', 'orgseries_extra_unpub_tfield');

function orgseries_extra_tokens_check() {
	if ( !class_exists('orgSeries') ) {
		add_action('admin_notices', 'orgseries_extra_tokens_warning');
		add_action('admin_notices', 'orgseries_extra_tokens_deactivate');
	}
}

function orgseries_extra_tokens_warning() {
	if ( !class_exists('orgSeries') ) $pluginmsg = __('Organize Series', 'organize-series-extra-tokens');
	
	$msg = '<div id="wpp-message" class="error fade"><p>'.sprintf(__('The <strong>"Organize Series Extra Tokens"</strong> addon for Organize Series requires the %s plugin to be installed and activated in order to work.  This addon won\'t activate until this condition is met.', 'organize-series-extra-tokens'), $pluginmsg).'</p></div>';
	echo $msg;
}

function orgseries_extra_tokens_deactivate() {
	deactivate_plugins('organize-series-extra-tokens/organize-series-extra-tokens.php', true);
}

function orgseries_extra_tokens_register_textdomain() {
	$dir = basename(dirname(__FILE__)).'/lang';
	load_plugin_textdomain('organize-series-extra-tokens', false, $dir);
}

function orgseries_extra_tokens($replace, $referral, $id, $p_id,  $ser_ID) {
	if ( is_array($ser_ID) ) $ser_ID = $ser_ID[0];
	if( stristr($replace, '%series_slug%') ) 
		$replace = str_replace('%series_slug%', get_series_name($ser_ID, true), $replace);
	if( stristr($replace, '%series_id%') ) 
		$replace = str_replace('%series_id%', $ser_ID, $replace);
	if( stristr($replace, '%post_author%') )
		$replace = str_replace('%post_author%', token_extra_author($p_id), $replace);
	if( stristr($replace, '%post_thumbnail%') )
		$replace = str_replace('%post_thumbnail%', token_get_thumbnail($p_id), $replace);
	if( stristr($replace, '%post_date%') )
		$replace = str_replace('%post_date%', token_post_date($id), $replace);
	if( stristr($replace, '%post_title_list_with_unpub%') ) 
		$replace = str_replace('%post_title_list_with_unpub%', series_unpub_post_title($id), $replace);
	if( stristr($replace, '%total_posts_in_series_with_unpub%') ) 
		$replace = str_replace('%total_posts_in_series_with_unpub%', wp_unpublished_postlist_count($ser_ID), $replace);
	return $replace;
}

function orgseries_extra_tokens_description() {
	?>
	<br /><br />
					
	<strong>%series_slug%</strong><br />
		<em><?php _e('Will display the slug for the series', 'organize-series-extra-tokens'); ?></em><br /><br />
		
	<strong>%series_id%</strong><br />
	<em><?php _e('Will display the series id of the series', 'organize-series-extra-tokens'); ?></em><br /><br />
	
	<strong>%post_author%</strong><br />
	<em><?php _e('Will display the post author of the post in the series', 'organize-series-extra-tokens'); ?></em><br /><br />
	
	<strong>%post_thumbnail%</strong><br />
	<em><?php _e('Will display the post thumbnail of a post belonging to the series', 'organize-series-extra-tokens'); ?></em><br /><br />
	
	<strong>%post_date%</strong><br />
	<em><?php _e('Will display the published date of a post within a series', 'organize-series-extra-tokens'); ?></em><br /><br />
	
	<strong>%post_title_list_with_unpub%</strong><br />
	<em><?php _e('The location token for where the contents of the post list (including unpublished posts) post templates will appear.', 'organize-series'); ?></em><br /><br />
	
	<strong>%total_posts_in_series_with_unpub%</strong><br />
	<em><?php _e('Will display the total number of published and unpublished posts in a series', 'organize-series'); ?></em><br /><br />
	<?php
}

function token_extra_author($p_id) {
	$postdata = get_post($p_id);
	$author_id = $postdata->post_author;
	$authorname = get_the_author_meta('nickname', $author_id);
	return $authorname;
}

function token_get_thumbnail($p_id) {
	$thumbnail = get_the_post_thumbnail($p_id);
	return $thumbnail;
}

function token_post_date($p_id) {
	$post_date = get_the_date($p_id);
	return $post_date;
}

function orgseries_extra_unpub_tfield() {
	global $orgseries;
	$org_opt = $orgseries->settings;
	$org_name = 'org_series_options';
	?>
		<strong><?php _e('Series Post List Post Title (unpublished) Template:', 'organize-series'); ?></strong><br />
		<small><?php _e('Use this to indicate what html tags will surround the unpublished post title in the series post list.', 'organize-series'); ?></small><br />
		<textarea name="<?php echo $org_name; ?>[series_post_list_unpublished_post_template]" id="series_post_list_unpublished_post_template" rows="4" class="template"><?php echo htmlspecialchars($org_opt['series_post_list_unpublished_post_template']); ?></textarea><br />
		<br />
	<?php
}

function series_unpub_post_title($post_ID) {
	global $post;
	if (!isset($post_ID))
		$post_ID = (int)$post->ID;
	$title = get_the_title($post_ID);
	$return = $title.' ('.get_post_status($post_ID).')';
	return $return;
}

function wp_unpublished_postlist_count($ser_id) {
	$series = get_objects_in_term($ser_id, 'series');
	if (!empty($series)) {
		$postlist_count = count($series);
	} else {
		$postlist_count = 0;
	}
	return $postlist_count;
}
?>