<?php

class Courses extends PageControllerAbstract
{
    /**
     * @var Template
     */
    protected $_tpl = null;

    /**
     * @var CoursesModel
     */
    protected $_model = null;

    protected $_errors = array();

    public function __construct()
    {
        $this->_makeTpl();
        $this->_makeModel('CoursesModel');
    }


    protected function _makeTpl()
    {
        $this->_tpl = new Template('Courses.tpl.php');
        $this->_tpl->setDir(APP_TEMPLATES);
    }

    public function run()
    {
        /** @var User $user */
        $user = User::getUserSingleton();
        if (isset($_GET['add']) && !empty($_GET['add'])) {
            if (!$user->isIdSet()) {
                header('Location: index.php?controller=Login');
                die;
            }
            $course = $this->_model->getOneRecord(array('id' => $_GET['add']));
            if (!$course) {
                die ('Course not found!');
            }

            $user_courses = $this->_model->getUserCourses($user->getId());

            if (count($user_courses) >= 8) {

                $this->_tpl->assign('message', 'ERROR: Maximum number of courses exceeded. Please go to your profile and remove a course before registering for another.');

            } elseif (in_array($course['course_id'], $user_courses)) {

                $this->_tpl->assign('message', 'ERROR: You have already registered for this course!');

            } elseif ($this->_model->newRecord(array('id' => $course['course_id'], 'email' => $user->getId()))) {

                $this->_tpl->assign('message', 'This code has been added to your profile.');

            } else {

                $this->_tpl->assign('message', 'Error registering for this course!');
            }

            $this->_tpl->assign('course', $course);
            $this->_tpl->display('AddCourse.tpl.php');

        } elseif (isset($_GET['delete']) && !empty($_GET['delete'])) {
            if (!$user->isIdSet()) {
                header('Location: index.php?controller=Login');
                die;
            }
            $course = $this->_model->getOneRecord(array('id' => $_GET['delete']));
            if (!$course) {
                die ('Course not found!');
            }

            if (isset($_GET['confirm'])) {
                $this->_model->deleteUserCourse($course['course_id'], $user->getId());
                $this->_tpl->display('UnenrollConfirmed.tpl.php');
            } else {
                $this->_tpl->assign('course', $course);
                $this->_tpl->display('QuestionUnenroll.tpl.php');
            }

        } else {

            $this->_tpl->assign('courses', $this->_model->getAllRecords());

            $this->_tpl->display();
        }
    }
}
