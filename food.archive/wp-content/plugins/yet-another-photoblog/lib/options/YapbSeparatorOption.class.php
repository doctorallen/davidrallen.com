<?php

	/**
	 * Separator Option which renders a simple separator
	 **/

	require_once realpath(dirname(__FILE__) . '/YapbBaseOption.class.php');

	if (!class_exists('YapbSeparatorOption')) {

		class YapbSeparatorOption extends YapbBaseOption {

			/**
			 * Constructor
			 **/
			function YapbCheckboxInputOption() {}

			/**
			 * Initialization of the option with its default value 
			 * on plugin activation
			 **/
			function initialize() {}

			/**
			 * Update of the option after 
			 * submitting the option form
			 **/
			function update() {}

			/**
			 * Display of the option
			 * on the option form
			 **/
			function toString() {
				return '<div class="yapb-options-separator"><!-- separator --></div>';
			}

		}

	}

?>