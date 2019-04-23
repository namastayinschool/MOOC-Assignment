<?php
/**
 * Front controller index.php
 */

// include the application configuration file and the autoloader
require_once '../assigncode/include/configure.php';
require_once '../assigncode/include/autoloader.php';


// reset the application by killing the session in case things go wrong
if (isset($_GET['reset'])) {
    Session::endSession();
}

// start a new session
Session::startSession();

// create a user singleton object
$validator = Validator::makeValidatorSingleton();

// use the validator to validate the page name to ensure it only contains alphabetic characters
$pageName = isset($_GET['controller']) && !empty($_GET['controller']) && $validator->isPageNameValid($_GET['controller']) ? $_GET['controller'] : 'Home';

// use a page controller factory object
$pageController = PageControllerFactory::makePageController($pageName);

// display output by calling the page object's run method
$pageController->run();