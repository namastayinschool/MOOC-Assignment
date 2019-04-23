<?php 
/**
 * COMP3170 - Web Based Applications
 * Describes the methods that must be part of every model in the applicationDescribes the methods that must be part of every model in the application
 * @package COMP3170
 * @subpackage ModelInterface
 */
interface ModelUpdateInterface extends ModelInterface
{
	
	/**
	 * Updates the record with id recordId (default NULL) with the information passed by 
	 * in the $recordInfo parameter. The record id can be stored in the $recordInfo
	 * array if desired or passed in the recordId parameter.
	 * Returns false if the update fails for any reason, otherwise, it returns true.
	 *
	 * @param string $recordId
	 * @param array  $recordInfo
	 * @return true | false
	 */
	public function updateRecord($recordId=NULL, array $recordInfo);
	
	
	/**
	 * Updates multiple records with ids stored in the recordId array with the information passed by 
	 * in the $recordInfo parameter. The record id can be stored in the $recordInfo
	 * array if desired or passed in the recordId parameter.
	 * Returns false if the update fails for any reason, otherwise, it returns true.
	 *
	 * @param string $recordId
	 * @param array  $recordInfo
	 * @return true | false
	 */
	public function updateRecords(array $recordId, array $recordInfo);
	
	
	
}
?>
