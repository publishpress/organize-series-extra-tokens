=== Organize Series Addon - Extra Tokens ===
Contributors: nerrad
Tags: series, extra tokens
Requires at least: 3.7
Tested up to: 4.8
Stable tag: 0.8.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This addon for the Organize Series plugin provides Extra %tokens% for customizing the auto-inserted output of series related information.

== Description ==
There are five new tokens in the initial release (more will be added as requests come in)
 - %series_slug% - which will output the slug of the series.
 - %series_id% - which will output the id of the series.
 - %post_author% - will output the author of the post.
 - %post_thumbnail% - if the post has a feature-image then that image will be displayed.
 - %post_date% - the date that a post was published
This gives the user of Organize Series many new options for further customization of various displays of series information.  For example, if you wanted to show the feature images of each post in a series post list you could use the %post_thumbnail% token to include it.

== Installation ==
This add-on requires Organize Series Core to be installed and active.

1. MAKE SURE YOU BACKUP YOUR WORDPRESS DATABASE (that\'s all in caps for a reason - nothing *should* go wrong but it\'s a good precaution nevertheless!!)
1. Download the File (or use the built-in updater provided by WordPress)
1. Extract to a folder in `../wp-content/plugins/`. The add-on folder can be named whatever you want but the default is \"organize-series-extra-tokens\".  The final structure would be something like this: `../wp-content/plugins/organize-series-extra-tokens/--and all the plugin files/folders--`
1. Activate the plugin on your WordPress plugins page.

You can do the above or just use the new plugin install integrated in WordPress.

== Changelog ==
All change-log information for the plugin can be found at https://organizeseries.com/changelogs