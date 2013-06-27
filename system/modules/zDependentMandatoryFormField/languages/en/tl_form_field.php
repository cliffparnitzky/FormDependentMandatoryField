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

// fields
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryActive']         = array('Activate dependent mandatory form field', 'Select if this field must contain a value, if one of its superior fields is filled.');
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFields'] = array('Superior fields', 'Select the form fields, which, if they contain the defined value, let the actual field be mandatory. If there are more than one condifitons for a superior field, at least one has to be true (OR combination).');
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryValidationRule'] = array('Validation rule', 'Select how the superior fields have to be filled to make this field a mandatory field.');
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryEmpty']          = array('Field must be empty if validation rule is not satisfied', 'Select if the field has to be empty if the validation rule is not satisfied.');

// mcw fields
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldName']      = array('Form field', 'Select the form field.');
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldCondition'] = array('Condition', 'Select the condition for field valiation.');
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldValue']     = array('Value', 'Specify the value to be tested during validation. As a placeholder for any field value a \'*\' (asterisk) can be used.');

// legends
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatory_legend'] = "Dependent mandatory form field";

// fields
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryValidationRuleOptions']['0'] = 'At least 1 field must not be empty.';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryValidationRuleOptions']['1'] = 'All fields must not be empty.';


// options
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['eq'] = '= (equal)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['ne'] = '!= (not equal)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['lt'] = '< (lower)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['le'] = '<= (lower or equal)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['gt'] = '> (greater)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['ge'] = '>= (greater or equal)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['lk'] = 'LIKE (similar to)';

?>