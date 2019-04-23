<?php 
/**
 * COMP3170 - Web Based Applications
 * Describes the methods that must be part of every model in the applicationDescribes the methods that must be part of every model in the application
 * @package COMP3170
 * @subpackage ModelInterface
 */
interface ModelSelectInterface extends ModelInterface
{
	/**
	 * Retrieves all the records from the database
	 */
	public function getAllRecords();
	

	/**
	 * Retrieves the record that has the identifiers specified by the parameter
	 * $identifiers. Returns the record as an array if successful, otherwise
	 * it returns false.
	 *
	 * @param array $identifiers
	 * @return array | false
	 */
	public function getOneRecord(array $identifiers);
}
?>
