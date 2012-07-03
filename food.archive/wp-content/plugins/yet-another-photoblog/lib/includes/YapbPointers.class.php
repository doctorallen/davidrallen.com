<?php

	/**
	 * This class holds the informational pointers that show 
	 * new features for the current version of YAPB
	 * Since this feature wasn't exposed to the public yet,
	 * this file is just a preparation for things to come.
	 * 
	 * @author jjarolim <yapb@johannes.jarolim.com>
	 */

	class YapbPointers {
		
		public static function pointer_1_10_5_image_linking() {
			
			$content  = '<h3>' . __('New Feature: Individual image linking', 'yapb') . '</h3>';
			$content .= '<p>' .  __('You now have exact control over image links on all sections using automatic image insertion', 'yapb') . '</p>';

			WP_Internal_Pointers::print_js(
				'yapb_1_10_5_image_linking', 
				'.basic-accordion-link-4', 
				array(
					'content'  => $content,
					'position' => array('edge' => 'top', 'align' => 'center'),
				) 
			);
		}
		
		public static function pointer_1_10_4_social_media() {
			
			$content  = '<h3>' . __('New Feature: Social media integration', 'yapb') . '</h3>';
			$content .= '<p>' .  __('YAPB now offers some social media integration features: just have a look.', 'yapb') . '</p>';

			WP_Internal_Pointers::print_js(
				'yapb_1_10_5_image_linking', 
				'.basic-accordion-link-3', 
				array(
					'content'  => $content,
					'position' => array('edge' => 'top', 'align' => 'center'),
				) 
			);
		}
		
		
	}


?>
