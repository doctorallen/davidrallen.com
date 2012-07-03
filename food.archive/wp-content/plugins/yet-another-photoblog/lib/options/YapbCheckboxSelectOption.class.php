<?php

	/**
	 * Checkbox Option with select field in text
	 * 
	 * Sample Usage:
	 *
	 * $option = new YapbCheckboxSelectOption(
	 *   'yapb_some_option',
	 *   __('Set something always to # if checked', 'yapb'),
	 *   array(
	 *     'Title of value 01' => '01',
	 *     'Title of value 02' => '02',
	 *     'Title of value 03' => '03'
	 *   ),
	 *   false
	 * );
	 *
	 **/

	require_once realpath(dirname(__FILE__) . '/YapbBaseOption.class.php');

	if (!class_exists('YapbCheckboxSelectOption')) {

		class YapbCheckboxSelectOption extends YapbBaseOption {

			var $name;
			var $description;
			var $selectItems;
			var $defaultChecked;
			var $defaultSelectValue;

			/**
			 * Constructor
			 * 
			 * @param string $name
			 * @param string $description
			 * @param array $selectItems Assoziative array containing the selectable options (title => value)
			 * @param boolean $defaultChecked
			 * @param string $defaultSelectValue
			 **/
			function YapbCheckboxSelectOption($name, $description, $selectItems, $defaultChecked=false, $defaultSelectValue='') {
				$this->name = $name;
				$this->description = $description;
				$this->selectItems = $selectItems;
				$this->defaultChecked = $defaultChecked;
				$this->defaultSelectValue = $defaultSelectValue;
			}

			/**
			 * Initialization of the option with its default value 
			 * on plugin activation
			 **/
			function initialize() {
				add_option($this->name . '_activate', $this->defaultChecked);
				add_option($this->name, $this->defaultSelectValue);
			}

			/**
			 * Update of the option after 
			 * submitting the option form
			 **/
			function update() {
				update_option($this->name . '_activate', Params::get($this->name . '_activate', ''));
				update_option($this->name, Params::get($this->name, ''));
			}

			/**
			 * Display of the option
			 * on the option form
			 **/
			function toString() {
				
				$checkboxname = $this->name . '_activate';

				$checkbox = '<input type="checkbox" name="' . $checkboxname . '" value="1" ' . (get_option($checkboxname) ? 'checked' : '') . ' /> ';

				$selectField = '<select name="' . $this->name . '">';
				$selectedValue = get_option($this->name);
				foreach ($this->selectItems as $optionTitle => $optionValue) {
					$selectField .= '<option value="' . $optionValue . '"' . ($optionValue == $selectedValue ? ' selected' : '') . '>' . $optionTitle . '</option>';
				}
				$selectField .= '</select>';

				return $checkbox . preg_replace('/#/', $selectField, $this->description);

			}

		}

	}

?>