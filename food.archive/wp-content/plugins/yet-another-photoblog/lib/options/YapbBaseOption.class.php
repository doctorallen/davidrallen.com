<?php

	/**
	 * Base Class for all option classes
	 **/

	if (!class_exists('YapbBaseOption')) {

		class YapbBaseOption {

			/**
			 * I don't believe it: The WP function "update_option" doesn't allow HTML
			 * since it calls $wpdb->escape before updating an option
			 * the code there preslashes all single quotes, double quotes and NUL bytes 
			 * thus destroying html - now i've to replicate that function - 
			 * what a bloody workaround
			 *
			 * @param string $option_name
			 * @param everything $newvalue
			 **/
			function update_html_option($option_name, $newvalue) {

				global $wpdb;

				if (is_string($newvalue)) {
					$newvalue = trim($newvalue);
				}

				// If the new and old values are the same, no need to update.
				$oldvalue = get_option($option_name);
				if ($newvalue == trim($oldvalue)) {
					return false;
				}

				if (false === $oldvalue) {
					add_option($option_name, $newvalue);
					return true;
				}

				if (is_array($newvalue) || is_object($newvalue)) {
					$newvalue = serialize($newvalue);
				}

				// Somehow i get $_GET parameters preslashed by WordPress
				// I need HTML doublequotes inputs!
				// I have to do this before wp_cache_set since i don't
				// want the escaped double slashes to be cached either
				$newvalue = preg_replace('#\\\\"#', '"', $newvalue);

				wp_cache_set($option_name, $newvalue, 'options');

				// Since i take raw input for update i have to replace single quotes manually
				$newvalue = preg_replace("#'#", "\\'", $newvalue);

				$option_name = $wpdb->escape($option_name);
				$wpdb->query("UPDATE $wpdb->options SET option_value = '$newvalue' WHERE option_name = '$option_name'");
				if ( $wpdb->rows_affected == 1 ) {
					do_action("update_option_{$option_name}", array('old'=>$oldvalue, 'new'=>$_newvalue));
					return true;
				}

				return false;

			}

			/**
			 * Stub Function doing nothing
			 * I wish PHP hat Interfaces
			 **/
			function setLevel() {}

		}

	}

?>