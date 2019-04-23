<?php 
/**
 * COMP3170 - Web Based Applications
 * Describes the methods that must be part of every model in the applicationDescribes the methods that must be part of every model in the application
 * @package COMP3170
 * @subpackage ModelInterface
 */
interface ModelInsertInterface extends ModelInterface
{
	/**
	 * Inserts the information passed by the $recordInfo parameter into the
	 * database. Returns false if the insertion fails for any reason, otherwise
	 * it returns true
	 *
	 * @param array $recordInfo
	 * @return false|true
	 */
	public function newRecord(array $recordInfo);
	
	
}
?>
