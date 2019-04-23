<?php 
class Streams extends PageControllerAbstract
{

	protected $_tpl = null;
	protected $_errors = array();

	public function __construct() 
	{
		$this->_makeTpl();
		$this->_makeModel('StreamsModel');
	}
	
	
	protected function _makeTpl()
	{
		$this->_tpl = new Template('Streams.tpl.php');
		$this->_tpl->setDir(APP_TEMPLATES);
	}
	
	public function run()
	{
	    $this->_tpl->assign('streams', $this->_model->getAllRecords());

		$this->_tpl->display();
	}
}
