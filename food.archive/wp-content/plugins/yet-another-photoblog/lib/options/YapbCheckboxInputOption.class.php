<?php

	/**
	 * Checkbox Option with input field in text
	 * 
	 * Sample Usage:
	 *
	 * $option = new YapbCheckboxInputOption(
	 *   'yapb_some_option',
	 *   __('Display the text #20 if checked', 'yapb'),
	 *   'huh?'
	 * );
	 *
	 **/

	require_once realpath(dirname(__FILE__) . '/YapbBaseOption.class.php');

	if (!class_exists('YapbCheckboxInputOption')) {

		class YapbCheckboxInputOption extends YapbBaseOption {

			var $name;
			var $description;
			var $defaultChecked;
			var $defaultInputValue;

			/**
			 * Constructor
			 * 
			 * @param string $name
			 * @param string $description
			 * @param array $selectItems Assoziative array containing the selectable options (title => value)
			 * @param boolean $defaultChecked
			 * @param string $defaultSelectValue
			 **/
			function YapbCheckboxInputOption($name, $description, $defaultChecked=false, $defaultInputValue='') {
				$this->name = $name;
				$this->description = $description;
				$this->defaultChecked = $defaultChecked;
				$this->defaultInputValue = $defaultInputValue;
			}

			/**
			 * Initialization of the option with its default value 
			 * on plugin activation
			 **/
			function initialize() {
				add_option($this->name . '_activate', $this->defaultChecked);
				add_option($this->name, $this->defaultInputValue);
			}

			/**
			 * Update of the option after 
			 * submitting the option form
			 **/
			function update() {
				update_option($this->name . '_activate', Params::get($this->name . '_activate', ''));
				$this->update_html_option($this->name, Params::get($this->name, ''));
			}

			/**
			 * Display of the option
			 * on the option form
			 **/
			function toString() {

				$checkboxName = $this->name . '_activate';

				preg_match('/#([0-9]+)/', $this->description, $match);
				$checkbox = '<input id="' . $checkboxName . '" type="checkbox" name="' . $checkboxName . '" value="1" ' . (get_option($checkboxName) ? 'checked' : '') . ' /> ';
				$inputField = '<input type="text" size="' . $match[1] . '" name="' . $this->name . '" value="' . get_option($this->name) . '" /> ';

				return $checkbox . '<label for="' . $checkboxName . '">' . preg_replace('/#[0-9]+/', '</label>' . $inputField, $this->description);

			}

		}

	}

?>