<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2020 Leo Feyer
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
 * @copyright  Cliff Parnitzky 2012-2020
 * @author     Cliff Parnitzky
 * @package    FormDependentMandatoryField
 * @license    LGPL
 */

if (TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS'][] = 'system/modules/zFormDependentMandatoryField/assets/backend.css';
}

$GLOBALS['TL_DCA']['tl_form_field']['config']['onload_callback'][] = array('tl_form_field_FormDependentMandatoryField', 'initPalettes');

// Palettes
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][] = 'dependentMandatoryActive';

foreach ($GLOBALS['TL_DCA']['tl_form_field']['palettes'] as $name=>$palette) {
  if (FormDependentMandatoryField::isFormFieldSubmittable($GLOBALS['TL_FFL'][$name]) || $name == 'textdigit')
  {
    $GLOBALS['TL_DCA']['tl_form_field']['palettes'][$name] = str_replace("{expert_legend:hide}", "{dependentMandatory_legend},dependentMandatoryActive;{expert_legend:hide}", $palette);
  }
}

// Subpalettes
array_insert($GLOBALS['TL_DCA']['tl_form_field']['subpalettes'], count($GLOBALS['TL_DCA']['tl_form_field']['subpalettes']),
  array('dependentMandatoryActive' => 'dependentMandatorySuperiorFields,dependentMandatoryValidationRule,dependentMandatoryEmpty')
);
 
// fields
$GLOBALS['TL_DCA']['tl_form_field']['fields']['dependentMandatoryActive'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryActive'],
  'exclude'                 => true,
  'filter'                  => true,
  'inputType'               => 'checkbox',
  'eval'                    => array('submitOnChange'=>true),
  'sql'                     => "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['dependentMandatorySuperiorFields'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFields'],
  'exclude'                 => true,
  'filter'                  => false,
  'inputType'               => 'multiColumnWizard',
  'eval'                    => array
  (
      'mandatory'    => true,
      'style'        => 'min-width: 100%;',
      'tl_class'     =>'clr',
      'helpwizard'   => true,
      'columnFields' => array
      (
          'superiorFieldName' => array
          (
              'label'            => &$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldName'],
              'exclude'          => true,
              'inputType'        => 'select',
              'options_callback' => array('FormDependentMandatoryField', 'getAllInputFormFields'),
              'eval'             => array('mandatory'=>true, 'style'=>'width: 400px;')
          ),
          'superiorFieldCondition' => array
          (
              'label'            => &$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldCondition'],
              'exclude'          => true,
              'inputType'        => 'select',
              'options'          => array('eq', 'ne', 'lt', 'le', 'gt', 'ge', 'lk'),
              'reference'        => &$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions'],
              'eval'             => array('mandatory'=>true, 'style'=>'width: 100px;')
          ),
          'superiorFieldValue' => array
          (
              'label'            => &$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldValue'],
              'exclude'          => true,
              'inputType'        => 'text',
              'eval'             => array('mandatory'=>true, 'style'=>'width: 200px;')
          )
      )
  ),
  'explanation'             => 'FormDependentMandatoryFieldRuleValues',
  'sql'                     => "blob NULL"
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
  'eval'                    => array('mandatory'=>true),
  'sql'                     => "char(1) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dependentMandatoryEmpty'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryEmpty'],
  'exclude'                 => true,
  'filter'                  => true,
  'inputType'               => 'checkbox',
  'sql'                     => "char(1) NOT NULL default ''"
);

/**
 * Class tl_form_field_FormDependentMandatoryField
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * PHP version 5
 * @copyright  Cliff Parnitzky 2020-2020
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class tl_form_field_FormDependentMandatoryField extends Backend
{
  /**
   * Default constructor
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Initialize the palettes when loading
   * @param \DataContainer
   */
  public function initPalettes($dc)
  {
    if (\Input::get('act') == "edit")
    {
      echo $dc->activeRecord->type;
      //$GLOBALS['TL_DCA']['tl_form']['palettes']['default'] = str_replace(',formID', '', $GLOBALS['TL_DCA']['tl_form']['palettes']['default']);
    }
  }
}

?>