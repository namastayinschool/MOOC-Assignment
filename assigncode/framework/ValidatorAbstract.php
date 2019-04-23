<?php
/**
 * An abstract class that performs the data validation. This abstract
 * class contains the actual methods that are used to perform
 * the validation, but leaves how the methods are called to the client code 
 * implementations.
 */ 
abstract class ValidatorAbstract {
	/**
	 * Stores all error messages created by the validation methods
	 * @var array
	 */
	protected $_errors = array();
	
	/**
	 * Stores the parsed page variables from 
	 * the ini file
	 * @var array
	 */
	protected $_pageVarData = array();
	
	/**
	 * Stores the singleton instance
	 * @var ValidatorAbstract
	 */
	protected static $_instance = null;
	
	
	/**
	 * Makes the singleton of the validator
	 */
	abstract public static function makeValidatorSingleton();
	
	
	/**
	 * The abstract method that actually performs the 
	 * validation. The code has to be built by the programmer and it determines
	 * how the methods defined by the validator are to be actually called. One way
	 * this can be done is by using some input text file (an ini file in this case) that holds
	 * the validation instructions that this method loads and uses to perform
	 * the validation.
	 * @param array	$requestData	Variables sent in the user request either by $_POST or $_GET or $_REQUEST
	 * @param array $pageVars		Registered page variables taken from the ini file
	 * @return boolean
	 */
	abstract public function isRequestDataValid(array $requestData, array $pageVars);

	/**
	 * Checks to make sure the page name is valid
	 * @return true|false   Returns true if the page conforms to the requirements
	 */
	abstract public function isPageNameValid($pageName);
	
	/**
	 * Checks the variable value to ensure it is a correctly formatted password as
	 * described in assignment two.
	 * The variable cannot be empty and must add an 
	 * error message to the Validator $_errors[] array that includes the variable's label 
	 * and either that the field cannot be empty or reminds the user of the correct format.
	 * 
	 * @param $variablename	The name of the variable that is being validated
	 * @param $variable	The variable's value
	 * @param $label	The label of the variable as displayed in the HTML form
	 */
	abstract protected function _checkPassword($variablename, $variable, $label);
	

	/**
	 * Returns any errors generated by the validation process
	 * @return array
	 */
	public function getValidationErrors() {
		return $this->_errors;
	}
	
	
	/**
	 * Checks  variable names to ensure they conform to the PHP rules
	 * @param string $name	The name of the variable being checked
	 * @return true|false	Returns true if the variable is a valid PHP	variable name
	 */
	public static function isVariableNameValid($name) {
		$matches = array();		// hold the matches found
		
		if (FALSE === preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $name, $matches)) {
			debug_print_backtrace();
			trigger_error('Testing of variable name failed', E_USER_ERROR);
			return null;
		}
		elseif (!empty($matches)) {
			return true;
		}
		return false;
	}
	
	/**
	 * Checks to ensure a parameter passed to a method is non-empty. If it
	 * is empty, trigger an error, otherwise do nothing
	 * 
	 * This method should be used by the programmer to ensure a parameter to a method
	 * he/she creates is non-empty. This method aborts the application and does not produce
	 * user-friendly errors, so it should not be used for form validation
	 */
	final public static function ensureParameterNotEmpty($param, $msg='')
	{
		if (empty($param)) {
			$msg = empty($msg) ? 'Invalid parameter received. Cannot be empty ' : $msg;
			trigger_error( $msg . debug_print_backtrace(), E_USER_ERROR);
		}
	}
	
	/**
	 * Checks to ensure a parameter passed to a method is non-empty. If it
	 * is empty, trigger an error, otherwise do nothing
	 * 
	 * This method should be used by the programmer to ensure a parameter to a method
	 * he/she creates is a string. This method aborts the application and does not produce
	 * user-friendly errors, so it should not be used for form validation
	 */
	final public static function ensureParameterIsString ($param)
	{
		if (!is_string($param)) {
			trigger_error('Invalid parameter received. Parameter must be a string', E_USER_ERROR);
		}
	}
	
	/**
	 * Checks to ensure all parameters passed to a method are non-empty. If any
	 * are empty, trigger an error, otherwise do nothing
	 *
	 * This method should be used by the programmer to ensure that parameters to a method
	 * he/she creates are non-empty. This method aborts the application and does not produce
	 * user-friendly errors, so it should not be used for form validation
	 */
	final public static function ensureParametersNotEmpty(array $param)
	{
		if (empty($param)) {
			trigger_error('Invalid parameter received. Cannot be empty', E_USER_ERROR);
		}
		else {
			foreach ($param as $p) {
				if (empty($p)) {
					trigger_error('Invalid parameter received in the parameter list. Cannot be empty' . debug_print_backtrace(), E_USER_ERROR);
				}
			}
		}
	}
	
	/**
	* Checks to see if the variable can have empty values
	*/
	final protected function emptyIsAllowed($param, $value)
	{
		if (isset($this->_pageVarData[$param]['emptyallowed']) &&
				 ($this->_pageVarData[$param]['emptyallowed'] == 'yes') && 
				 (trim($value) == ''))
				 return true;
		else
			return false;
	}
	
	/**
	 * Resets any errors generated by the validation process
	 * @return array
	 */
	final public function clearValidationErrors() {
		$this->_errors = array();
	}
	
	/**
 	* Validates the variable to make sure that editorial marks like 
 	* double and single quotes as well as slashes
 	* are accepted and properly handled. Field may be blank. Allows most 
 	* text and valid keyboard characters
 	* @see Validator::check_general	Based on the validation parameters for the general type
 	* @param $variablename	The name of the variable that is being validated
 	* @param $variable	The variable's value
 	* @param $label	The label of the variable as displayed in the HTML form
 	*/
	protected function _checkEntry($variablename, $variable, $label) {
		if ((trim($variable) =='') || ($variable == '--') || ($variable == '-- Select One --')) {
			$this->_errors[] = (empty($this->_pageVarData[$variablename]['errormessage'])) ? "$label: Select or enter a value. Field cannot be all spaces or empty." : $this->_pageVarData[$variablename]['errormessage'];
		}
		elseif (!preg_match("",$variable)) {
				$this->_errors[] = "$label: Your text contains unaccepted characters.";
		}
	}

	
	/**
	 * Validates the variable to ensure it only allows words, spaces and hyphens.
	 * 
	 * @param string $variablename
	 * @param string $variable
	 * @param string $label
	 */
	protected function _checkSimpletext($variablename, $variable, $label) {
		if ( (trim($variable) =='') && (!preg_match("/^[a-zA-Z\s-]+$/i",$variable)) ) {
			$this->_errors[] = "$label: Only letters, numbers, spaces, underscores, apostrophes, percent signs and hyphens.";
		}
	}
	
	protected function _checkEmail($variablename, $variable, $label) {
		if ($this->emptyIsAllowed($variablename, $variable))
			return;

		if (trim($variable) =='')
			$this->_errors['email'] = "$label: cannot be empty.";
		elseif (!filter_var($variable, FILTER_VALIDATE_EMAIL)) {
			$this->_errors['email'] = "$label: Invalid email address format.";
		}
	}

}
?>