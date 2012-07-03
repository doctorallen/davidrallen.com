<?php

	/**
	 * Select Option
	 * 
	 * Sample Usage:
	 *
	 * $option = new YapbSelectOption(
	 *     'yapb_option_name',
	 *     __('Default image size of # px', 'yapb'),
	 *    array(
	 *        'small' => '80',
	 *        'medium' => '120',
	 *        'large' => '320'
	 *    ),
	 *    '80'
	 * );
	 *
	 **/

	require_once realpath(dirname(__FILE__) . '/YapbBaseOption.class.php');

	if (!class_exists('YapbSelectOption')) {

		class YapbSelectOption extends YapbBaseOption {

			var $name;
			var $description;
			var $selectItems;
			var $defaultValue;

			/**
			 * Constructor
			 * 
			 * @param string $name
			 * @param string $description
			 **/
			function YapbSelectOption($name, $description, $selectItems, $defaultValue) {
				$this->name = $name;
				$this->description = $description;
				$this->selectItems = $selectItems;
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
				update_option($this->name, Params::get($this->name, ''));
			}

			/**
			 * Display of the option
			 * on the option form
			 **/
			function toString() {

				$selectField = '<select name="' . $this->name . '">';
				$selectedValue = get_option($this->name);
				foreach ($this->selectItems as $optionTitle => $optionValue) {
					$selectField .= '<option value="' . $optionValue . '"' . ($optionValue==$selectedValue ? ' selected' : '') . '>' . $optionTitle . '</option>';
				}
				$selectField .= '</select>';
				return preg_replace('/#/', $selectField, $this->description);

			}

		}

	}

?>