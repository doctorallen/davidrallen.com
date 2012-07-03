<?php

	/**
	 * Yapb Exif Tagnames Option
	 * This is a highly individual Option: It displays all learned
	 * EXIF tagnames and the user may choose which get displayed over
	 * the according template function
	 * 
	 * Sample Usage:
	 *
	 * $option = new YapbExifTagnamesOption('yapb_option_name', 'description', array());
	 *
	 **/

	require_once realpath(dirname(__FILE__) . '/YapbBaseOption.class.php');

	if (!class_exists('YapbExifTagnamesOption')) {

		class YapbExifTagnamesOption extends YapbBaseOption {

			var $name;
			var $description;
			var $defaultValue;

			/**
			 * Constructor
			 * 
			 * @param string $name
			 * @param string $description
			 **/
			function YapbExifTagnamesOption($name, $description, $defaultValue) {
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

				if (isset($_POST[$this->name])) {
					$temp = $_POST[$this->name];
					update_option($this->name, implode(',', $temp));
				} else update_option($this->name, '');

			}

			/**
			 * Display of the option
			 * on the option form
			 **/
			function toString() {

				$result = '<p>' . $this->description . '</p>';
				$result .= '<table border="0" style="margin:0px;">';
				$result .= '<tr>';
				$result .= '<td valign="top" nowrap style="border:0;">';
		
				$allLearnedTagnames = ExifUtils::getLearnedTagnames();
				
				$selected = explode(',', get_option($this->name));
				if (!is_array($selected)) {
					$selected = array();
				}

				$i=0;
				$count = count($allLearnedTagnames);

				if ($count > 0) {

					for ($i; $i<$count; $i++) {
						$result .= '<input id="' . $this->name . '_' . $i . '" type="checkbox" name="' . $this->name . '[]" value="' . $allLearnedTagnames[$i] . '"' . 
							((in_array($allLearnedTagnames[$i], $selected)) ? ' checked' : '') . ' /> <label for="' . $this->name . '_' . $i . '" style="cursor:hand;">' . $allLearnedTagnames[$i] . '</label><br>';
						if (($i + 1) % ($count/4) == 0) $result .= '</td><td style="padding-left:20px;border:0;" valign="top">';
					}
					if (($i + 1) % ($count/4) == 0) $result .= '</td>';

				} else {

					// We attach an timestamp to the form action URL so 
					// we always see accurate data

					$requestURI = $_SERVER['SCRIPT_NAME'];
					$requestParameters = array();
					$requestParameters[] = 'nocache=' . time();
					$requestParameters[] = 'page=' . Params::get('page', '');
					$requestParameters[] = 'action=retrain_exif';
					$requestURI .= ((strpos($requestURI, '?') === false) ? '?' : '&') . implode('&', $requestParameters);

					$result .= __('Please post at least one image containing EXIF data so YAPB can learn which EXIF tags your camera uses.', 'yapb');
					$result .= '<br/>';
					$result .= '<a href="' . $requestURI . '">' . __('Retrain filter based on already posted images', 'yapb') . '</a>';

				}

				$result .= '</tr>';
				$result .= '</table>';

				return $result;

			}

		}

	}

?>