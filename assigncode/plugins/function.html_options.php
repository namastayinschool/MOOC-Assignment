<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_options} function plugin
 *
 * Type:     function<br>
 * Name:     html_options<br>
 * Input:<br>
 *           - name       (optional) - string default "select"
 *           - values     (required if no options supplied) - array
 *           - options    (required if no values supplied) - associative array
 *           - selected   (optional) - string default not set
 *           - output     (required if not options supplied) - array
 * Purpose:  Prints the list of <option> tags generated from
 *           the passed parameters
 * @link http://smarty.php.net/manual/en/language.function.html.options.php {html_image}
 *      (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 * @param array
 * @param Smarty
 * @return string
 */
function html_options($params)
{    
    $name = null;
    $values = null;
    $options = null;
    $selected = array();
    $output = null;
    $eol = chr(13);
    
    $extra = '';
    
    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'name':
                $$_key = (string)$_val;
                break;
            
            case 'options':
                $$_key = (array)$_val;
                break;
                
            case 'values':
            case 'output':
                $$_key = array_values((array)$_val);
                break;

            case 'selected':
                $$_key = array_map('strval', array_values((array)$_val));
                break;
                
            case 'disabled':
            	if ($_val == 'disabled') {
            		$extra .= ' '.$_key;
            	}
            	break;
            case 'class':
            	$$_key = " class='$_val'";
            	break;
            case 'id':
            	$extra .= " id='$_val'";
            	break;
            case 'nobreak':
            	$eol = '';
            break;
            default:
                if(!is_array($_val)) {
                    $extra .= ' '.$_key.'="'.htmlspecialchars($_val).'"';
                } else {
                    echo ("<b>Template error:</b> html_options: extra attribute '$_key' cannot be an array");
                    exit;
                }
                break;
        }
    }

    if (!isset($options) && !isset($values))
        return '<b>Kwikan Framework Error [Presentation]:</b> Invalid configuration for html_options missing options and values'; /* raise error here? */

    $_html_result = '';

    if (isset($options)) {
        
        foreach ($options as $_key=>$_val)
            $_html_result .= html_options_optoutput($_key, $_val, $selected);

    } else {
        
        foreach ($values as $_i=>$_key) {
            $_val = isset($output[$_i]) ? $output[$_i] : '';
            $_html_result .= html_options_optoutput($_key, $_val, $selected);
        }

    }

    if(!empty($name)) {
        $_html_result = '<select name="' . $name . '"' . $extra . $class . '>' . ($eol) . $_html_result . '</select>' . ($eol);
    }

    return $_html_result;

}

function html_options_optoutput($key, $value, $selected) {
    if(!is_array($value)) {
        $_html_result = '<option label="' . htmlspecialchars($value) . '" value="' .
            htmlspecialchars($key) . '"';
        if (in_array((string)$key, $selected))
            $_html_result .= ' selected="selected"';
        $_html_result .= '>' . htmlspecialchars($value) . '</option>' . ($eol);
    } else {
        $_html_result = html_options_optgroup($key, $value, $selected);
    }
    return $_html_result;
}

function html_options_optgroup($key, $values, $selected) {
    $optgroup_html = '<optgroup label="' . htmlspecialchars($key) . '">' . ($eol);
    foreach ($values as $key => $value) {
        $optgroup_html .= html_options_optoutput($key, $value, $selected);
    }
    $optgroup_html .= "</optgroup>{$eol}";
    return $optgroup_html;
}

/* vim: set expandtab: */

?>