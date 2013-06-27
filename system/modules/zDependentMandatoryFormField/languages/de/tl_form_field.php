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
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryActive']         = array('Abhängiges Pflichtfeld aktivieren', 'Wählen Sie, ob das Feld zum Abschicken des Formulars ausgefüllt sein muss, wenn ein übergeordnetes Feld einen Wert enthält.');
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFields'] = array('Übergeordnete Felder', 'Wählen Sie die Formularfelder aus, die, wenn sie den definierten Wert enthalten, das aktuelle Feld zum Pflichtfeld machen. Wenn für ein übergeordnetes Feld mehrere Bedingungen angegeben sind, wird geprüft, ob mindestens eine davon zutrifft (OR Verknüpfung).');
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryValidationRule'] = array('Validierungsregel', 'Wählen Sie wie die übergeordneten Felder befüllt sein müssen, um dieses Feld zum Pflichtfeld zu machen.');
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryEmpty']          = array('Feld muss leer sein wenn Validierungsregel nicht erfüllt', 'Wählen Sie ob das Feld leer sein muss, wenn die Validierungsregel nicht erfüllt ist.');

// mcw fields
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldName']      = array('Formularfeld', 'Wählen Sie das Formularfeld aus.');
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldCondition'] = array('Bedingung', 'Wählen Sie die Bedingung für die Feldvalidierung.');
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldValue']     = array('Wert', 'Legen Sie den Wert fest, der bei der Validierung überprüft werden soll. Als Platzhalter für einen beliebigen Feldwert kann \'*\' (Stern) verwendet werden.');

// legends
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatory_legend'] = "Abhängiges Pflichtfeld";

// fields
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryValidationRuleOptions']['0'] = 'Mindestens 1 Feld muss befüllt sein.';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryValidationRuleOptions']['1'] = 'Alle Felder müssen befüllt sein.';

// options
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['eq'] = '= (gleich)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['ne'] = '!= (ungleich)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['lt'] = '< (kleiner)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['le'] = '<= (kleiner oder gleich)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['gt'] = '> (größer)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['ge'] = '>= (größer oder gleich)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFieldOptions']['lk'] = 'LIKE (ähnlich)';
 
?>