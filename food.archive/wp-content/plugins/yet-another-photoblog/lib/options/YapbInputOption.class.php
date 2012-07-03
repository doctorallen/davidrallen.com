<?php

	/**
	 * Input Option
	 * 
	 * The description field holds a marker for the input field in the following form
	 * #NR The fields position and the inputs size attribute as NR
	 * 
	 * Sample Usage:
	 *
	 * $option = new YapbInputOption('yapb_option_name', __('Your telephone number: #10 (max 10 digits)', 'yapb'), 'huh?');
	 *
	 **/

	require_once realpath(dirname(__FILE__) . '/YapbBaseOption.class.php');

	if (!class_exists('YapbInputOption')) {

		class YapbInputOption extends YapbBaseOption {

			var $name;
			var $description;
			var $defaultValue;

			/**
			 * Constructor
			 * 
			 * @param string $name
			 * @param string $description
			 **/
			function YapbInputOption($name, $description, $defaultValue) {
				$this->name = $name;
				$this->description = $description;
				$this->defaultValue = $defaultValue;
			}

			/**
			 * Initialization of the option with its default value 
			 * on plugin activation
			 **/
			function initialize() {
				add_option($this->name, $this->defaultValue);
			}

			/**
			 * Update of the option after 
			 * submitting the option form
			 **/
			function update() {
				$this->update_html_option($this->name, Params::get($this->name, ''));
			}

			/**
			 * Display of the option
			 * on the option form
			 **/
			function toString() {
				preg_match('/#([0-9]+)/', $this->description, $match);
				$input = '<input type="text" size="' . $match[1] . '" name="' . $this->name . '" value="' . get_option($this->name) . '" />';
				return preg_replace('/#[0-9]+/', $input, $this->description);
			}

		}

	}

?>