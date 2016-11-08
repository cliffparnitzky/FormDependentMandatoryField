<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2016 Leo Feyer
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
 * @copyright  Cliff Parnitzky 2012-2016
 * @author     Cliff Parnitzky
 * @package    FormDependentMandatoryField
 * @license    LGPL
 */

/**
 * Error messages
 */
$GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorMandatory']['Single']   = 'The field "%s" must not be empty, because the field "%s" contains a value.';
$GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorMandatory']['Multiple'] = 'The field "%s" must not be empty, because the fields "%s" contain values.';
$GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorEmpty']['Single']       = 'The field "%s" must be empty, because the field "%s" contains no value.';
$GLOBALS['TL_LANG']['ERR']['dependentMandatoryErrorEmpty']['Multiple']     = 'The field "%s" must be empty, because the fields "%s" contain no values.';

?>