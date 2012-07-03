<?php

	/**
	 * Checkbox Option with select field in text
	 * 
	 * Sample Usage:
	 *
	 * $option = new YapbPrototypeOption('name', 'description');
	 *
	 **/

	require_once realpath(dirname(__FILE__) . '/YapbBaseOption.class.php');

	if (!class_exists('YapbPrototypeOption')) {

		class YapbPrototypeOption extends YapbBaseOption {

			var $name;
			var $description;

			/**
			 * Constructor
			 * 
			 * @param string $name
			 * @param string $description
			 **/
			function YapbCheckboxOption($name, $description) {
				$this->name = $name;
				$this->description = $description;
			}

			/**
			 * Initialization of the option with its default value 
			 * on plugin activation
			 **/
			function initialize() {

			}

			/**
			 * Initialize the option:
			 * Create option with given default value if not already existant
			 **/
			function initialize() {

			}

			/**
			 * Update of the option after 
			 * submitting the option form
			 **/
			function update() {

			}

			/**
			 * Display of the option
			 * on the option form
			 **/
			function toString() {

			}

		}

	}

?>