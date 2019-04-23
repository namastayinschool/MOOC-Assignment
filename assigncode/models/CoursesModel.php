<?php

class CoursesModel implements ModelSelectInterface, ModelDeleteInterface, ModelInsertInterface
{
    private $_errors = null;
    private $_result = null;
    private $_data = array();
    private $_mysqli = null;

    use TraitDatabaseConnector;

    public function getOneRecord(array $identifiers)
    {
        $id = $this->_mysqli->real_escape_string($identifiers['id']);

        $sql = 'SELECT c.course_id, c.course_name, c.course_image, i.instructor_name, MIN(f.faculty_dept_name) AS faculty_dept_name
                  FROM courses c
            INNER JOIN course_instructor ci ON c.course_id = ci.course_id
            INNER JOIN instructors i ON ci.instructor_id = i.instructor_id
            INNER JOIN faculty_dept_courses fdc ON fdc.course_id = c.course_id
            INNER JOIN faculty_department f ON fdc.faculty_dept_id = f.faculty_dept_id
                 WHERE c.course_id = \'' . $id . '\'
              GROUP BY c.course_id
				 LIMIT 1';
        $this->_result = $this->_mysqli->query($sql);

        if (!$this->_result) {
            die('There was an error running the query [' . $this->_mysqli->error . ']');
        }
        if ($this->_result->num_rows != 1) {
            return false;
        } else {
            return ($this->_result->fetch_assoc());
        }
    }

    // retrieve all records from table
    public function getAllRecords()
    {
        $sql = 'SELECT c.course_id, c.course_name, c.course_image, i.instructor_name, MIN(f.faculty_dept_name) AS faculty_dept_name
                  FROM courses c
            INNER JOIN course_instructor ci ON c.course_id = ci.course_id
            INNER JOIN instructors i ON ci.instructor_id = i.instructor_id
            INNER JOIN faculty_dept_courses fdc ON fdc.course_id = c.course_id
            INNER JOIN faculty_department f ON fdc.faculty_dept_id = f.faculty_dept_id
              GROUP BY c.course_id
			  ORDER BY c.course_name ASC
				 LIMIT 25';

        $this->_result = $this->_mysqli->query($sql);

        if (!$this->_result) {
            die('There was an error running the query [' . $this->_mysqli->error . ']');
        }

        return $this->_result->fetch_all(MYSQLI_ASSOC);
    }

    // get the user's courses
    public function getUserCourses($email)
    {
        $email = $this->_mysqli->real_escape_string($email);

        $sql = 'SELECT course_id
                  FROM user_courses uc 
                 WHERE uc.email = \'' . $email . '\'
                 LIMIT 9';

        $this->_result = $this->_mysqli->query($sql);

        if (!$this->_result) {
            die('There was an error running the query [' . $this->_mysqli->error . ']');
        }

        $res = $this->_result->fetch_all(MYSQLI_NUM);
        $result = array();
        foreach ($res as $num => $id) {
            $result[] = $id[0];
        }
        return $result;

    }

    public function deleteRecord($recordId)
    {
    }

    public function deleteRecords(array $recordIds)
    {
    }

    public function newRecord(array $recordInfo)
    {
        $email = $this->_mysqli->real_escape_string($recordInfo['email']);
        $id = $this->_mysqli->real_escape_string($recordInfo['id']);

        $sql = 'INSERT INTO user_courses (email, course_id) VALUES (\'' . $email . '\', \'' . $id . '\')';

        $this->_result = $this->_mysqli->query($sql);

        if (!$this->_result) {
            die('There was an error running the query [' . $this->_mysqli->error . ']');
        }

        return true;
    }

    public function deleteUserCourse($id, $email)
    {
        $email = $this->_mysqli->real_escape_string($email);
        $id = $this->_mysqli->real_escape_string($id);

        $sql = 'DELETE FROM user_courses WHERE email = \'' . $email . '\' AND course_id = \'' . $id . '\'';

        $this->_result = $this->_mysqli->query($sql);

        if (!$this->_result) {
            die('There was an error running the query [' . $this->_mysqli->error . ']');
        }

        return true;
    }


}