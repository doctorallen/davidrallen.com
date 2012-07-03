<?php
	
	/**
	 * This class acts as a collector for either 
	 * options or other groups
	 **/

	if (!class_exists('YapbOptionGroup')) {

		class YapbOptionGroup {

			static $index = 0;
			
			var $title;
			var $description;
			var $children;
			var $level;
			var $isPlugin;

			function YapbOptionGroup($title, $description, $children=array(), $level=0) {

				$this->title = $title;
				$this->description = $description;
				$this->children = $children;
				$this->setLevel($level);
				$this->isPlugin = false;

			}

			function setLevel($level) {
				$this->level = $level;
				for ($i=0, $ilen=count($this->children); $i<$ilen; $i++) {
					$child = &$this->children[$i];
					$child->setLevel($level+1);
				}
			}

			function initialize() {
				foreach ($this->children as $child) {
					$child->initialize();
				}
			}

			function update() {
				foreach ($this->children as $child) {
					$child->update();
				}
			}

			function add($optionOrGroup) {
				$this->children[] = $optionOrGroup;
			}
			
			function getTitle() {
				return $this->title;
			}
			
			function getChildren() {
				return $this->children;
			}

			function toString() {

				self::$index += 1;
				
				$result = '';

				switch ($this->level) {

					default:
					case 0:

						// Option Accordion on the page

						if (!empty($this->children)) {

							// Tabs UL

							$result .= '<a name="anchor" id="yapb-options-group-' . self::$index . '" class="basic-accordion-anchor yapb-option-group yapb-option-group-level' . $this->level . '">&nbsp;</a>';
							$result .= '<div id="accordion" class="basic-accordion">';

							// Accordion Items

							for ($i=0, $ilen=count($this->children); $i<$ilen; $i++) {

								$child = &$this->children[$i];

								if ($child->isPlugin) $result .= '<div class="yapb-plugin">';

								$result .= '<a href="#" class="basic-accordion-link basic-accordion-link-' . $i . '">' . $child->title . '</a>';
								$result .= '<div class="basic-accordion-content">';
								$result .= $child->toString();
								$result .= '</div>';

								if ($child->isPlugin) $result .= '</div>';

							}

							$result .= '</div>';

						}

						break;

					case 1: 

						// Outermost WordPress Options Grouping

						// $result = '<h3>' . ' ' . $this->title . '</h3>';
						if (!empty($this->description)) $result .= '<p>' . $this->description . '</p>';

						if (!empty($this->children)) {

							$result .= '<table class="yapb-option-group yapb-option-group-level' . $this->level . '" id="yapb-options-group-' . self::$index . '" style="height:auto;" class="form-table">';
							for ($i=0, $ilen=count($this->children); $i<$ilen; $i++) {
								$child = &$this->children[$i];
								$result .= $child->toString();
							}
							$result .= '</table>';

						}



						break;

					case 2:

						// Inner WordPress Option Grouping

						$result .= '<tr>';
						$result .= '<th valign="top" align="left">' . ' ' . $this->title . '</th>';
						$result .= '<td valign="top">';

						$result .= "\n" . '<div class="yapb-option-group yapb-option-group-level' . $this->level . '" id="yapb-options-group-' . self::$index . '">';
						
						if (!empty($this->description)) {
							$result .= "\n" . '<p class="yapb-first">' . $this->description . '</p>';
						}
						
						$result .= "\n" . '<ul class="yapb">';

						foreach ($this->children as $optionInstance) {
							$result .= "\n\n" . '<li>' . $optionInstance->toString() . '</li>';
						}

						$result .= "\n" . '</ul>';
						$result .= "\n" . '</div>';
						$result .= "\n" . '</td>';
						$result .= '</tr>';

						break;
						
					case 3:
					case 4:
						
						// Level 3 of nesting options
						
						$result .= '<div class="yapb-option-group yapb-option-group-level' . $this->level . '" id="yapb-options-group-' . self::$index . '">';
						$result .= '<ul>';
						
						if (!empty($this->children)) {
							foreach ($this->children as $optionInstance) {
								$result .= "\n\n" . '<li>' . $optionInstance->toString() . '</li>';
							}
						}
						
						$result .= '</ul>';
						$result .= '</div>';
						
						break;

				}

				return $result;

			}

		}

	}

?>