<?php
class PageControllerFactory implements PageControllerFactoryInterface
{

	/**
	 * Creates the Page controller object that acts as the business logic layer.
	 * Trigger a fatal error if the class is invalid or not found
	 * @param string $pageName
	 * @todo Student to implement
	 */
	public static function makePageController($pageName) 
	{
		/**
		 * Stores the pageController object that the method creates
		 * @var PageControllerAbstract
		 */
		$pgControllerClass = null;
		
		// ensure the model class name is indeed a string
		ValidatorAbstract::ensureParameterIsString($pageName);
		
		// ...and ensure it is not empty
		ValidatorAbstract::ensureParameterNotEmpty($pageName);
		
		// Verify the model object class is valid class before creating it
		$filePath = APP_PAGES . DIRECTORY_SEPARATOR . "$pageName.php";
		if ( file_exists( $filePath ) ) {
			if ( class_exists( $pageName) ) {
				// create the new page controller object using the Reflection API
				$pageControllerClass = new ReflectionClass($pageName);
				if ( $pageControllerClass->isSubClassOf( 'PageControllerAbstract' ) ) {
					return $pageControllerClass->newInstance();
				}
				else {
					trigger_error('Invalid object used. Must be a PageControllerAbstract object', E_USER_ERROR);
					return FALSE;
				}
			}
		}
		trigger_error('No file exists for the PageController class ' . $filePath, E_USER_ERROR);
		return false;				
	}
}