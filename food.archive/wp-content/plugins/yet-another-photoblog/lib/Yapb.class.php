<?php

	/*  Copyright 2007 J.P.Jarolim (email : yapb@johannes.jarolim.com)

		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation; either version 2 of the License, or
		(at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	*/

	class Yapb {

		/**
		 * Current plugin version
		 * @var string
		 **/
		var $pluginVersion;

		/**
		 * Lowest required WordPress Version
		 * @var string
		 **/
		var $requiredWordPressVersion;

		/**
		 * Highest WordPress Version this plugin version was tested with
		 * @var string
		 **/
		var $highestTestedWordPressVersion;

		/**
		 * The templating engine instance
		 * @var Savant2
		 */
		var $tpl = null;
		
		/**
		 * @var string
		 */
		var $base_url = '';
		
		/**
		 * The directory separator of this os
		 * @var string
		 */
		var $separator;

		/**
		 * The array holding all configuration settings and defaults for YAPB
		 * This variable gets filled by the required includes/YapbOptions.php
		 * @var array
		 */
		var $options;

		/**
		 * An array holding all admin area notices to be shown
		 * @var array
		 **/
		var $notices;

		/**
		 * Constructor
		 */
		function Yapb() {
		
			global $wpdb;

			// First of all, let's read some version information

			$this->readVersionInformation();

			// Now, let's define some globally available variables

			require_once realpath(dirname(__FILE__) . '/includes/YapbConstants.script.php');
			
			// Let's check if we have a cache dir as defined in the YapbConstants.script.php

			$this->check_cache_directory();

			// I18N support through GNU-Gettext files

			load_plugin_textdomain('yapb', false, YAPB_PLUGINDIR_NAME . '/lang/');

			// Let's require some usefull stuff

			require_once realpath(dirname(__FILE__) . '/Params.class.php');
			require_once realpath(dirname(__FILE__) . '/YapbImage.class.php');
			require_once realpath(dirname(__FILE__) . '/YapbUtils.class.php');
			require_once realpath(dirname(__FILE__) . '/ExifUtils.class.php');
			require_once realpath(dirname(__FILE__) . '/YapbMaintainance.class.php');
			require_once realpath(dirname(__FILE__) . '/Savant2-2.4.3/Savant2.php');
			require_once realpath(dirname(__FILE__) . '/includes/YapbTemplateFunctions.php');

			// Load YAPB Options Domain

			require_once realpath(dirname(__file__) . '/options/YapbOptions.php');

			// Initialize the savant2 templating engine

			$this->tpl =& new Savant2();
			$this->tpl->addPath('template', YAPB_TPL_PATH);

			// WP Admin Panel / Dashboard 
			// WordPress 2.7 Dashboard Widget

			add_action('wp_dashboard_setup', array(&$this, '_on_wp_dashboard_setup'));

			// WP Admin Panel / Write

			add_filter('edit_form_advanced', array(&$this, '_filter_edit_form_advanced'));
			if (get_option('yapb_form_on_page_form')) {
				add_filter('edit_page_form', array(&$this, '_filter_edit_form_advanced'));
			}

			// WP Admin Panel / Write / Activity Hooks

			add_action('edit_post', array(&$this, '_on_edit_publish_save_post'));
			add_action('publish_post', array(&$this, '_on_edit_publish_save_post'));
			add_action('publish_post', array(&$this, '_on_publish_post'));
			add_action('save_post', array(&$this, '_on_edit_publish_save_post'));
			add_action('delete_post', array(&$this, '_on_delete_post'));
			
			// WP Admin Panel / Manage

			add_filter('manage_posts_columns', array(&$this, '_filter_manage_posts_columns'));
			add_action('manage_posts_custom_column', array(&$this, '_filter_manage_posts_custom_column'));
			add_filter('manage_pages_columns', array(&$this, '_filter_manage_pages_columns'));
			add_action('manage_pages_custom_column', array(&$this, '_filter_manage_pages_custom_column'));

			// WP-Loop

			add_filter('the_posts', array(&$this, '_filter_the_posts'));

			// Admin Panel / Settings / YAPB

			add_action('admin_head', array(&$this, '_on_admin_head'));
			add_action('admin_menu', array(&$this, '_on_admin_menu'));

			// Plugin Activation, Deactivation

			register_activation_hook(YAPB_PLUGINDIR_NAME . '/Yapb.php', array(&$this, '_on_activate_pluginurl'));
			register_deactivation_hook(YAPB_PLUGINDIR_NAME . '/Yapb.php', array(&$this, '_on_deactivate_pluginurl'));

			// Feeds & Automatic Image Insertion

			add_filter('wp_head', array(&$this, '_on_wp_head'));
			add_filter('the_content', array(&$this, '_filter_the_content'));

			add_action('rss2_head', array(&$this, '_on_rss2_head'));
			add_action('rss2_ns', array(&$this, '_on_rss2_ns'));
			add_action('rss2_item', array(&$this, '_on_rss2_item'));
			add_action('atom_entry', array(&$this, '_on_atom_entry'));

			// Admin Notices

			add_action('admin_notices', array(&$this, '_on_admin_notices'));

			// Facebook integration
			
			add_action('wp_head', array(&$this, '_on_wp_head_facebook'));

			// YAPB Plugin Integration Hook
			// We move the execution of this yapb hook to the end
			// of the plugin loading circle since i can't make sure
			// that yapb gets called after yapb plugins

			add_action('plugins_loaded', array(&$this, '_on_plugins_loaded'));
			
		}

		
		// YAPB post_thumbnail support
		

		function _filter_get_post_metadata($unusedparam, $object_id, $meta_key, $single) {
			return null;
		}
		
		/** 
		 * post-thumbnail-template.php hook get_post
		 * 
		 * @param type $html
		 * @param type $post_id
		 * @param type $post_thumbnail_id
		 * @param type $size
		 * @param type $attr
		 * @return type 
		 */		
		function _filter_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
			return $html;
		}
		
		
		

		/**
		 * YAPB Plugin Integration Hook
		 * This hook get's called after the basic initialization of YAPB:
		 * That assures that plugins can access all YAPB features and variables
		 **/
		function _on_plugins_loaded() {
			do_action('yapb_register_plugin', $this);
		}
		
		
		/**
		 * This method sets the plugins version information with the 
		 * values fetched from the readme.txt file in the plugins root directory
		 **/
		function readVersionInformation() {

			// Get the readme.txt file contents
			$readmeContent = file_get_contents(realpath(dirname(__FILE__) . '/../readme.txt'));
			
			// Since we don't want to execute regular expressions against the whole file, we extract the header part
			$readmeHeader = substr($readmeContent, 0, strpos($readmeContent, '== Description =='));
			
			// Extract the defined version numbers
			$this->pluginVersion = $this->_parseReadmeValue($readmeHeader, 'Stable tag');
			$this->requiredWordPressVersion = $this->_parseReadmeValue($readmeHeader, 'Requires at least');
			$this->highestTestedWordPressVersion = $this->_parseReadmeValue($readmeHeader, 'Tested up to');
		
		}

			/** 
			 * Function extracts a value from the readme header
			 *
			 * @param string $readmeHeader
			 * @param string $key
			 * @return string
			 **/
			function _parseReadmeValue($readmeHeader, $key) {
				preg_match('#' . $key . '\s*:\s*([0-9.]+)#i', $readmeHeader, $match);
				return $match[1];
			}

		/**
		 * POST.PHP
		 **/

		/**
		 * post.php hook _filter_edit_form_advanced
		 * This method enhances the wp new/edit-form
		 * to an upload form
		 **/
		function _filter_edit_form_advanced() {
			
			global $post;

			// Let's have a look if this post has an image attached
			// If yes: Assign the image to the template
			if (isset($post->ID)) {
				if (!is_null($image = YapbImage::getInstanceFromDb($post->ID))) {
					$this->tpl->assign('image', $image);
				}
			}

			$this->tpl->assign('content', $this->tpl->fetch('edit_form_advanced_field_fileupload.tpl.php'));
			$this->tpl->display('edit_form_advanced_javascript_injection.tpl.php');

		}

		/**
		 * This internal method returns if the given mime type gets
		 * accepted by YAPB upload
		 * @param string $type 
		 */
		function _isAllowedMimeType($type) {
			return in_array($type, array('image/jpeg', 'image/jpg', 'image/png', 'image/gif'));
		}

		/**
		 * This method hooks into the default upload workflow and intercepts 
		 * eventually existing file uploads
		 * 
		 * hook edit_post
		 * hook publish_post
		 * hook save_post
		 * @param number $post_id
		 **/
		function _on_edit_publish_save_post($post_id) {

			// Reflect WordPress 2.6+ post revisions: This hooks get called for
			// every post revision, autosave and finally for the actual post itself
			// We only want to attach this image to the final post
			//
			// Thanks to microkid analyzing this behaviour: 
			// http://wordpress.org/support/topic/189171?replies=8#post-808999

			// Simply more complex code so this plugin still works in WP 2.5+

			$executeAction = true;

			// Don't execute this action if it was called for a post revision
			// Function wp_is_post_revision was introduced in WP 2.6

			if (function_exists('wp_is_post_revision')) 
				$executeAction = $executeAction && !wp_is_post_revision($post_id);

			// Don't execute this action if it was called for an autosave
			// Function wp_is_post_autosave was introduced in WP 2.6

			if (function_exists('wp_is_post_autosave'))
				$executeAction = $executeAction && !wp_is_post_autosave($post_id);

			if ($executeAction) {

				global $wpdb;

				// if we have an yapb-imageupload here
				if (array_key_exists('yapb_imageupload', $_FILES)) {

					// wp_handle_upload: admin_functions.php
					$uploadedFileInfo = wp_handle_upload($_FILES['yapb_imageupload'], array('action' => $_POST['action']));

					# echo '<pre>'; print_r($uploadedFileInfo); echo '</pre>';

					// if we didn't have errors while upload
					if (!isset($uploadedFileInfo['error'])) {

						$url = $uploadedFileInfo['url'];
						$type = $uploadedFileInfo['type'];

						// We want to save the relative URI seen from the webhost-root of the image
						// We now have an url like 
						// http://my.server.tld/blog/wp-content/uploads/.../bla.jpg or
						// http://my.server.tld/wp-content/uploads/.../bla.jpg
						// We want to save instead: 
						// /blog/wp-content/uploads/.../bla.jpg or respectivly
						// /wp-content/uploads/.../bla.jpg

						$siteUrl = get_option('siteurl');
						if (substr($siteUrl, -1) != '/') $siteUrl .= '/';
						$uri = substr($url, strpos($siteUrl, '/', strpos($url, '//')+2));

						// Workaround for User-URL-Schemes with tilde:
						// We try to delete the tilde-part
						// If we get /~username/wp-content/bla we should
						// have /wp-content/bla afterwards

						if (strpos($uri, '~') !== false) {
							// We delete everything until the next slash
							$uri = substr($uri, strpos($uri, '/', strpos($uri, '~'))); 
						}

						if ($this->_isAllowedMimeType($type)) {

							// First we take a look if we already have an image attached to this post
							// In this case we delete it, because we replace images

							if ($post_id) {
								if (!is_null($image = YapbImage::getInstanceFromDb($post_id))) {
									$image->delete();
								}
							}

							$image = new YapbImage(null, $post_id, $uri);

							// We persist the image to the database

							$image->persist();

							// Hook requested by Joost
							// Since: 1.9.18

							do_action('yapb_image_upload', $image);

							// Since we want to learn from every single posted image
							// Use YapbImage for Exif-Extraction

							$yapbImage = new YapbImage($id, $post_id, $uri);
							$exifData = ExifUtils::getExifData($yapbImage, true);
							ExifUtils::learnTagnames($exifData);

							// If the user wants the postdate to be overwritten by the exif datetime stamp
							if (array_key_exists('exifdate', $_POST)) {

								if (!is_null($exifData)) {
									if (array_key_exists('DateTime', $exifData)) {

										// The exif date is formated this way: yyyy:mm:dd hh:mm:ss
										// strtotime needs it this way: yyyy-mm-dd hh:mm:ss
										// so we change that with a little regex since sprintf
										// isn't available on every platform

										$datetime = preg_replace('#([0-9]{4}):([0-9]{2}):([0-9]{2})#', '$1-$2-$3', $exifData['DateTime']);
										$date = strtotime($datetime);
										$dateGMT = $date - (get_option('gmt_offset') * 60 * 60);
										
										// we update the post if the datetime parsing was successful

										if ($date != -1) {

											// now we update post_date and post_date_gmt
											$wpdb->query('UPDATE ' . $wpdb->posts . ' set post_date = \'' . strftime('%Y-%m-%d %H:%M:%S', $date) . '\', post_date_gmt = \'' . strftime('%Y-%m-%d %H:%M:%S', $dateGMT) . '\' WHERE ID = ' . $post_id);

										}

									}
								}
								
							}

						} else {

							// This ain't an image - let's delete it right away
							unlink(realpath($uri));

						}

					} else {
						
						// Some error occured while uploading the file
						// TODO: Some kind of error message on the admin interface

						$this->add_notice(
							'<strong>Error while uploading image.</strong> ' . $uploadedFileInfo['error']
						);

					}

				}

				if (array_key_exists('yapb_remove_image', $_POST)) {
					if (!is_null($image = YapbImage::getInstanceFromDb($post_id))) {
						$image->delete();
					}
				}

			}

		}

		/**
		 * This hook reacts on a publish and pings all additionally 
		 * defined sites IF an image was attached
		 * @param number $post_id
		 */
		function _on_publish_post($post_id) {
			
			// Since we registered this action after edit_publish_save_post($post_id),
			// we should eventually have an image 
			if (!is_null($image = YapbImage::getInstanceFromDb($post_id))) {
				// If this is a photoblog post, we additionally ping all sites defined by the user
				$this->_generic_yapb_ping($post_id);
			}

		}

		/**
		 * hook delete_post (wp-admin/post.php)
		 * This method gets called every time we delete a post
		 * @param number $post_id
		 **/
		function _on_delete_post($post_id) {
			if (!is_null($image = YapbImage::getInstanceFromDb($post_id))) {
				$image->delete();
			}
		}

		/**
		 * EDIT.PHP
		 **/

		/**
		 * hook manage_posts_columns
		 * i want to insert another column after the date column
		 * since this is an associative array i've to rebuild it
		 * TODO: WP 2.7: Check for new version and insert again at the beginning
		 * @param array $post_columns
		 **/
		function _filter_manage_posts_columns($posts_columns) {
			$result = array();
			foreach ($posts_columns as $key => $value) {
				if ($key == 'title') {
					$result[$key] = $value;
					$result['thumb'] = __('Image', 'yapb');
				} else $result[$key] = $value;
			}
			return $result;
		}

		/**
		 * this filter acts on the previously inserted post column 'thumb'
		 * see method manage_posts_columns
		 * @param string $column_name
		 **/
		function _filter_manage_posts_custom_column($column_name) {
			if ($column_name == 'thumb') {
				global $post;
				if (!is_null($image = YapbImage::getInstanceFromDb($post->ID))) {
					$this->tpl->assign('image', $image);
				} else {
					$this->tpl->clear('image');
				}
				$this->tpl->display('manage_posts_custom_column.tpl.php');
			}
		}

		/**
		 * edit-pages.php
		 **/

		/**
		 * hook manage_pages_columns
		 * i want to insert another column after the date column
		 * since this is an associative array i've to rebuild it
		 * TODO: WP 2.7: Check for new version and insert again at the beginning
		 * @param array $post_columns
		 **/
		function _filter_manage_pages_columns($posts_columns) {
			$result = array();
			foreach ($posts_columns as $key => $value) {
				if ($key == 'title') {
					$result[$key] = $value;
					$result['thumb'] = __('Image', 'yapb');
				} else $result[$key] = $value;
			}
			return $result;
		}

		/**
		 * this filter acts on the previously inserted pages column 'thumb'
		 * see method manage_pages_columns
		 * @param string $column_name
		 **/
		function _filter_manage_pages_custom_column($column_name) {
			if ($column_name == 'thumb') {
				global $post;
				if (!is_null($image = YapbImage::getInstanceFromDb($post->ID))) {
					$this->tpl->assign('image', $image);
				} else {
					$this->tpl->clear('image');
				}
				$this->tpl->display('manage_posts_custom_column.tpl.php');
			}
		}

		//
		// The wordpress-loop
		// Goal: Insert an image-object into every post having attached one
		//

		/**
		 * filter for hook: the_posts
		 * We cycle through all posts, look for attached images
		 * and assign found images to the particular posts
		 * @param array $posts
		 */
		function _filter_the_posts($posts) {
			for ($i=0, $len=count($posts); $i<$len; $i++) {
				$post = &$posts[$i];
				if (!is_null($image = YapbImage::getInstanceFromDb($post->ID))) {
					$post->image = $image;
				}
			}
			return $posts;
		}

		function _on_admin_head() {
			if (array_key_exists('page', $_GET)) {
				if ($_GET['page'] == 'Yapb.class.php') {

					// We get the currently active accordion index

					$active = Params::get('accordionindex', '');
					$active = trim($active);
					if (empty($active)) $active = 'false';
					$this->tpl->assign('active', $active-1);
					$this->tpl->display('yapb_options_page_head.tpl.php');
					
				}
			}
		}

		/**
		 * Options page
		 * We insert an options page for yapb
		 **/
		function _on_admin_menu() {
			if (function_exists('add_options_page')) {
				add_options_page('YAPB', 'YAPB', 8, basename(__FILE__), array(&$this, 'render_options_panel_content'));
			}
		}

		/**
		 * This method renders the YAPB option panel - And reacts on
		 * the post requests from it
		 **/
		function render_options_panel_content() {

			// First of all some code reacting on form posts
			// This is meant as some kind of MVC controller part
			// as far as i can do that in this infrastructure

			$maintainance = new YapbMaintainance();

			$message = null;
			$action = Params::get('action', null);

			if (!empty($action)) {
			
				switch ($action) {
					
					// Update: All options should get updated

					case 'update': 
			
						$this->options->update();
						wp_cache_flush(); // We have to flush the cache to see the actual option values
						$this->add_notice(__('Options Updated.', 'yapb'));
						break;

					// Clear cache: All cached images will be deleted

					case 'clear_cache': 

						$maintainance->clearCache();
						$this->add_notice(__('Cache cleared', 'yapb'));
						break;
					
					// Clean up entry: Delete one entry from yapbimage db table
					
					case 'cleanup_entry':
						
						$post_id = Params::get('post_id', null);
						if (!is_null($post_id)) {
							$image = YapbImage::getInstanceFromDb($post_id);
							if (!is_null($image)) {
								$image->delete();
								$this->add_notice(__('Entry cleaned up', 'yapb'));
							}
						}
						break;

					// Retrain exif: We cycle through all previously posted images
					// look into their exif and rebuild the internal exif tags table

					case 'retrain_exif':

						global $wpdb;

						$rows = $wpdb->get_results('SELECT * FROM ' . YAPB_TABLE_NAME . ' ORDER BY id');
						foreach ($rows as $row) {
							$yapbImage = new YapbImage($row->id, $row->post_id, $row->URI); 
							$exifData = ExifUtils::getExifData($yapbImage, true);
							ExifUtils::learnTagnames($exifData);
						}
						
						$this->add_notice(__('Exif Tags retrained', 'yapb'));
						break;

				}

			}	

			// $this->tpl->assign('message', $message);
			$this->tpl->assign('options', $this->options);
			$this->tpl->assign('yapbVersion', $this->pluginVersion);
			$this->tpl->assign('maintainance', $maintainance);
			$this->tpl->display('yapb_options_page.tpl.php');

		}

		//
		// Installation/Activation
		//

		/**
		 * Action for hook: activate_pluginurl
		 */
		function _on_activate_pluginurl() {

			// Create YAPB Table if not existant

			global $wpdb;

			if($wpdb->get_var('show tables like "' . YAPB_TABLE_NAME . '"') != YAPB_TABLE_NAME) {

				$sql = 'CREATE TABLE ' . YAPB_TABLE_NAME . ' ( ' .
					'id BIGINT NOT NULL AUTO_INCREMENT, ' .
					'post_id BIGINT NOT NULL, ' .
					'URI VARCHAR(255) NOT NULL, ' .
					'PRIMARY KEY (id), ' .
					'INDEX idx_01(post_id) ' .
				');';

				require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
				dbDelta($sql);

			}

			// Initialize YAPB Options

			$this->options->initialize();
			
			// Backwards compatibility actions
			
			require_once realpath(dirname(__FILE__) . '/includes/YapbCompatibilityActions.class.php');
			YapbCompatibilityActions::run();

		}

		/**
		 * This hook gets called on deactivation of YAPB
		 */
		function _on_deactivate_pluginurl() {
			
			// Reviewed 08.02.2007: 
			// Don't think it's neccessary but i'll leave this 
			// code fragment in the class so i have it if i need it...
			// Hey: I'm over 30 and tend to forget hook names from time to time ;-)
			
		}

		/**
		 * This method inserts a simple css in the blogs header that
		 * hides the link border in auto image insertion mode
		 * TODO: Make that style available in the admin interface
		 **/
		function _on_wp_head() {

			// If automatic image insertion is activated in general

			if (get_option('yapb_display_images_activate')) {
				echo '
					<!-- YAPB Automatic Image Insertion -->
					<style type="text/css">
						/** Hide border around linked thumbnails the validation-aware way **/
						.yapb-image-link .yapb_thumbnail {
							border:none;
						}
					</style>
					<!-- /YAPB Automatic Image Insertion -->
				';
			}

		}
		
		/**
		 * YAPB Facebook integration
		 * As a WordPress convention, this hook should be called in every 
		 * theme just before the closing </head> tag by inserting the
		 * <?php wp_head(); ?> directive.
		 * 
		 * @see http://www.insidefacebook.com/2009/04/06/increase-your-sites-traffic-through-facebook-share/
		 * @see http://www.google.at/search?q=rel%3D"image_src"
		 */
		function _on_wp_head_facebook() {
			
			if (is_single() || is_page()) {
				if (get_option('yapb_facebook_activate')) {
					
					echo '<!-- YAPB Facebook integration -->'."\n";
					
					global $post;
					if (!is_null($image = YapbImage::getInstanceFromDb($post->ID))) {
						
						// The user wants the YAPB image embedded as facebook post-thumbnail
						if (get_option('yapb_facebook_meta_postthumb_activate')) {
							
							// Problem: Facebook wants an URL of a real image and not 
							// the URL of the YapbThumbnailer. So we do the thumbnailing
							// on our self and present the link to the cached image
							// instead
							
							$thumbnail_conf = array('w=100', 'h=100');
							$thumbnail_href = $image->getThumbnailHref($thumbnail_conf, 1);
							
							if (strpos($thumbnail_href, 'YapbThumbnailer') !== false) {
								$temp = file_get_contents($thumbnail_href);
								$thumbnail_href = $image->getThumbnailHref($thumbnail_conf, 1);
							} 

							echo '<link rel="image_src" href="' . $thumbnail_href . '" />' . "\n";
							
							
						}
						
						// The user wants to declare the media type as medium=image
						if (get_option('yapb_facebook_meta_mediaimage_activate')) {
							
							echo '<meta name="medium" content="image" />'."\n";
							
						}
						
					}
					
					echo '<!-- /YAPB Facebook integration -->'."\n";
					
				}
			}
			
		}
		

		/** 
		 * This method enhances the various feeds for an image tag if available
		 * 
		 * @param string $content the content of the post
		 **/ 
		function _filter_the_content($content) {
			
			global $post;
			$result = $content;
			
			// We only have to alter the content if we have an image
			if (property_exists($post, 'image')) {
			
				// Was this hook called out of a feed generation?
				if (is_feed()) {

					// Does the user want to display images in feeds?
					if (get_option('yapb_display_images_xml')) {
						
						// Please notice: WordPress feeds embed content in CDATA fields
						// So i definitly don't want to use xhtml in these content fields
						// Example: VFXY.com doesn't like &amp; in these URL's

						// Build the image tag
						
						$embed = get_option('yapb_display_images_xml_html_before') . '<img src="';
						
						if (get_option('yapb_display_images_xml_thumbnail_activate')) {

							// phpThumb thumbnailing options

							$options = array();

							$maxWidth = get_option('yapb_display_images_xml_thumbnail');
							$maxHeight = get_option('yapb_display_images_xml_thumbnail_height');
							$crop = get_option('yapb_display_images_xml_thumbnail_crop');

							if (!empty($maxWidth)) $options[] = 'w=' . $maxWidth;
							if (!empty($maxHeight)) $options[] = 'h=' . $maxHeight;
							if (!empty($crop)) $options[] = 'zc=1';

							$embed .= 
								$post->image->getThumbnailHref(
									$options, 
									false // I manually override the users xhtml setting for WordPress feeds: Have a look at the description above
								);
							
							$embed .= '" ';

							$imageWidth = $post->image->getThumbnailWidth($options);
							$imageHeight = $post->image->getThumbnailHeight($options);

						} else {
							
							$embed .= $post->image->getFullHref() . '" ';
							$imageWidth = $post->image->width;
							$imageHeight = $post->image->height; 

						}
						
						$embed .= 'width="' . $imageWidth . '" ';
						$embed .= 'height="' . $imageHeight . '" ';
						$embed .= 'alt="' . get_the_title() . '" ';
						
						$style = get_option('yapb_display_images_xml_inline_style');
						if ((!is_null($style)) && ($style != '')) {
							$embed .= 'style="' . $style . '" ';
						}
						$embed .= (get_option('yapb_display_images_xml_xhtml') ? '/>' : '>') . get_option('yapb_display_images_xml_html_after');
						
						// Surround the image tag with a link
						// Thanks to fsimo for the idea

						$embed = '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . $embed . '</a>';

						// Directly print out the image tag into 
						// the feed

						print $embed;
						
					}
					
				} else
				
				// If automatic image insertion is activated in general

				if (get_option('yapb_display_images_activate')) {
					print $this->_getImageTag($post->image);
				}
				
			} 
			
			return $result;
			
		}

			/**
			 * Internal method prints an image tag eventually surrounded
			 * by some html at the beginning of a posts content part
			 * 
			 * @param YapbImage $image
			 * @return string the complete image tag
			 */
			function _getImageTag($image) {
				
				global $post;
				
				$result = '<!-- no image -->';
				
				// Accepted areas of the blog
				
				$areas = array(
					array('home', is_home()),			// homepage
					array('single', is_single()),		// single page
					array('archive', is_archive()),		// archive page
					array('page', is_page())			// page
				);

				// get image tag according to the current areas setting
				
				foreach ($areas as $area) {

					$hrefBeforeImage = '';
					$hrefAfterImage = '';
					
					// If automatic image insertion is activated for this area
					if (get_option('yapb_display_images_' . $area[0]) && $area[1]) {
						
						// Does the user wants straight xhtml-href's?
						
						$xhtml = get_option('yapb_display_images_xhtml');
						
						// Thumbnails may be linked to the actual post or image
						
						if (get_option('yapb_display_images_' . $area[0] . '_link_activate')) {

							// Link href

							$link_href = 'javascript:;';
							if (get_option('yapb_display_images_' . $area[0] . '_linktype') == 'post') {
								$link_href = get_permalink();
							}

							if (get_option('yapb_display_images_' . $area[0] . '_linktype') == 'image') {
								
								$link_href = $image->uri;
								
								// Does the user want to link to a thumbnail?
								
								if (get_option('yapb_display_images_' . $area[0] . '_linktype_image_thumbnail_activate')) {
									$options = array('w=' . get_option('yapb_display_images_' . $area[0] . '_linktype_image_thumbnail'));
									$link_href = $image->getThumbnailHref($options);
								}
								
							}

							// Link target

							$link_target = '';
							if (get_option('yapb_display_images_' . $area[0] . '_target_activate')) {
								$link_target = 'target="' . get_option('yapb_display_images_' . $area[0] . '_target') . '" ';
							}
							
							// Link rel attribute
							
							$link_rel = '';
							if (get_option('yapb_display_images_' . $area[0] . '_linktype_image_rel_activate')) {
								$link_rel = 'rel="' . get_option('yapb_display_images_' . $area[0] . '_linktype_image_rel') . '" ';
							}
							
							$hrefBeforeImage = '<a href="' . $link_href . '" ' . $link_target . $link_rel . '>';
							$hrefAfterImage = '</a>';

						}
						
						// Displayed image size
						
						$imageURI = $image->uri;
						$imageWidth = $image->width;
						$imageHeight = $image->height;
						
						if (get_option('yapb_display_images_' . $area[0] . '_thumbnail_activate')) {

							$options = array('w=' . get_option('yapb_display_images_' . $area[0] . '_thumbnail'));
							$imageURI = $image->getThumbnailHref($options);
							$imageWidth = $image->getThumbnailWidth($options);
							$imageHeight = $image->getThumbnailHeight($options);

						}
						
						// Did the user define an inline style definition?
						
						$style = get_option('yapb_display_images_' . $area[0] . '_inline_style');
						if (!empty($style)) {
							$style = ' style="' . $style . '"';
						}
						
						$result = '<!-- YAPB Automatic Image Insertion -->';
						$result .= get_option('yapb_display_images_' . $area[0] . '_html_before');
						$result .= $hrefBeforeImage;
						$result .= '<img class="yapb-image"' . $style . ' width="' . $imageWidth . '" height="' . $imageHeight . '" src="' . $imageURI . '" title="' . $post->post_title . '" alt="' . $post->post_title . '"' . ($xhtml ? ' />' : '>');
						$result .= $hrefAfterImage;
						$result .= get_option('yapb_display_images_' . $area[0] . '_html_after');
						$result .= '<!-- /YAPB Automatic Image Insertion -->';
						
					}
					
				}

				return $result;

			}

		/**
		 * This method enhances WP RSS2 feeds with paging
		 **/
		function _on_rss2_head() {

			// First of all: For paging we have to know how many posts are there at all?

			global $wpdb;

			$post_count = (int)$wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->posts);

			$posts_per_page = get_option('posts_per_rss');
			$page_count = ceil($post_count / (int)get_option('posts_per_rss'));

			$page_index = 1; if (array_key_exists('page', $_GET)) $page_index = (int)$_GET['page'];
			$page_index_next = ($page_index < $page_count) ? $page_index+1 : null;
			$page_index_previous = ($page_index > 1) ? $page_index-1 : null;

			/** Code copied from WP feed.php **/

			$host = @parse_url(get_option('home'));
			$host = $host['host'];
			$self_link = clean_url(
				'http'
				. ( (isset($_SERVER['https']) && $_SERVER['https'] == 'on') ? 's' : '' ) . '://'
				. $host
				. stripslashes($_SERVER['REQUEST_URI'])
			);

			// If we have a previous page

			if (!empty($page_index_previous)) {

				$link = $self_link;
				if (strpos($link, 'page=') === false) $link = $link . ((strpos($link, '?') === false) ? '?' : '&amp;') . 'page=' . $page_index_previous;
				else $link = preg_replace('#page=[0-9]+#', 'page=' . $page_index_previous, $link); 

				echo "\n\t".'<atom:link rel="previous" href="' . $link . '" />' . "\n";

			}

			// If we have a next page

			if (!empty($page_index_next)) {

				$link = $self_link;

				if (strpos($link, 'page=') === false) $link = $link . ((strpos($link, '?') === false) ? '?' : '&amp;') . 'page=' . $page_index_next;
				else $link = preg_replace('#page=[0-9]+#', 'page=' . $page_index_next, $link); 
				echo "\t".'<atom:link rel="next" href="' . $link . '" />' . "\n\n";

			}

			// Finally: If an page was requested, we have to alter the loop

			if (array_key_exists('page', $_GET)) {
				query_posts('showposts=' . get_option('posts_per_rss') . '&offset=' . (($page_index-1) * $posts_per_page) . '&orderby=date'); 
			}

		}

		/**
		 * This method inserts the yahoo media rss namespace into the rss2 opening tag
		 **/
		function _on_rss2_ns() {

			// The namespace for the yahoo media rss specification

			if (get_option('yapb_yahoo_media_rss_activate')) {
				echo 'xmlns:media="http://search.yahoo.com/mrss/"';
			}

		}

		/**
		 * This method inserts additions to the rss2 items like
		 * - rss enclosures
		 * - yahoo media rss additions
		 **/
		function _on_rss2_item() {

			global $post;

			if (!is_null($image = YapbImage::getInstanceFromDb($post->ID))) {

				// RSS enclosure

				if (get_option('yapb_display_images_xml_media_enclosure')) {
					if (get_option('yapb_display_images_xml_media_enclosure_resized_activate')) {

						// Link resized image

						$options = array();

						$width = get_option('yapb_display_images_xml_media_enclosure_resized_width');
						$height = get_option('yapb_display_images_xml_media_enclosure_resized_height');
						$crop = get_option('yapb_display_images_xml_media_enclosure_resized_crop');

						if (!empty($width)) $options[] = 'w=' . $width;
						if (!empty($height)) $options[] = 'h=' . $height;
						if (!empty($crop)) $options[] = 'zc=1';

						echo '<enclosure url="' . $image->getThumbnailHref($options) . '" ';

						// We have to look if the thumbnail file already exists

						if (file_exists($image->_getUniqueThumbnailPath($options))) {

							// Yes: We already have an thumbnail: we may provide the size to the enclosure tag
							echo 'length="' . filesize($image->_getUniqueThumbnailPath($options)) . '" ';

						}

						echo 'type="' . $image->getMimeTypeForThumbnail() . '" />' . "\n";

					} else {

						// Link full size image
						echo '<enclosure url="' . $image->getFullHref() . '" length="' . filesize($image->systemFilePath()) . '" type="' . $image->getMimeType() . '" />' . "\n";

					}
				}

				// Yahoo Media RSS Specification

				if (get_option('yapb_yahoo_media_rss_activate')) {
					if (get_option('yapb_yahoo_media_rss_resized_activate')) {

						// Link resized image

						$options = array();

						$width = get_option('yapb_yahoo_media_rss_resized_width');
						$height = get_option('yapb_yahoo_media_rss_resized_height');
						$crop = get_option('yapb_yahoo_media_rss_resized_crop');

						if (!empty($width)) { $options[] = 'w=' . $width; }
						if (!empty($height)) { $options[] = 'h=' . $height; }
						if (!empty($crop)) { $options[] = 'zc=1'; }

						echo '<media:content url="' . $image->getThumbnailHref($options) . '" ';

						// We have to look if the thumbnail file already exists

						if (file_exists($image->_getUniqueThumbnailPath($options))) {

							// Yes: We already have an thumbnail: we may provide the size to the enclosure tag
							echo 'fileSize="' . filesize($image->_getUniqueThumbnailPath($options)) . '" ';

						}

						echo 'type="' . $image->getMimeTypeForThumbnail() . '" ';
						echo 'medium="image" ';
						echo 'width="' . $image->getThumbnailWidth($options) . '" ';
						echo 'height="' . $image->getThumbnailHeight($options) . '" ';
						echo ' />' . "\n";

					} else {

						// Linked fullsize image

						echo '<media:content url="' . $image->getFullHref() . '" ';
						echo 'fileSize="' . filesize($image->systemFilePath()) . '" ';
						echo 'type="' . $image->getMimeType() . '" ';
						echo 'medium="image" ';
						echo 'width="' . $image->width . '" ';
						echo 'height="' . $image->height . '" ';
						echo '/>' . "\n";

					}

					echo '<media:title type="plain"><![CDATA[' . get_the_title() . ']]></media:title>' . "\n";

					// Include the media:thumbnail?

					if (get_option('yapb_yahoo_media_rss_thumbnail_activate')) {

						$options = array();

						$width = get_option('yapb_yahoo_media_rss_thumbnail_width');
						$height = get_option('yapb_yahoo_media_rss_thumbnail_height');
						$crop = get_option('yapb_yahoo_media_rss_thumbnail_crop');

						if (!empty($width)) { $options[] = 'w=' . $width; }
						if (!empty($height)) { $options[] = 'h=' . $height; }
						if (!empty($crop)) { $options[] = 'zc=1'; }

						echo '<media:thumbnail url="' . $image->getThumbnailHref($options) . '" width="' . $image->getThumbnailWidth($options) . '" height="' . $image->getThumbnailHeight($options) . '" />' . "\n";

					}

					// echo '</media:content>' . "\n";

				}

			}

		}

		/**
		 * This method inserts the atom enclosure
		 **/
		function _on_atom_entry() {

			global $post;

			// Atom enclosure

			if (get_option('yapb_display_images_xml_media_enclosure')) {
				if (!is_null($image = YapbImage::getInstanceFromDb($post->ID))) {
					echo '<link rel="enclosure" type="' . $image->getMimeType() . '" length="' . filesize($image->systemFilePath()) . '" href="' . $image->getFullHref() . '"/>';
				}
			}

		}


		/**
		 * This method additionally pings all sites provided by the user if he
		 * publishes a photoblog article.
		 * It's a 1:1 copy of the wp-function found in wp-includes/functions.php
		 * The only modification: it uses the option yapb_ping_sites instead of 
		 * ping_sites defined in options/write
		 * 
		 * @param number $post_id
		 **/
		function _generic_yapb_ping($post_id = 0) {
			$services = get_option('yapb_ping_sites');
			$services = preg_replace("|(\s)+|", '$1', $services); // Kill dupe lines
			$services = trim($services);
			if ( '' != $services ) {
				$services = explode("\n", $services);
				foreach ($services as $service) {
					weblog_ping($service);
				}
			}
			return $post_id;
		}

		/**
		 * This method is a small adaption of the function wp_dropdown_cats(...) 
		 * to be found in /wp-admin/admin-functions.php
		 * 
		 * 
		 * @param number $currentcat
		 * @param number $currentparent
		 * @param number $parent
		 * @param number $level
		 * @param array $caegories
		 */
		function _options_categories_array($currentcat = 0, $currentparent = 0, $parent = 0, $level = 0, $categories = 0) {

			// BUG WORKAROUND START
			
			// Plugin User-Access-Manager:
			// This Plugin has some minor timing issues and calls functions
			// from pluggable.php without checking for existance in scope
			// rendering WP useless by throwing errors
			
			if (!function_exists('get_userdata')) {
				require_once(ABSPATH . 'wp-includes/pluggable.php');
			}
			
			// BUG WORKAROUND END
			
			global $wpdb;
			$result = array();

			if (!$categories) {
				$categories = get_categories('hide_empty=0');
			}

			if ($categories) {
				foreach ($categories as $category) {
					if ($currentcat != $category->term_id && $parent == $category->parent) {
						$pad = str_repeat('- ', $level);
						$category->name = esc_attr($category->name);
						$result[$pad . $category->name] = $category->term_id;
						$result = $result + $this->_options_categories_array($currentcat, $currentparent, $category->term_id, $level+1, $categories);
					}
				}
			}

			return $result;

		}

		/**
		 * hook admin_notices
		 * This method outputs previously set admin interface notices
		 **/
		function _on_admin_notices() {
			if (!empty($this->notices)) {
				echo '<div id="yapb-notice" class="updated fade">';
				if (count($this->notices) > 1) {
					foreach ($this->notices as $notice) {
						echo '<p>' . $notice . '</p>';
					}
				} else {
					echo '<p>' . $this->notices[0] . '</p>';
				}
				echo '</div>';
			}
		}

		/**
		 * This message may be used to set an admin area notice
		 * @param string $message 
		 **/
		function add_notice($notice) {
			if (!is_array($this->notices)) {
				$this->notices = array();
			}
			$this->notices[] = $notice;
		}

		// WP 2.7 Dashboard Widget

		function _on_wp_dashboard_setup() {
			if (function_exists('wp_add_dashboard_widget')) {
				wp_add_dashboard_widget(
					'yapb_dash', // HTML ID
					'Yet Another Photoblog', // title
					array(&$this, 'draw_dashboard_widget')
				);
			}
		}

		function draw_dashboard_widget() {

			// The YapbMaintainance Instance gives the
			// infrastructure for a short statistically info
			// on the Dashboard Widget

			require_once realpath(dirname(__file__) . '/YapbMaintainance.class.php');

			// Assign all data to the template and display it

			$this->tpl->assign('yapbMaintainanceInstance', new YapbMaintainance());
			$this->tpl->assign('pluginVersion', $this->pluginVersion);
			$this->tpl->assign('category', get_option('yapb_default_post_category'));
			$this->tpl->assign('numberposts', '10');
			$this->tpl->display('dashboard_activity_div.tpl.php');

		}

		/**
		 * This method looks out for the defined cache dir and
		 * tries to create it if not present.
		 **/
		function check_cache_directory() {

			if (is_dir(YAPB_CACHE_ROOT_DIR_PARENT)) {

				if (is_dir(YAPB_CACHE_ROOT_DIR)) {

					if (!is_writable(YAPB_CACHE_ROOT_DIR)) {

						$this->add_notice(sprintf(__('<strong>YAPB Cache dir not writeable.</strong><br/> Please make sure that %s is writeable.', 'yapb'), YAPB_CACHE_ROOT_DIR));

					}

				} else {

					// No YAPB cache dir
					// We try to create it
					
					$success = @mkdir(YAPB_CACHE_ROOT_DIR, 0777);

					if ($success) {

						// Success notice on the admin backend
						$this->add_notice(sprintf(__('<strong>YAPB thumbnail cache directory created</strong><br/>YAPB successfully created the directory %s for the internal thumbnail cache.', 'yapb'), YAPB_CACHE_ROOT_DIR));

						if (!is_writeable(YAPB_CACHE_ROOT_DIR)) {
							$this->add_notice(sprintf(__('<strong>Could not set sufficient directory permission</strong><br/> Please make sure that the directory %s is writeable.', 'yapb'), YAPB_CACHE_ROOT_DIR));
						}

					} else {

						// Warning notice on the admin backend
						$this->add_notice(sprintf(__('<strong>Could not create YAPB Cache directory automatically.</strong><br/>Please create %s manually. Don\'t forget to set the according directory permissions to 777 or 775.', 'yapb'), YAPB_CACHE_ROOT_DIR));

					}

				}

			} else {

				$this->add_notice(sprintf(__('<strong>Configured WordPress upload directory doesn\'t exist</strong><br/> Please make sure that the directory %s exists and is writeable.', 'yapb'), YAPB_CACHE_ROOT_DIR_PARENT));

			}

		}

	}

?>