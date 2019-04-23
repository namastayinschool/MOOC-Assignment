<?php
// This class implements the ValidatorAbstract class
class Validator extends ValidatorAbstract
{
    private static $_singleton_class = __CLASS__;

    // this function validates the password - atleast 8 characters long, 
    // alphanumeric characters with atleast one uppercase
    // atleast one number, can have hyphen
    protected function _checkPassword($variablename, $variable, $label)
    {
        if (trim($variable) == '')
            $this->_errors[$variablename] = "$label: cannot be empty. ";
        elseif (1 !== preg_match('/^(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9\-]{8,}$/', $variable)) {
            $this->_errors[$variablename] = "$label: Invalid password format. Must be at least 8 characters with at least one uppercase character and one number.";
        }
    }

    // this function checks if the checkbox was checked
    protected function _checkChecked($variablename, $variable, $label)
    {
        if (!isset($variable) || empty($variable))
            $this->_errors[$variablename] = (empty($this->_pageVarData[$variablename]['errormessage'])) ? "$label: You must agree to the terms." : $this->_pageVarData[$variablename]['errormessage'];
    }

    // this function validates the full name entered
    protected function _checkFullName($variablename, $variable, $label)
    {
        if (trim($variable) == '')
            $this->_errors[$variablename] = "$label: cannot be empty. ";
        elseif (1 !== preg_match('/^(?!.*([ ]{2,}|[\-]{2,}|[\.]{2,}))(?!.*(\.[^ ]+|\-[^a-z]+))[a-z \-\.]+[a-z]+$/i', $variable)) {
            $this->_errors[$variablename] = "$label: Invalid format";
        }
    }

    // this function checks if the page contains only alphabetic characters
    public function isPageNameValid($pageName)
    {
        return (1 === preg_match('/^[a-z]+$/i', $pageName));
    }

    // this function makes the validator object singleton
    public static function makeValidatorSingleton()
    {
        if (!isset(self::$_instance)) {
            //session object to ensure only one validator object exists in the application
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

    // this function checks if the requested page is valid
    public function isRequestDataValid(array $requestData, array $pageVars)
    {
        $this->_pageVarData = $pageVars;

        $this->clearValidationErrors();

        foreach ($this->_pageVarData as $var => $settings) {
            $validationMethod = "_" . $settings['validationmethod'];
            $data = isset($requestData[$var]) ? $requestData[$var] : null;
            $this->$validationMethod($var, $data, $settings['label']);
        }
        return empty($this->_errors);
    }
}