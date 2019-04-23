<?php

class HomeModel implements ModelSelectInterface
{
    private $_errors = null;
    private $_result = null;
    private $_data = array();
    private $_mysqli = null;

    use TraitDatabaseConnector;

    public function getOneRecord(array $identifiers)
    {

    }

    // get all records from the table
    public function getAllRecords()
    {

    }

   // get popular courses
    public function getPopCourses()
    {
        $sql = 'SELECT c.course_id, c.course_name, c.course_image, i.instructor_name 
                  FROM courses c
            INNER JOIN course_instructor ci ON c.course_id = ci.course_id
            INNER JOIN instructors i ON ci.instructor_id = i.instructor_id
			  ORDER BY c.course_access_count DESC
				 LIMIT 8';

        $this->_result = $this->_mysqli->query($sql);

        if (!$this->_result) {
            die('There was an error running the query [' . $this->_mysqli->error . ']');
        }

        return $this->_result->fetch_all(MYSQLI_ASSOC);
    }

    // get recommended courses
    public function getRecCourses()
    {
        $sql = 'SELECT c.course_id, c.course_name, c.course_image, i.instructor_name 
                  FROM courses c
            INNER JOIN course_instructor ci ON c.course_id = ci.course_id
            INNER JOIN instructors i ON ci.instructor_id = i.instructor_id
			  ORDER BY c.course_recommendation_count DESC
				 LIMIT 8';

        $this->_result = $this->_mysqli->query($sql);

        if (!$this->_result) {
            die('There was an error running the query [' . $this->_mysqli->error . ']');
        }

        return $this->_result->fetch_all(MYSQLI_ASSOC);

    }
}