<?php 
class AuthModel implements ModelSelectInterface, ModelInsertInterface
{
	private	$_errors = null;
	private	$_result = null;
	private	$_data = array();
	private $_mysqli = null;
		
	use TraitDatabaseConnector;
	
	public function getOneRecord(array $identifiers){
		$row = null;
		
		$email = $this->_mysqli->real_escape_string($identifiers['email']);
		$password = $this->_mysqli->real_escape_string($identifiers['password']);

		$sql = 'SELECT u.name AS fullname, u.email 
                  FROM users u 
                 WHERE u.email = \'' . $email . '\'
                   AND u.password = MD5(\'' . $password . '\')';
				  
		$this->_result = $this->_mysqli->query($sql);

		if (!$this->_result) {
			die('There was an error running the query [' . $this->_mysqli->error . ']');
		}
		if ($this->_result->num_rows != 1) {
			return false;
		}
		else {
			return ($this->_result->fetch_assoc());
		}
	}


	//Retrieve the records from a table

	public function getAllRecords() { }

	public function newRecord(array $recordInfo)
    {
        $email = $this->_mysqli->real_escape_string($recordInfo['email']);
        $password = $this->_mysqli->real_escape_string($recordInfo['password']);
        $fullname = $this->_mysqli->real_escape_string($recordInfo['fullname']);

        $sql = 'SELECT * FROM users WHERE email = \'' .  $email . '\'';

        $this->_result = $this->_mysqli->query($sql);

        if (!$this->_result || $this->_result->num_rows > 0) {
            return false;
        }

        $sql = 'INSERT INTO users (name, email, password) VALUES (\'' . $fullname . '\', \'' . $email . '\', MD5(\'' . $password . '\'))';

        $this->_result = $this->_mysqli->query($sql);

        if (!$this->_result) {
            die('There was an error running the query [' . $this->_mysqli->error . ']');
        }

        return true;
    }

}