<?php 
class Profile extends PageControllerAbstract
{

	protected $_tpl = null;
	protected $_errors = array();

	public function __construct() 
	{
		$this->_makeTpl();
		$this->_makeModel('ProfileModel');
	}

	protected function _makeTpl()
	{
		$this->_tpl = new Template('Profile.tpl.php');
		$this->_tpl->setDir(APP_TEMPLATES);
	}
	
	public function run()
	{
	    /** @var User $user */
	    $user = User::getUserSingleton();

	    if (!$user->isIdSet()) {
	        header('Location: index.php?controller=Login');
	        die;
        }

	    $this->_tpl->assign('courses', $this->_model->getAllRecords());

		$this->_tpl->display();
	}
}
