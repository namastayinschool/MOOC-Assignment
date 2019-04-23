<?php

class ProfileModel implements ModelSelectInterface
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
        /** @var User $user */
        $user = User::getUserSingleton();

        if (!$user->isIdSet()) return false;

        $email = $this->_mysqli->real_escape_string($user->getId());

        $sql = 'SELECT c.course_id, c.course_name, c.course_image, i.instructor_name, MIN(f.faculty_dept_name) AS faculty_dept_name
                  FROM courses c
            INNER JOIN user_courses uc ON uc.course_id = c.course_id
            INNER JOIN users u ON uc.email = u.email
            INNER JOIN course_instructor ci ON c.course_id = ci.course_id
            INNER JOIN instructors i ON ci.instructor_id = i.instructor_id
            INNER JOIN faculty_dept_courses fdc ON fdc.course_id = c.course_id
            INNER JOIN faculty_department f ON fdc.faculty_dept_id = f.faculty_dept_id
                 WHERE u.email = "' . $email . '"  
              GROUP BY c.course_id
			  ORDER BY c.course_name ASC
				 LIMIT 8';

        $this->_result = $this->_mysqli->query($sql);

        if (!$this->_result) {
            die('There was an error running the query [' . $this->_mysqli->error . ']');
        }

        return $this->_result->fetch_all(MYSQLI_ASSOC);
    }
}