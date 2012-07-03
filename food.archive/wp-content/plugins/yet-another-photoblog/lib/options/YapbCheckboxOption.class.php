<?php

	/**
	 * Default Checkbox Option
	 *
	 * Sample Usage:
	 *
	 * $option = new YapbCheckboxOption('yapb_option_name', __('Do something if checked', 'yapb'), false);
	 *
	 **/

	require_once realpath(dirname(__FILE__) . '/YapbBaseOption.class.php');

	if (!class_exists('YapbCheckboxOption')) {

		class YapbCheckboxOption extends YapbBaseOption {

			var $defaultChecked;

			/**
			 * Constructor
			 * 
			 * @param string $name
			 * @param string $description
			 * @param boolean $defaultValue
			 **/
			function YapbCheckboxOption($name, $description, $defaultChecked) {
				$this->name = $name;
				$this->description = $description;
				$this->defaultChecked = $defaultChecked;
			}

			/**
			 * Initialization of the option with its default value 
			 * on plugin activation
			 **/
			function initialize() {
				add_option($this->name, $this->defaultChecked); 
			}

			/**
			 * Update of the option after 
			 * submitting the option form
			 **/
			function update() {
				update_option($this->name, Params::get($this->name, ''));
			}

			/**
			 * Display of the option
			 * on the option form
			 **/
			function toString() {
				return '<input type="checkbox" id="' . $this->name .'" name="' . $this->name . '" value="1" ' . (get_option($this->name) ? 'checked' : '') . ' /><label for="' . $this->name . '"> ' . $this->description . '</label>';
			}

		}

	}

?>