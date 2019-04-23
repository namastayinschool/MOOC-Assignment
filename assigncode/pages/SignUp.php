<?php

class SignUp extends PageControllerAbstract
{

    protected $_tpl = null;
    protected $_errors = array();

    public function __construct()
    {
        $this->_makeTpl();
        $this->_makeModel('AuthModel');
    }


    protected function _makeTpl()
    {
        $this->_tpl = new Template('SignUp.tpl.php');
        $this->_tpl->setDir(APP_TEMPLATES);
    }

    public function run()
    {
        /** @var User $user */
        $user = User::getUserSingleton();
        if ($user->isIdSet()) {
            header('Location:index.php?controller=Profile');
            die;
        }

        if ($_POST) {
            // create a validator for this page
            $validator = Validator::makeValidatorSingleton();

            // validate the data and stop processing if the
            // data is in the incorrect format
            $allVars = $ini_array = parse_ini_file(INCLUDE_DIR . '/dataLibrary.ini', true);
            $pageVars = array();

            foreach ($allVars as $vars => $varDetails) {
                if (in_array('SignUp', $varDetails['inpage'])) {
                    $pageVars[$vars] = $varDetails;
                }
            }
            if (!$validator->isRequestDataValid($_POST, $pageVars)) {
                $this->_errors = $validator->getValidationErrors();
            }
            if (isset($_POST['password']) && $_POST['password'] !== $_POST['re_password']) {
                $this->_errors[] = 'Passwords don\'t match!';
            }
            if (!$this->_errors) {
                if (!$this->_model->newRecord($_POST)) {
                    $this->_errors[] = 'Email address already registered!';
                } else {
                    header('Location: index.php?controller=Login&registered');
                    die;
                }
            }
        }

        // if errors or not, display the login page
        if ($this->_errors) {
            $this->_tpl->assign('errors', $this->_errors);
        }
        $this->_tpl->display();
    }
}
