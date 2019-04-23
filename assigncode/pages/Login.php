<?php

class Login extends PageControllerAbstract
{

    protected $_tpl = null;
    protected $_errors = array();

    public function __construct()
    {
        $this->_makeTpl();
    }


    protected function _makeTpl()
    {
        $this->_tpl = new Template('Login.tpl.php');
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
                if (in_array('Login', $varDetails['inpage'])) {
                    $pageVars[$vars] = $varDetails;
                }
            }
            if (!$validator->isRequestDataValid($_POST, $pageVars)) {
                $this->_errors = $validator->getValidationErrors();
            } else {
                // if the data is fine, create the user and perform authentication
                $user = User::getUserSingleton();
                $user->init($_POST);
                if ($user->isIdSet()) {
                    header('Location:index.php?controller=Profile');
                    return;
                } else {
                    $this->_errors[] = $user->getError();
                }
            }
        }

        if (isset($_GET['registered'])) {
            $this->_tpl->assign('message', 'Successfully registered. Please enter your email and password!');
        }

        // if errors or not, display the login page
        if ($this->_errors) {
            $this->_tpl->assign('errors', $this->_errors);
        }
        $this->_tpl->display();
    }
}
