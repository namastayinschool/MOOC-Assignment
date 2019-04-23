<?php 
/**
 * COMP3170 - Web Based Applications
 * Describes the methods that must be part of every model in the applicationDescribes the methods that must be part of every model in the application
 * @package COMP3170
 * @subpackage ModelInterface
 */
interface ModelDeleteInterface extends ModelInterface
{
	/**
	 * Deletes the record that has the id specified by the parameter
	 * $recordId. Returns false if the deletion fails for any reason,
	 * otherwise, it returns true.
	 *
	 * @param string	$recordId
	 */
	public function deleteRecord($recordId);
	
	
	/**
	 * Deletes the records that has the id specified by the array parameter
	 * $recordIds, which should be an associative array.
	 * Returns false if the deletion fails for any reason,
	 * otherwise, it returns true.
	 *
	 * @param array	$recordIds
	 */
	public function deleteRecords(array $recordIds);
	
	
}
?>
