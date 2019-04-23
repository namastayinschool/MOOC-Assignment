<?php 
abstract class PageControllerAbstract
{
	/**
	 * The controller's model (data access layer)
	 * @var ModelInterface
	 */
	protected $_model = null;
	
	/**
	 * The controller's template (view layer)
	 * @var TemplateInterface
	 */
	protected $_tpl = null;
	
	/**
	 * Factory method responsible for creating the appropriate
	 * model object for the page controller. Sets the internal
	 * property $_model to the created model object. This method
	 * should be called by the constructor of the concrete class
	 */
	protected function _makeModel($modelClassName='')
	{
		/**
		 * Set the name of the model object class to be created. By
		 * default it appends the word 'Model' to the existing class' name
		 * @var string
		 */
		$modelObjClass = empty($modelClassName) ? __CLASS__ . 'Model' : $modelClassName;
		
		/**
		 * Set the internal property with the created model.
		 * @var ModelInterface
		 * @see ModelFactory
		 */
		$this->_model = ModelFactory::makeModel($modelObjClass);	
	}
	
	/**
	  * Checking the permissions using a user-defined authorization method
	  */
	 public function userIsPermitted(UserAbstract $user, $pageName)
	 {
	 	$authorizer = new Authorization();
	 	return $authorizer->checkUserPerms($user, $pageName);
	 }
	
	/**
	 * The method for configuring the appropriate
	 * template object for the page controller. Sets the internal
	 * property $_tpl to the created template object. It uses
	 * the concrete Template class and configures it so that it uses
	 * the right plugins, and template files for the page controller. This means
	 * that separate template classes are not required.
	 * This method should be called by the constructor of the concrete class
	 */
	abstract protected function _makeTpl();
	
	
	/**
	 * The method that determines what actions to perform based on the request and
	 * which methods should be used to fulfill the request
	 */
	abstract public function run();
}
