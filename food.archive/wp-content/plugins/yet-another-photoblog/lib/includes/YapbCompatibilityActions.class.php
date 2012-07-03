<?php

	/**
	 * This class encapsulates all actions needed for 
	 * YAPB backwards-compatibility. If you update your
	 * plugin you don't want everying to be broken.
	 * 
	 * @author jjarolim <yapb@johannes.jarolim.com>
	 */

	class YapbCompatibilityActions {
		
		static function run() {
			self::yapb_1_10_5();
		}
		
		/**
		 * YAPB 1.10.5 
		 * 
		 * This release replaces some general automatic image insertion options
		 * with a much more finegrained concept. 
		 * 
		 * If the user has checked "Link thumbnails to actual post and open page"
		 * we migrate this setting to each section: home, single, archive and page
		 */
		static function yapb_1_10_5() {

			// Automatic Image Insertion / General / Link thumbnails to actual post
			
			if (get_option('yapb_display_images_linked_activate') == '1') {

				$sections = array('home', 'single', 'archive', 'page');
				foreach ($sections as $section) {
				
					add_option('yapb_display_images_' . $section . '_link_activate', '1'); // activate link in the current section
					add_option('yapb_display_images_' . $section . '_linktype', 'post'); // link to post
					
					// Set link target if applicable
					// Possible values pre 1.10.5:
					// 
					// # nA (without target)
					// # _self (in the same window)
					// # _blank (in a new window)
					
					if (get_option('yapb_display_images_linked') != 'nA') {
						add_option(
							'yapb_display_images_' . $section . '_target', 
							get_option('yapb_display_images_linked')
						);
					}
				
				}
				
			}
			
			// finally remove deprecated option

			delete_option('yapb_display_images_linked_activate'); 
			delete_option('yapb_display_images_linked');
			
		}
		
		
	}

?>
