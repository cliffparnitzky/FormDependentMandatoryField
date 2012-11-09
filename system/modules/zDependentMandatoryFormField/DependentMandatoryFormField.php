<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Cliff Parnitzky 2012
 * @author     Cliff Parnitzky
 * @package    DependentMandatoryFormField
 * @license    LGPL
 */

/**
 * Class DependentMandatoryFormField
 *
 * @copyright  Cliff Parnitzky 2012
 * @author     Cliff Parnitzky
 */
class DependentMandatoryFormField extends Backend {
	
	private static $RULE_ONE = '0';
	private static $RULE_ALL = '1';
	
	/**
	 * Constructor, initialize the object.
	 */
	public function __construct() {
		parent::__construct();
		$this->import('Database');
		$this->import('Input');
	}
	 
	/**
	 * Execute Hook: loadFormField to add special classes
	 */
	public function loadDependentMandatoryFormField(Widget $objWidget, $strFormId, $arrData) {
		if ($objWidget->dependentMandatoryActive) {
			$objWidget->class = "dependent";
			$objWidget->required = true;
		}
		return $objWidget;
	}
	
	/**
	 * Execute Hook: validateFormField to check if the dependent form field is valid
	 */
	public function validateDependentMandatoryFormField(Widget $objWidget, $strFormId, $arrData) {
		if ($objWidget->dependentMandatoryActive) {
			$arrDependentMandatorySuperiorFields = deserialize($objWidget->dependentMandatorySuperiorFields);
			$method = strtolower($this->getFormMethod($arrData['id']));

			$filledSuperiorFields = 0;
			foreach ($arrDependentMandatorySuperiorFields as $field) {
				if ($this->Input->$method($field) != null) {
					$filledSuperiorFields++;
				}
			}
			
			if ($filledSuperiorFields > 0 && $this->Input->$method($objWidget->name) == null) {
				if ($objWidget->dependentMandatoryValidationRule == self::$RULE_ALL && count($arrDependentMandatorySuperiorFields) == $filledSuperiorFields) {
					// all superior fields are filled
					$objWidget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['dependentMandatoryError'], $objWidget->label));
				} else if ($objWidget->dependentMandatoryValidationRule == self::$RULE_ONE) {
					$objWidget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['dependentMandatoryError'], $objWidget->label));
				}
			} else if ($objWidget->dependentMandatoryEmpty && $this->Input->$method($objWidget->name) != null) {
				if ($objWidget->dependentMandatoryValidationRule == self::$RULE_ALL && count($arrDependentMandatorySuperiorFields) != $filledSuperiorFields) {
						$objWidget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorEmpty'], $objWidget->label));
				} else if ($objWidget->dependentMandatoryValidationRule == self::$RULE_ONE && $filledSuperiorFields == 0) {
					$objWidget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['dependentMandatoryError'], $objWidget->label));
				}
			}
		}
		
		return $objWidget;
	}

	/**
	 * Determine the forms method.
	 */
	private function getFormMethod ($formId) {
		return $this->Database->prepare("SELECT method FROM tl_form WHERE id = ?")->limit(1)->execute($formId)->method;
	}
	
	/**
	 * Return all possible form fields as array
	 * @return array
	 */
	public function getAllInputFormFields(DataContainer $dc) {
		$fields = array();
		
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll') {
			$intPid = $this->Input->get('id');
		}

		// Get all form fields which can be used
		$objFields = $this->Database->prepare("SELECT name,label,type FROM tl_form_field WHERE pid = ? AND NOT id = ? ORDER BY name ASC")
							->execute(array($intPid, $this->Input->get('id')));

		while ($objFields->next()) {
			$strClass = $GLOBALS['TL_FFL'][$objFields->type];

			// Continue if the class is not defined
			if (!$this->classFileExists($strClass)) {
				continue;
			}
			
			// Continue if the class is not an input submit
			$widget = new $strClass;
			if (!$widget->submitInput()) {
				continue;
			}
			
			$name = $objFields->name;
			$label = $objFields->label;
			$fields[$name] = strlen($label) ? $label.' ['.$name.']' : $name;
		}

		return $fields;
	}
}

?>