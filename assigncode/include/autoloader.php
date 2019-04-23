<?php
/**
 * The autoload magic method implementation for the framework.
 * It checks for classes, interfaces and abstract classes defined in the framework first. Then
 * it searches the pages and models directories. If they are not found there, it triggers an error. 
 * 
 * The autoloader assumes that the class name is the same as the script's file name.
 * To ensure the right class is found the model and pages should have a unique prefix or suffix to the file and class name.
 * For example, a page controller class could be named UserPgController, it's script file: UserPgController.php; it's
 * model: MemberModel and the model script file MemberModel.php. 
 * @param string $name  The class, abstract class or interface to load
 */				
function __autoload($name)
{
	$searchOrder = array(
       	    FRAMEWORK_DIR . DIRECTORY_SEPARATOR . $name . '.php',
            APP_PAGES . DIRECTORY_SEPARATOR . $name . '.php',
            APP_MODELS . DIRECTORY_SEPARATOR . $name . '.php',
            APP_CLASSES . DIRECTORY_SEPARATOR . $name . '.php',
    );
    
    foreach ($searchOrder as $file) {
    	if (file_exists($file)) {
    		require_once($file);
			return;
    	}
    }
	trigger_error('Cannot load the class, interface, trait or abstract class ' . $file, E_USER_ERROR);
}
