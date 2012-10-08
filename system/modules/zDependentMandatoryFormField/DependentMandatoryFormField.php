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
class DependentMandatoryFormField extends Backend
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
		$this->import('Input');
	}
	 
	/**
	 * Execute Hook: loadFormField to add special classes
	 */
	public function loadDependentMandatoryFormField(Widget $objWidget, $strFormId, $arrData)
	{
		if ($objWidget->dependentMandatoryActive) {
			$objWidget->class = "dependent";
			$objWidget->required = true;
		}
		return $objWidget;
	}
	
	/**
	 * Execute Hook: validateFormField to check if the dependent form field is valid
	 */
	public function validateDependentMandatoryFormField(Widget $objWidget, $strFormId, $arrData)
	{
		if ($objWidget->dependentMandatoryActive) {
			/*$arrDependentMandatorySuperiorFields = deserialize($objWidget->dependentMandatorySuperiorFields);
			// will be null, if the record is new
			// in the other case the fields of this record must be excluded while duplication checking
			$dataRecordId = $this->Input->get($this->getFormdataDetailsKey());
			
			$arrParams = array();
			$arrParams[] = $arrData['id'];
			foreach ($arrDuplicationCheckingFields as $fieldName) {
				$arrParams[] = trim($this->Input->postRaw($fieldName));
			}
			
			if (strlen($dataRecordId) > 0) {
				$arrParams[] = $dataRecordId;
			}

			$records = $this->Database->prepare($this->buildQueryString($arrDuplicationCheckingFields, $dataRecordId))->execute($arrParams);
			if ($records->next()) {
				$fields = array();
				foreach ($arrDuplicationCheckingFields as $fieldName) {
					$dbField = $fieldName . "_label";
					$fields[] = $records->$dbField;
				}
			
				$objWidget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['dependentMandatoryError'], implode(", ", $fields)));*/
		}
		return $objWidget;
	}

	/**
	 * build the sql query
	 */
	private function buildQueryString ($arrDuplicationCheckingFields, $dataRecordId) {
		$queryString = "SELECT ";
		
		$fields = array();
		foreach ($arrDuplicationCheckingFields as $fieldName) {
			$fields[] = "fdd_" . $fieldName . ".ff_label as " . $fieldName . "_label ";
		}
		
		$queryString .= implode(", ", $fields);
		$queryString .= "FROM tl_form f ";
		
		$queryString .= "JOIN tl_formdata fd ON fd.form = f.title ";
		
		foreach ($arrDuplicationCheckingFields as $fieldName) {
			$queryString .= "JOIN tl_formdata_details fdd_" . $fieldName . " ON fdd_" . $fieldName . ".pid = fd.id ";
		}
		
		$queryString .= "WHERE f.id = ? ";
		
		foreach ($arrDuplicationCheckingFields as $fieldName) {
			$queryString .= "AND fdd_" . $fieldName . ".ff_name = '" . $fieldName . "' AND fdd_" . $fieldName . ".value = ? ";
		}
		
		if (strlen($dataRecordId) > 0) {
			$queryString .= "AND NOT fd.id = ? ";
		} 
		$queryString .= "ORDER BY fd.tstamp DESC";
		
		return $queryString;
	}
	
	/**
	 * Return all possible form fields as array
	 * @return array
	 */
	public function getAllInputFormFields(DataContainer $dc)
	{
		$fields = array();
		
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		// Get all form fields which can be used
		$objFields = $this->Database->prepare("SELECT name,label,type FROM tl_form_field WHERE pid = ? AND NOT id = ? ORDER BY name ASC")
							->execute(array($intPid, $this->Input->get('id')));

		while ($objFields->next())
		{
			$strClass = $GLOBALS['TL_FFL'][$objFields->type];

			// Continue if the class is not defined
			if (!$this->classFileExists($strClass))
			{
				continue;
			}
			
			// Continue if the class is not an input submit
			$widget = new $strClass;
			if (!$widget->submitInput()) {
				continue;
			}
			
			$name = $objFields->name;
			$label = $objFields->label;
			$fields[$name] = strlen($label) ? $label.' ['.$name.']' : $name;
		}

		return $fields;
	}
	
	private function getFormdataDetailsKey ()
	{
		$strFormdataDetailsKey = 'details';

		// get params of related listing formdata
		$intListingId = intval($_SESSION['EFP']['LISTING_MOD']['id']);
		if ($intListingId)
		{
			$objListing = $this->Database->prepare("SELECT efg_DetailsKey FROM tl_module WHERE id = ?")
								->execute($intListingId);
			if ($objListing->numRows)
			{
				$arrListing = $objListing->fetchAssoc();
			}
		}

		if (strlen($arrListing['efg_DetailsKey']))
		{
			$strFormdataDetailsKey = $arrListing['efg_DetailsKey'];
		}
		
		return $strFormdataDetailsKey;
	}
}

?>