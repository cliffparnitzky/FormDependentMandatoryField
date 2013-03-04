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

			$formFields = $this->getFormFields($arrData['id']);
			$filledSuperiorFieldsString = '';
			$allSuperiorFieldsString = '';
			$filledSuperiorFieldsCount = 0;
			foreach ($arrDependentMandatorySuperiorFields as $field) {
				$value = $this->Input->$method($field);
				if ($value == null && $this->isFormFileUpload($field, $arrData['id'])) {
					$value = $_SESSION['FILES'][$field]['name'];
				}
				if ($value != null) {
					if ($filledSuperiorFieldsCount > 0) {
						$filledSuperiorFieldsString .= ', ';
					}
					$filledSuperiorFieldsString .= $formFields[$field];
					$filledSuperiorFieldsCount++;
				}
				
				if (strlen($allSuperiorFieldsString)) {
					$allSuperiorFieldsString .= ', ';
				}
				$allSuperiorFieldsString .= $formFields[$field];
			}
			
			if ($filledSuperiorFieldsCount > 0 && $this->Input->$method($objWidget->name) == null) {
				if (($objWidget->dependentMandatoryValidationRule == self::$RULE_ALL && count($arrDependentMandatorySuperiorFields) == $filledSuperiorFieldsCount) ||
					($objWidget->dependentMandatoryValidationRule == self::$RULE_ONE)) {
					
					$objWidget->addError($this->getErrorMessage('dependentMandatoryErrorMandatory', $objWidget, $filledSuperiorFieldsCount, $filledSuperiorFieldsString));
				}
			} else if ($objWidget->dependentMandatoryEmpty && $this->Input->$method($objWidget->name) != null) {
				if (($objWidget->dependentMandatoryValidationRule == self::$RULE_ALL && count($arrDependentMandatorySuperiorFields) != $filledSuperiorFieldsCount) ||
					($objWidget->dependentMandatoryValidationRule == self::$RULE_ONE && $filledSuperiorFieldsCount == 0)) {
					
					$objWidget->addError($this->getErrorMessage('dependentMandatoryErrorEmpty', $objWidget, count($arrDependentMandatorySuperiorFields), $allSuperiorFieldsString));
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
	public function getFormFields($formId) {
		$this->loadLanguageFile('tl_form_field');

		$fields = array();

		// Get all form fields which can be used
		$obFormFields = $this->Database->prepare("SELECT * FROM tl_form_field WHERE pid = ? ORDER BY label, name ASC")
							->execute($formId);

		while ($obFormFields->next()) {
			$fields[$obFormFields->name] = (strlen($obFormFields->label) > 0) ? $obFormFields->label : $obFormFields->name;
		}

		return $fields;
	}
	
	/**
	 * Creates a special error message for each case.
	 */
	private function getErrorMessage ($msgKey, $objWidget, $superiorFieldsCount, $filledSuperiorFieldsString) {
		if ($superiorFieldsCount > 0) {
			$singularPluralErrorKey = 'Single';
			if ($superiorFieldsCount > 1) {
				$singularPluralErrorKey = 'Multiple';
			}
			return sprintf($GLOBALS['TL_LANG']['ERR'][$msgKey][$singularPluralErrorKey], $objWidget->label, $filledSuperiorFieldsString);
		}
		
		return '';
	}
	
	/**
	 * Return all possible form fields as array ... to configure superior fields in dca
	 * @return array
	 */
	public function getAllInputFormFields(DataContainer $dc) {
		$this->loadLanguageFile('tl_form_field');
		
		$fields = array();
		
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll') {
			$intPid = $this->Input->get('id');
		}

		// Get all form fields which can be used
		$obFormFields = $this->Database->prepare("SELECT * FROM tl_form_field WHERE pid = ? AND NOT id = ? ORDER BY label, name ASC")
							->execute(array($intPid, $this->Input->get('id')));

		while ($obFormFields->next()) {
			$strClass = $GLOBALS['TL_FFL'][$obFormFields->type];

			// Continue if the class is not defined
			if (!$this->classFileExists($strClass)) {
				continue;
			}
			
			// Continue if the class is not an input submit
			$widget = new $strClass;
			if (!$widget->submitInput() && !$widget instanceof FormFileUpload) {
				continue;
			}
			
			$fields[$obFormFields->name] = ((strlen($obFormFields->label) > 0) ? $obFormFields->label . " [" . $GLOBALS['TL_LANG']['tl_form_field']['name'][0] . ": " . $obFormFields->name . " / " : $obFormFields->name . " [") . $GLOBALS['TL_LANG']['tl_form_field']['type'][0] . ": " . $GLOBALS['TL_LANG']['FFL'][$obFormFields->type][0] . "]";
		}

		return $fields;
	}
	
	/**
	 * Return if the field with given id is of type file upload
	 * @return boolean
	 */
	private function isFormFileUpload ($fieldName, $formId) {
		$obFormField = $this->Database->prepare("SELECT * FROM tl_form_field WHERE name = ? AND pid = ?")
							->limit(1)
							->execute(array($fieldName, $formId));

		if ($obFormField->next()) {
			$strClass = $GLOBALS['TL_FFL'][$obFormField->type];

			// Continue if the class is not defined
			if ($this->classFileExists($strClass)) {
				// check if the class correct type
				$widget = new $strClass;
				return ($widget instanceof FormFileUpload);
			}			
		}

		return false;
	}
}

?>