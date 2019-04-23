<?php

class StreamsModel implements ModelSelectInterface
{
    private $_errors = null;
    private $_result = null;
    private $_data = array();
    private $_mysqli = null;

    use TraitDatabaseConnector;

    public function getOneRecord(array $identifiers)
    {

    }

    // retrieve all records from table
    public function getAllRecords()
    {
        $sql = 'SELECT s.stream_id, s.stream_name, s.stream_image, i.instructor_name
                  FROM streams s
            INNER JOIN stream_instructor si ON s.stream_id = si.stream_id
            INNER JOIN instructors i ON si.instructor_id = i.instructor_id
			  ORDER BY s.stream_name ASC
				 LIMIT 12';

        $this->_result = $this->_mysqli->query($sql);

        if (!$this->_result) {
            die('There was an error running the query [' . $this->_mysqli->error . ']');
        }

        return $this->_result->fetch_all(MYSQLI_ASSOC);
    }
}