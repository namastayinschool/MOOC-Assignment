<?php 
class Home extends PageControllerAbstract
{

	protected $_tpl = null;
	protected $_errors = array();

	public function __construct() 
	{
		$this->_makeTpl();
		$this->_makeModel('HomeModel');
	}
	
	
	protected function _makeTpl()
	{
		$this->_tpl = new Template('Home.tpl.php');
		$this->_tpl->setDir(APP_TEMPLATES);
	}
	
	public function run()
	{
	    $this->_tpl->assign('pop_courses', $this->_model->getPopCourses());
	    $this->_tpl->assign('rec_courses', $this->_model->getRecCourses());

		$this->_tpl->display();
	}
}
