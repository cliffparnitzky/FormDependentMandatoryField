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
$GLOBALS['TL_DCA']['tl_form_field']['fields']['dependentMandatoryActive'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryActive'],
	'exclude'                 => true,
	'filter'                  => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dependentMandatorySuperiorFields'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFields'],
	'exclude'                 => true,
	'filter'                  => false,
	'inputType'               => 'checkbox',
	'options_callback'        => array('DependentMandatoryFormField', 'getAllInputFormFields'),
	'eval'                    => array('mandatory'=>true, 'multiple'=>true)
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dependentMandatoryValidationRule'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryValidationRule'],
	'exclude'                 => true,
	'filter'                  => false,
	'inputType'               => 'radio',
	'default'                 => '0',
	'options'                 => array('0', '1'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryValidationRuleOptions'],
	'eval'                    => array('mandatory'=>true)
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dependentMandatoryEmpty'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryEmpty'],
	'exclude'                 => true,
	'filter'                  => true,
	'inputType'               => 'checkbox'
);

// Palettes
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][] = 'dependentMandatoryActive';

foreach ($GLOBALS['TL_DCA']['tl_form_field']['palettes'] as $name=>$palette) {
	$GLOBALS['TL_DCA']['tl_form_field']['palettes'][$name] = str_replace("{expert_legend:hide}", "{dependentMandatory_legend},dependentMandatoryActive;{expert_legend:hide}", $palette);
}

// Subpalettes
array_insert($GLOBALS['TL_DCA']['tl_form_field']['subpalettes'], count($GLOBALS['TL_DCA']['tl_form_field']['subpalettes']),
	array('dependentMandatoryActive' => 'dependentMandatorySuperiorFields,dependentMandatoryValidationRule,dependentMandatoryEmpty')
);

?>