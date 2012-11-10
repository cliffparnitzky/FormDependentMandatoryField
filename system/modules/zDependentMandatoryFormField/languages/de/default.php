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
 * Error messages
 */
$GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorMandatory']['Single']   = 'Das Feld "%s" muss ausgefüllt sein, weil das Feld "%s" einen Wert enthält.';
$GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorMandatory']['Multiple'] = 'Das Feld "%s" muss ausgefüllt sein, weil die Felder "%s" Werte enthalten.';
$GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorEmpty']['Single']       = 'Das Feld "%s" muss leer sein, weil das Feld "%s" keinen Wert enthält.';
$GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorEmpty']['Multiple']     = 'Das Feld "%s" muss leer sein, weil die Felder "%s" keine Werte enthalten.';

?>