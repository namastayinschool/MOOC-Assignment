<?php
trait traitDatabaseConnector
{	
	public function __construct()
	{
		$this->doDatabaseConnect(array( 'host' => DB_HOST,
										'username' => DB_USERNAME,
										'password' => DB_PASS,
										'database' => DB_SELECT ));
	}
	
	/**
	 * Connects to the database using the information passed in the $connectInfo
	 * parameter. Returns false if it fails, or returns the link if it
	 * succeeds
	 *
	 * @param array $connectInfo
	 * @return resource | false
	 */
	protected function doDatabaseConnect(array $connectInfo)
	{
		$this->_mysqli = new mysqli($connectInfo['host'], 
									$connectInfo['username'],
									$connectInfo['password'],
									$connectInfo['database']);
		
		if ($this->_mysqli->connect_errno) {
			die('Failed to connect to MySQL: <b>'. $this ->_mysqli->connect_errono. '</b>');
		}
	}
	
}