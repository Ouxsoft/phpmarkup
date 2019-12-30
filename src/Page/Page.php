<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\Page;

/**
 * Interface PageDefaultInterface
 * @package Pxp\Page
 */
interface PageDefaultInterface
{
    public function loadDom(string $filepath): void;

    public function __toString(): string;

    public function callHook(string $hook_name, string $options = null): bool;

    public function instantiateElement(string $xpath_expression, string $class_name): bool;

    public function replaceElement(\DOMElement &$element, string $new_xml): void;

    public function query($query);
}

/**
 * Class Page
 *
 * Features a DOM loaded from a HTML/XML document that is modified during runtime
 *
 * @package Pxp\Page
 */
class Page implements PageDefaultInterface
{

    // Document Object Model (DOM)
    public $dom;

    // DOM doctype
    public $doctype;

    // DOM XPath Query object
    public $xpath;

    // instantiated DynamicElements
    public $element_objects;

    // name of function called to load DynamicElement Args by ID
    public $arg_load_function;

    // registered includes added during output
    public $includes = [
        'js' => [],
        'css' => []
    ];

    // entities are required to avoid server side DOM parse errors
    public $entities = [
        'nbsp' => '&#160;',
        'copy' => '&#169;',
        'reg' => '&#174;',
        'trade' => '&#8482;',
        'mdash' => '&#8212;'
    ];

    // DynamicElement placeholder ID attribute
    private $element_index_attribute = '_pxp_ref';

    // DomDocument LibXML debug
    private $libxml_debug = false;

    /**
     * Page constructor
     *
     * @param null $filename
     */
    public function __construct($filename = null)
    {

        // create a document object model
        $this->dom = new \DomDocument();

        // DomDocument object setting to preserve white space
        $this->dom->preserveWhiteSpace = false;

        // DomDocument format output option
        $this->dom->formatOutput = true;

        // DomDocument strict error checking setting
        $this->dom->strictErrorChecking = false;

        // validate DOM on Parse
        $this->dom->validateOnParse = false;

        // DomDocument encoding
        $this->dom->encoding = 'UTF-8';

        // objects containing elements
        $this->element_objects = new \SplObjectStorage();

        // suppress xml parse errors unless debugging
        if (!$this->libxml_debug) {
            libxml_use_internal_errors(true);
        }

        // return if filename missing
        if ($filename == null) {
            return;
        }

        // set doctype string for loading DOM
        $this->setDoctype();

        // load DOM from filename
        $this->loadDom($filename);
    }

    /**
     * Returns an HTML5 doctype string with entities set
     *
     * build out doctype with HTML entities (&copy; etc.)
     *
     * @return void
     */
    public function setDoctype() : void
    {
        $entity = '';
        foreach ($this->entities as $key => $value) {
            $entity .= '<!ENTITY ' . $key . ' "' . $value . '">' . PHP_EOL;
        }

        $this->doctype = '<!DOCTYPE html [' . $entity . ']> ';
    }

    /**
     * Custom load page wrapper for server side HTML5 entity support
     * Using base class loadHTMLFile removes HTML5 entities
     *
     * @param string $filepath
     */
    public function loadDom(string $filepath): void
    {
        // get source file as string
        $source = file_get_contents($filepath);

        // convert source file to Document Object Model for manipulation
        // set doctype if $this->dom->doctype would not get set
        $count = 1;
        str_ireplace('<!doctype html>', $this->doctype, $source, $count);

        if($count == 0){
            $source = $this->doctype . $source;
            $this->dom->loadXML($source);
        } else {
            $this->dom->loadHTML($source);
        }

        // create document iterator for this dom
        $this->xpath = new \DOMXPath($this->dom);
    }

    /**
     * Calls single method to each instantiated DynamicElement
     *
     * @param string $hook_name
     * @param string|NULL $options
     * @return bool
     */
    public function callHook(string $hook_name, string $options = null): bool
    {
        // iterate through elements
        foreach ($this->element_objects as $element) {

            // skip if element does not feature hook
            if (!method_exists($element, $hook_name)) {
                continue;
            }

            // on render
            if ($options == 'RETURN_CALL') {
                $query = '//*[@' . $this->element_index_attribute . '="' . $element->placeholder_id . '"]';

                foreach ($this->query($query) as $replace_element) {
                    $new_xml = $element->__toString();

                    $this->replaceElement($replace_element, $new_xml);
                    continue;
                }
            } else {

                // call element method
                call_user_func([
                    $element,
                    $hook_name
                ]);
            }
        }

        return true;
    }

    /**
     * XPath query for DOM
     *
     * @param $query
     * @return mixed
     */
    public function query($query)
    {
        return $this->xpath->query($query);
    }

    /**
     * Replaces element contents
     *
     * @param \DOMElement $element
     * @param string $new_xml
     */
    public function replaceElement(\DOMElement &$element, string $new_xml): void
    {

        // create a blank document fragment
        $fragment = $this->dom->createDocumentFragment();
        $fragment->appendXML($new_xml);

        // replace parent nodes child element with new fragement
        $element->parentNode->replaceChild($fragment, $element);
    }

    /**
     * Instantiates dynamic elements found during xpath query
     *
     * @param string $xpath_expression
     * @param string $class_name
     * @return bool
     */
    public function instantiateElement(string $xpath_expression, string $class_name): bool
    {
        // if class does not exist replace element with informative comment
        // iterate through handler's expression searching for applicable elements
        foreach ($this->query($xpath_expression) as $element) {

            // skip if placeholder already assigned
            if ($element->hasAttribute($this->element_index_attribute)) {
                continue;
            }

            // resolve class name
            $element_class_name = $class_name;
            if ($element->hasAttribute('name')) {
                $element_name = $element->getAttribute('name');
                $element_class_name = str_replace('{name}', $element_name, $class_name);
            }

            // if class does not exist
            if (!class_exists($element_class_name)) {
                $this->replaceElement($element, '<!-- Handler "' . $element_class_name . '" Not Found -->');
                continue;
            }

            // get args from element and remove child arg
            $args = $this->getArgs($element);

            // get xml from element
            $xml = $this->getXml($element);

            // instantiate element
            $element_object = new $element_class_name($xml, $args);

            // object not instantiated
            if (!is_object($element_object)) {
                $this->replaceElement($element, '<!-- Handler "' . $element_class_name . '" Error -->');
                continue;
            }

            // set element object placeholder
            $element->setAttribute($this->element_index_attribute, $element_object->placeholder_id);

            // store object
            $this->element_objects->attach($element_object);
        }

        return true;
    }

    /**
     * Get element's innerXML
     *
     * @param \DOMElement $element
     * @return string
     */
    private function getXml(\DOMElement $element): string
    {
        $xml = '';

        $children = $element->childNodes;
        foreach ($children as $child) {
            $xml .= $element->ownerDocument->saveHTML($child);
        }

        return trim($xml);
    }

    /**
     * Adds an item to smart list.
     *
     * @param array $args
     * @param string $name
     * @param string $value
     */
    private function addToArgsList(array &$args, string $name, string $value) : void {

        if( ! isset($args[$name]) ) {
            // set value
            $args[$name] = $value;
        } else if ($args[$name] == $value ) {
            // if item value exists as string skip
        } else if( is_string($args[$name]) ) {
            // change string value to array
            $present_value = $args[$name];
            $args[$name] = [];
            array_push($args[$name], $present_value);
            array_push($args[$name], $value);
        } else if (in_array($value, $args[$name]) ) {
            // if item already exists return
            return;
        } else if ( is_array($args[$name]) ) {
            // add to array
            array_push($args[$name], $value);
        }
    }

    /**
     * Get element's ARGs
     *
     * @param \DOMElement $element
     * @return array
     */
    private function getArgs(\DOMElement &$element): array
    {
        $args = [];

        // get attributes
        if ($element->hasAttributes()) {
            foreach ($element->attributes as $name => $attribute) {
                $this->addToArgsList($args, $name, $attribute->value);
            }
        }

        // get child args
        $arg_elements = $element->getElementsByTagName('arg');
        // iterate in reverse threw list of arguments to avoid bug with removing
        for($i = $arg_elements->length - 1; $i >= 0; $i--){

            // get argument
            $arg_element = $arg_elements->item($i);

            // add item to args
            $name = $arg_element->getAttribute('name');
            $value = $arg_element->nodeValue;

            $this->addToArgsList($args, $name, $value);

            // remove element
            $arg_element->parentNode->removeChild($arg_element);
        }

        // use element id attribute to load args
        if ($element->hasAttribute('id')) {
            $element_id = $element->getAttribute('id');

            // allow director to specify function to load args from based on id
            if (function_exists($this->arg_load_function)) {
                $args_loaded = call_user_func($this->arg_load_function, $element_id);

                // merge args
                $args = array_merge($args_loaded, $args);
            }
        }

        return $args;
    }

    /**
     * Returns DomDocument as HTML
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->dom->saveHTML();
    }
}
