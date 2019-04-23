<?php 
class Session
{
	private static $_sess = 'app';	// stores the session name
	
	public static $counter = 0;

	/**
	 * Do not invoke the constructor since the session object is
	 * just static methods. Don't allow children to create their
	 * own constructor either
	 */
	final private function __construct() {}
	
	/**
	 * Do not allow cloning. Unnecessary for a session as far
	 * as seen
	 */
	private function __clone() {}
	
	
	/**
	 * Start the session and make the session container
	 */
	public static function startSession()
	{		
		session_start();
		if (!isset($_SESSION[self::$_sess])) {
			$_SESSION[self::$_sess] = array();	
		}
		else {
			self::$counter++;
			session_regenerate_id();	// get a new session id everytime a request is made		
		}
	}
	

	public static function getSessionCount()
	{
		return self::$counter;
	}
	
	
	/**
	 * Retrieves the container name
	 */
	static public function getSessionContainer()
	{
		return self::$_sess;
	}
	
	/**
	 * End the session. Used when logging out the user
	 */
	public static function endSession()
	{
   		setcookie(session_name(), '', time() - 42000,'/');
		session_destroy();
	}
	
	
	/**
	 * Changes the session name. Useful for compartmentalizing
	 * session variables 
	 * @param string $sess_name
	 */
	static public function changeSessionContainer($sess_name)
	{
		if (!empty($sess_name)) {
			self::$_sess = $sess_name;
		}
	}
	
	/**
	 * Store the variable in the session
	 * @param string $name
	 * @param mixed $value
	 */
	static public function write($name, $value)
	{
		ValidatorAbstract::ensureParameterNotEmpty($name);
		
		if (!ValidatorAbstract::isVariableNameValid($name)) {
			trigger_error('Session::write() Invalid variable name', E_USER_ERROR);
			exit;
		}
		else {
			$_SESSION[self::$_sess][$name] = $value;
		}		
	}
	
	/**
	 * Retrieve the variable from the session
	 * @param unknown_type $name
	 */
	static public function read($name)
	{
		ValidatorAbstract::ensureParameterNotEmpty($name);
		
		if (!ValidatorAbstract::isVariableNameValid($name)) {
			trigger_error('Invalid variable name received', E_USER_ERROR);
			exit;
		}
		else {
			if (isset($_SESSION[self::$_sess][$name]))
				return $_SESSION[self::$_sess][$name];
			else 
				return null;
		}		
	}
	
	/**
	 * Clear the variable from session management
	 * @param unknown_type $name
	 */
	static public function clear($name)
	{
		if (!ValidatorAbstract::isVariableNameValid($name)) {
			trigger_error('Session::clear() Invalid variable name', E_USER_ERROR);
			exit;
		}
		else {
			unset($_SESSION[self::$_sess][$name]);
		}		
	}
	
	/**
	 * Place multiple variables under session management
	 * @param array $vars
	 */
	static public function mwrite(array $vars)
	{
		if (empty($vars)) {
			trigger_error('Session::mwrite() Invalid variable name', E_USER_ERROR);
			exit;
		}
		else {
			foreach ($vars as $k=>$v) {
				if (!ValidatorAbstract::isVariableNameValid($k)) {
					trigger_error('Session::mwrite() Invalid session variable name: ' . $k, E_USER_ERROR);
					exit;
				}
				else {
					$_SESSION[self::$_sess][$k] = $v;
				}
			}
		}
	}
}
