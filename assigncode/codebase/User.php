<?php
// this class implements the UserAbstractClass
class User extends UserAbstract
{
    private static $_singleton_class = __CLASS__;

    public function init(array $input)
    {
        $this->_userdata = array(
            'fullname' => '',
            'email' => ''
        );

        // APPLICATION LOGIC FOR THE REGISTRATION PAGE
        //@var AuthModel $authModel
        $authModel = ModelFactory::makeModel('AuthModel');
        //authenticate user
        $auth = $authModel->getOneRecord(array('email' => $input['email'], 'password' => $input['password']));

        if (!$auth) {
            $this->_setError('Error: Invalid email or password!');
        } else {
            //store any user-specific data
            $this->setData($auth);

            if ($this->getData('email')) {
                $this->_setId($this->getData('email'));
            }
            Session::write($this::$_singleton_class, $this);
        }
    }

    public static function getUserSingleton()
    {
        if (!isset(self::$_instance)) {
            $saved = Session::read(self::$_singleton_class);
            if (null === $saved) {
                self::$_instance = new self::$_singleton_class;
                Session::write(self::$_singleton_class, self::$_instance);
            } else {
                self::$_instance = $saved;
            }
        }

        return self::$_instance;
    }


}