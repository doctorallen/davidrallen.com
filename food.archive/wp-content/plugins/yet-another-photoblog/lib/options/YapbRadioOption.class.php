<?php

	/**
	 * Default Checkbox Option
	 *
	 * Sample Usage:
	 *
	 * $option = new YapbRadioOption('yapb_option_name', 'description', 'value', false);
	 *
	 **/

	require_once realpath(dirname(__FILE__) . '/YapbBaseOption.class.php');

	if (!class_exists('YapbRadioOption')) {

		class YapbRadioOption extends YapbBaseOption {

			static $index = 0;
			
			var $name;
			var $description;
			var $value;
			var $defaultChecked;

			/**
			 * Constructor
			 * 
			 * @param string $name
			 * @param string $description
			 * @param string $value
			 * @param boolean $defaultChecked
			 **/
			function YapbRadioOption($name, $description, $value, $defaultChecked) {
				$this->name = $name;
				$this->description = $description;
				$this->value = $value;
				$this->defaultChecked = $defaultChecked;
			}

			/**
			 * Initialization of the option with its default value 
			 * on plugin activation
			 **/
			function initialize() {
				if (get_option($this->name) === false) {
					if ($this->defaultChecked) {
						add_option($this->name, $this->value);
					} else {
						add_option($this->name, '');
					}
				}
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
				
				// There may be multiple radios for the same option name
				// We have to assure that every radio-element has an
				// unique id. We do that be introducing a static index
				// over all radio buttons that we increase every time
				// we display one of them.
				
				self::$index += 1;
				
				// The index gets attached to the id
				
				$element_id = $this->name . '_' . self::$index;
				
				// returning the html
				
				return '<input type="radio" id="' . $element_id . '" name="' . $this->name . '" value="' . $this->value . '" ' . ((get_option($this->name) && get_option($this->name) == $this->value) ? 'checked' : '') . ' /><label for="' . $element_id . '"> ' . $this->description . '</label>';
				
			}

		}

	}

?>