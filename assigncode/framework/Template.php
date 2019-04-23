<?php
/**
 * @package COMP3170
 * @subpackage Template
 */
class Template 
{
    private $_vars = array();	// Holds all the template variables
    private $_file = 'template.tpl';
    private $_templateDir = '';
    private $_pluginsDir = '';
    private $_xhtml = '';
    private $_plugins = array();	// Holds all plug in function names

	/**
	* Check the _vars array to make sure the variables that are being
	* displayed in the template are properly initialized or set so as to
	* avoid the PHP Notice of undefined variables when in development mode
	*/
	protected function _checkForInitializedVars()
	{
		list($templateName) = explode('.', $this->_file);
		$allVars = parse_ini_file(INCLUDE_DIR . '/templateLibrary.ini', true);
		foreach ($allVars as $vars=>$varDetails) {
			if (in_array($templateName, $varDetails['inpage']) &&
				!isset($this->_vars[$vars])) {
				$this->_vars[$vars] = $varDetails['undefined'];
			}
		}
	}
		
	
    /**
     * Create the presentation tier and set the template and plugin directories
     * to the current directory
     *
     * @param string $file  The file name of the template that you want to load
     */
    public function __construct($file = null) {
    	if (!empty($file)) {
    		$this->_file = $file;
    	}
        $this->_templateDir = '.';
    	$this->_pluginsDir = '.';
    }

    /**
     * Set a template variable.
     */
    public function assign($name, $value) {
        $this->_vars[$name] = is_object($value) ? $value->fetch() : $value;
    }

    /**
     * Add a plugin function to process complicated data and output more involved XHTML 
     * @return void
     */
    public function addPlugIn($pluginFileName)
    {
    	if (empty($pluginFileName)) {
    		trigger_error('Template Error: Empty plugin name received', E_USER_ERROR);
    		exit;
    	}
    	if (!is_string($pluginFileName)) {
    		die('<b>Template Error:</b> Invalid parameter passed to' . __CLASS__ . '::addPlugIn');
    	}
    	if (!array_key_exists($pluginFileName, $this->_plugins))
    		$this->_plugins[$pluginFileName] = TRUE;		// just provide a value to indicate the plugin is accepted
    	else 
    		die('<b>Template Error:</b> Plugin ' . $pluginFileName . ' already added to the template');
    }

    /**
     * Sets the directory for the templates. Default setting is current working directory
     *
     */
    public function setDir($dirpath = null) {
    	if (!empty($dirpath)) {
    		$this->_templateDir = $dirpath;
    	}
    }

    /**
     * Sets the directory for the plugins. Default setting is current working directory
     *
     * @param string $dirpath
     */
    public function setPluginDir($dirpath = null) {
    	if (!empty($dirpath)) {
    		$this->_pluginsDir = $dirpath;
    	}
    }


    /**
     * Open, parse, and return the template file.
     *
     * @param $file string the template file name
     */
   public function parse($file = null) {
        if (!$file) {
        	$file = $this->_file;
        }
        if (!file_exists("{$this->_templateDir}/$file")) {
        	echo "<b>Template Error:</b> Template file not found, or template directory not set {$this->_templateDir}/$file";
        	exit;
        }
        $file = "{$this->_templateDir}/$file";

		// check to see if the variables have been set
		$this->_checkForInitializedVars();
		
        extract($this->_vars);          // Extract the _vars to local namespace
        ob_start();                    // Start output buffering
        if (!empty($this->_plugins)) {	// plugins added to the template for processing
        	foreach ($this->_plugins as $fnc=>$val) {	// Include the functions specified by the plugin
        		$fnc = "{$this->_pluginsDir}/$fnc";
        		include_once ($fnc);
        	}
        }
        include($file);                // Include the file
        $this->_xhtml = ob_get_contents(); // Get the contents of the buffer
        ob_end_clean();                // End buffering and discard
    }

	 /**
         * Displays the parsed XHTML file to the browser
         */
        public function display($file = null)
        {
                if (empty($this->_xhtml)) {
                        $this->parse($file);
                }
                echo $this->_xhtml;
        }

}
