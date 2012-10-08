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
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatoryActive']         = array('Abhängiges Pflichtfleld aktivieren', 'Das Feld muss zum Abschicken des Formulars ausgefüllt werden, wenn ein übergeordnetes Feld einen Wert enthält.');
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatorySuperiorFields'] = array('Übergeordnete Felder', 'Wählen Sie die Felder des Formulars aus, die, wenn sie einen Wert enthalten, das aktuelle Feld zum Pflichtfeld machen.');

// legends
$GLOBALS['TL_LANG']['tl_form_field']['dependentMandatory_legend'] = "Abhängiges Pflichtfeld";
 
?>
