<?php

	/**
	 * Textarea Option
	 * 
	 * Sample Usage:
	 *
	 * $option = new YapbTextareaOption('yapb_option_name', __('Your comment', 'yapb'), 'huh?');
	 *
	 **/

	require_once realpath(dirname(__FILE__) . '/YapbBaseOption.class.php');

	if (!class_exists('YapbTextareaOption')) {

		class YapbTextareaOption extends YapbBaseOption {

			var $name;
			var $description;
			var $defaultValue;

			/**
			 * Constructor
			 * 
			 * @param string $name
			 * @param string $description
			 **/
			function YapbTextareaOption($name, $description, $defaultValue) {
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
				return '<p class="yapb-first">' . $this->description . '</p>' .
					'<textarea name="' . $this->name . '" style="width:98%;" rows="3" cols="50">' . 
					get_option($this->name) . 
					'</textarea>';

			}

		}

	}

?>