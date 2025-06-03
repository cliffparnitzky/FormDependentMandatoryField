<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2025 Leo Feyer
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
 * PHP version 8
 * @copyright  Cliff Parnitzky 2012-2025
 * @author     Cliff Parnitzky
 * @package    FormDependentMandatoryField
 * @license    LGPL
 */

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['validateFormField'][] = array("\CliffParnitzky\FormDependentMandatoryField\FormDependentMandatoryField", 'validateDependentMandatoryField');
$GLOBALS['TL_HOOKS']['loadFormField'][]     = array("\CliffParnitzky\FormDependentMandatoryField\FormDependentMandatoryField", 'loadDependentMandatoryField');

/**
 * Define explicitly excluded and included widget types
 */
$GLOBALS['TL_FDMF']['EXCLUDED_WIDGET_TYPES'] = array('fineUploader');
$GLOBALS['TL_FDMF']['INCLUDED_WIDGET_TYPES'] = array('textdigit');
