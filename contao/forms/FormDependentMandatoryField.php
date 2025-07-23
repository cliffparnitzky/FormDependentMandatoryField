<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2025
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
 * @copyright  Cliff Parnitzky 2012-2025
 * @author     Cliff Parnitzky
 * @package    FormDependentMandatoryField
 * @license    LGPL
 */

namespace CliffParnitzky\FormDependentMandatoryField;

use Contao\Backend;
use Contao\Database;
use Contao\Form;
use Contao\FormFieldModel;
use Contao\FormUpload;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use Contao\Widget;
use MenAtWork\MultiColumnWizardBundle\Contao\Widgets\MultiColumnWizard;

/**
 * Class FormDependentMandatoryField
 *
 * @copyright  Cliff Parnitzky 2012-2025
 * @author     Cliff Parnitzky
 */
class FormDependentMandatoryField extends Backend
{

  const RULE_ONE = '0';
  const RULE_ALL = '1';

  /**
   * Constructor, initialize the object.
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute Hook: loadFormField to store the files and add special CSS classes
   */
  public function loadDependentMandatoryField(Widget $objWidget, $strFormId, $arrData)
  {
    // Store the transferred files to be able to validate
    $arrStoredFiles = System::getContainer()->get('request_stack')->getCurrentRequest()->attributes->get('dependentMandatoryFormFiles') ?? array();
    System::getContainer()->get('request_stack')->getCurrentRequest()->attributes->set('dependentMandatoryFormFiles', \array_merge($arrStoredFiles, $_FILES));

    // Add the CSS classes
    if ($objWidget->dependentMandatoryActive)
    {
      $objWidget->class = "dependent mandatory";
    }
    return $objWidget;
  }

  /**
   * Execute Hook: validateFormField to check if the dependent form field is valid
   */
  public function validateDependentMandatoryField(Widget &$objWidget, string $formId, array $formData, Form $form)
  {
    if ($objWidget->dependentMandatoryActive && static::isFormFieldSubmittable(FormFieldModel::findById($objWidget->id)->type) && static::isFormPostSubmitted($objWidget->id))
    {
      $arrDependentMandatorySuperiorFields = StringUtil::deserialize($objWidget->dependentMandatorySuperiorFields);

      // collect all conditions for each field
      $arrSuperiorFields = array();
      foreach ($arrDependentMandatorySuperiorFields as $field)
      {
        $fieldName = $field['superiorFieldName'];
        if (!array_key_exists($fieldName, $arrSuperiorFields))
        {
          $arrSuperiorFields[$fieldName] = array();
        }
        $arrSuperiorFields[$fieldName][] = array('condition' => $field['superiorFieldCondition'], 'value' => $field['superiorFieldValue']);
      }

      $formFields = $this->getFormFields($formData['id']);
      $filledSuperiorFields = array();
      $allSuperiorFields = array();
      $filledSuperiorFieldsCount = 0;
      foreach ($arrSuperiorFields as $field => $rules)
      {
        $values = array();
        $fieldValue = System::getContainer()->get('request_stack')->getCurrentRequest()->request->all()[$field] ?? null;

        if ($fieldValue === null && $this->isFormUpload($field, $formData['id']))
        {
          $values[] = System::getContainer()->get('request_stack')->getCurrentRequest()->attributes->get('dependentMandatoryFormFiles')[$field]['name'];
        }
        else
        {
          if (is_array($fieldValue))
          {
            $values = $fieldValue;
          }
          else
          {
            $values[] = $fieldValue;
          }
        }

        // check against rules
        $blnMatched = false;

        $blnIsValueEmpty = false;

        foreach ($values as $value)
        {
          $blnIsValueEmpty = ($value == null || strlen($value) == 0);
          foreach ($rules as $rule)
          {
            if (!$blnMatched)
            {
              // compare the entered value with the expected value
              $expectedValue = $rule['value'];
              $condition = $rule['condition'];

              if ($expectedValue == '*')
              {
                if (($condition == 'eq' || $condition == 'lk') && $value != null && strlen($value) > 0)
                {
                  $blnMatched = true;
                }
                else if ($condition == 'ne' && $value == null && strlen($value) == 0)
                {
                  $blnMatched = true;
                }
              }
              else
              {
                //convert $value / $expectedValue into numbers if possible
                if (is_int($value) && is_int($expectedValue))
                {
                  $value = intval($value);
                  $expectedValue = intval($expectedValue);
                }
                else if (is_float($value) && is_float($expectedValue))
                {
                  $value = floatval($value);
                  $expectedValue = floatval($expectedValue);
                }

                switch ($condition)
                {
                  case 'eq':
                    $blnMatched = ($value ==  $expectedValue);
                    break;
                  case 'ne':
                    $blnMatched = ($value !=  $expectedValue);
                    break;
                  case 'lt':
                    $blnMatched = ($value <  $expectedValue);
                    break;
                  case 'le':
                    $blnMatched = ($value <=  $expectedValue);
                    break;
                  case 'gt':
                    $blnMatched = ($value >  $expectedValue);
                    break;
                  case 'ge':
                    $blnMatched = ($value >=  $expectedValue);
                    break;
                  case 'lk':
                    $blnMatched = (strpos($value, $expectedValue) !== FALSE);
                    break;
                }
              }
            }
          }
        }
        if ($blnMatched)
        {
          $filledSuperiorFields[] = array('fieldName' => $formFields[$field], 'isValueEmpty' => $blnIsValueEmpty);
          $filledSuperiorFieldsCount++;
        }

        $allSuperiorFields[] = array('fieldName' => $formFields[$field], 'isValueEmpty' => $blnIsValueEmpty);
      }

      $widgetValue = System::getContainer()->get('request_stack')->getCurrentRequest()->request->get($objWidget->name);

      if ($widgetValue == null && $this->isFormUpload($objWidget->name, $formData['id']))
      {
        $widgetValue = System::getContainer()->get('request_stack')->getCurrentRequest()->attributes->get('dependentMandatoryFormFiles')[$objWidget->name]['name'];
      }

      if ($filledSuperiorFieldsCount > 0 && $widgetValue == null)
      {
        if (($objWidget->dependentMandatoryValidationRule == self::RULE_ALL && count($arrSuperiorFields) == $filledSuperiorFieldsCount) ||
          ($objWidget->dependentMandatoryValidationRule == self::RULE_ONE)
        )
        {
          $objWidget->addError($this->getErrorMessage('dependentMandatoryErrorMandatory', $objWidget, $filledSuperiorFieldsCount, $filledSuperiorFields));
        }
      }
      else if ($objWidget->dependentMandatoryEmpty && $widgetValue != null)
      {
        if (($objWidget->dependentMandatoryValidationRule == self::RULE_ALL && count($arrSuperiorFields) != $filledSuperiorFieldsCount) ||
          ($objWidget->dependentMandatoryValidationRule == self::RULE_ONE && $filledSuperiorFieldsCount == 0)
        )
        {
          $objWidget->addError($this->getErrorMessage('dependentMandatoryErrorEmpty', $objWidget, count($arrSuperiorFields), $allSuperiorFields));
        }
      }
    }

    return $objWidget;
  }

  /**
   * Return all possible form fields as array
   * @return array
   */
  public function getFormFields($formId)
  {
    System::loadLanguageFile('tl_form_field');

    $fields = array();

    // Get all form fields which can be used
    $obFormFields = Database::getInstance()
      ->prepare("SELECT * FROM tl_form_field WHERE pid = ? ORDER BY label, name ASC")
      ->execute($formId);

    while ($obFormFields->next())
    {
      $fields[$obFormFields->name] = (strlen($obFormFields->label) > 0) ? $obFormFields->label : $obFormFields->name;
    }

    return $fields;
  }

  /**
   * Creates a special error message for each case.
   */
  private function getErrorMessage($msgKey, $objWidget, $superiorFieldsCount, $filledSuperiorFields)
  {
    if ($superiorFieldsCount > 0)
    {
      $arrFieldErrorTexts = array();
      foreach ($filledSuperiorFields as $filledSuperiorField)
      {
        $arrFieldErrorTexts[] = sprintf($GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorField']['One'], $filledSuperiorField['fieldName'], $filledSuperiorField['isValueEmpty'] ? $GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorValue']['Empty'] : $GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorValue']['Filled']);
      }

      $strLastFieldErrorText = array_pop($arrFieldErrorTexts);

      if (!empty($arrFieldErrorTexts))
      {
        $strFieldErrorTexts = sprintf($GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorField']['All'], implode(', ', $arrFieldErrorTexts), $strLastFieldErrorText);
      }
      else
      {
        $strFieldErrorTexts = $strLastFieldErrorText;
      }

      return sprintf($GLOBALS['TL_LANG']['ERR'][$msgKey], $objWidget->label, $strFieldErrorTexts);
    }

    return '';
  }

  /**
   * Return all possible form fields as array ... to configure superior fields in dca
   * @return array
   */
  public function getAllInputFormFields(MultiColumnWizard $mcw)
  {
    System::loadLanguageFile('tl_form_field');

    $fields = array();

    $intPid = -1;

    if (Input::get('act') == 'overrideAll' || Input::get('act') == 'editAll')
    {
      $intPid = Input::get('id');
    }
    else
    {
      $intPid = Database::getInstance()
        ->prepare("SELECT pid FROM tl_form_field WHERE id = ?")
        ->limit(1)
        ->execute(Input::get('id'))
        ->pid;
    }

    // Get all form fields which can be used
    $obFormFields = Database::getInstance()
      ->prepare("SELECT * FROM tl_form_field WHERE pid = ? AND id <> ? ORDER BY label, name ASC")
      ->execute($intPid, Input::get('id'));

    while ($obFormFields->next())
    {
      $strClass = $GLOBALS['TL_FFL'][$obFormFields->type];

      // Continue if the class is not defined
      if (!class_exists($strClass))
      {
        continue;
      }

      // Continue if the class is not an input submit
      $widget = new $strClass;
      if (!$widget->submitInput() && !$widget instanceof FormUpload)
      {
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
  private function isFormUpload($fieldName, $formId)
  {
    $obFormField = Database::getInstance()
      ->prepare("SELECT * FROM tl_form_field WHERE name = ? AND pid = ?")
      ->limit(1)
      ->execute($fieldName, $formId);

    if ($obFormField->next())
    {
      $strClass = $GLOBALS['TL_FFL'][$obFormField->type];

      // Continue if the class is not defined
      if (class_exists($strClass))
      {
        // check if the class correct type
        $widget = new $strClass;
        return ($widget instanceof FormUpload);
      }
    }

    return false;
  }

  /**
   * Checks if a form field is submittable.
   */
  public static function isFormFieldSubmittable($strWidgetName)
  {
    if (array_key_exists($strWidgetName, $GLOBALS['TL_FFL']))
    {
      $strWidgetClass = $GLOBALS['TL_FFL'][$strWidgetName];
      if (!empty($strWidgetClass))
      {
        $objWidget = new $strWidgetClass();
        if ($objWidget)
        {
          if ($strWidgetName == 'upload')
          {
            // this field is not submittable but should also be usable.
            return true;
          }
          return $objWidget->submitInput();
        }
      }
    }
    return false;
  }

  /**
   * Checks if the forms submission method is `POST`.
   */
  public static function isFormPostSubmitted($fieldId)
  {
    return Database::getInstance()
      ->prepare("SELECT method FROM tl_form WHERE id = (SELECT pid FROM tl_form_field WHERE id = ?)")
      ->limit(1)
      ->execute($fieldId)
      ->method == "POST";
  }
}
