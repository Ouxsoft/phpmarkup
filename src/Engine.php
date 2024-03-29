<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Ouxsoft\PHPMarkup;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use DOMXPath;
use Ouxsoft\PHPMarkup\Contract\ConfigurationInterface;
use Ouxsoft\PHPMarkup\Contract\DocumentInterface;
use Ouxsoft\PHPMarkup\Contract\ElementPoolInterface;
use Ouxsoft\PHPMarkup\Element\ElementPool;
use Ouxsoft\PHPMarkup\Element\AbstractElement;
use Ouxsoft\PHPMarkup\Contract\EngineInterface;
use Ouxsoft\PHPMarkup\Exception\ParserException;

/**
 * Class Engine
 *
 * The Engine loads a DOM object and modifies the Document.
 *
 * @package Ouxsoft\PHPMarkup\Engine
 */
class Engine implements EngineInterface
{
    // TODO: implement PHPMarkup const
    public const RETURN_CALL = 1;

    /**
     * marker attribute used by Engine to identify DOMElement during processing
     */
    public const INDEX_ATTRIBUTE = '_ELEMENT_ID';

    /**
     * @var DocumentInterface|Document|DOMDocument DOM
     */
    public $dom;

    /**
     * @var ElementPool|ElementPoolInterface
     */
    public $element_pool;

    /**
     * @var ConfigurationInterface|Configuration
     * contains array with additional Element construction parameters that are loaded as properties
     */
    private $config;

    /**
     * EngineInterface constructor.
     * @param DocumentInterface $document
     * @param ElementPoolInterface $element_pool
     * @param ConfigurationInterface $config
     */
    public function __construct(
        DocumentInterface &$document,
        ElementPoolInterface &$element_pool,
        ConfigurationInterface &$config
    ) {
        $this->dom = &$document;

        $this->element_pool = &$element_pool;

        $this->config = &$config;
    }

    /**
     * Call Hooks
     *
     * @param array $routine
     * @return bool
     */
    public function callRoutine(array $routine): bool
    {
        // set and/or update ancestors
        foreach ($this->element_pool as $element) {
            /** @var AbstractElement $element */
            $element->ancestors = $this->getElementAncestorProperties($element->element_id);
        }

        // call routine to all elements
        if (!array_key_exists('execute', $routine)) {
            $this->element_pool->callRoutine($routine['method']);
            return true;
        }

        switch ($routine['execute']) {
            case 'RETURN_CALL':
                /** @var AbstractElement $element */
                foreach ($this->element_pool as $element) {
                    $this->renderElement($element->element_id);
                }
                break;
            default:
                throw new ParserException('Invalid element execute command provided.');
        }

        return true;
    }

    /**
     * Get a Element ancestors' properties based on provided element_id DOMElement's ancestors
     *
     * @param string $element_id
     * @return array
     */
    public function getElementAncestorProperties(string $element_id): array
    {
        // make list of ancestor ids
        $ancestor_properties = [];

        $query = '//ancestor::*[@' . self::INDEX_ATTRIBUTE . ']';
        $node = $this->getDomElementByPlaceholderId($element_id);

        foreach ($this->queryFetchAll($query, $node) as $dom_element) {
            $ancestor_id = $dom_element->getAttribute(self::INDEX_ATTRIBUTE);
            $ancestor_properties[] = [
                'id' => $ancestor_id,
                'tag' => $dom_element->nodeName,
                'properties' => $this->element_pool->getPropertiesById($ancestor_id)
            ];
        }

        return array_reverse($ancestor_properties);
    }

    /**
     * Gets DOMElement using element_id provided
     *
     * @param string $element_id
     * @return DOMElement|null
     */
    public function getDomElementByPlaceholderId(string $element_id): ?DOMElement
    {
        // find an element by INDEX_ATTRIBUTE
        $query = '//*[@' . self::INDEX_ATTRIBUTE . '="' . $element_id . '"]';

        // get object found
        return $this->queryFetch($query);
    }

    /**
     * XPath query for class $this->DOM property that fetches only first result
     *
     * @param string $query
     * @param DOMElement|null $node
     * @return DOMElement|null
     */
    public function queryFetch(string $query, ?DOMElement $node = null): ?DOMElement
    {
        $xpath = new DOMXPath($this->dom);

        $results = $xpath->query($query, $node);

        if (isset($results[0])) {
            return $results[0];
        }

        return null;
    }

    /**
     * XPath query for class $this->DOM property that fetches all results as array
     *
     * @param string $query
     * @param DOMElement|null $node
     * @return DOMNodeList|null
     */
    public function queryFetchAll(string $query, ?DOMElement $node = null): ?DOMNodeList
    {
        $xpath = new DOMXPath($this->dom);

        return $xpath->query($query, $node);
    }

    /**
     * Within DOMDocument replace DOMElement with Element->__toString() output
     *
     * @param string $element_id
     * @return bool
     */
    public function renderElement(string $element_id): bool
    {
        // get DOMElement from placeholder id
        $dom_element = $this->getDomElementByPlaceholderId($element_id);

        if ($dom_element === null) {
            return false;
        }

        // get element using id
        $element = $this->element_pool->getById($element_id);

        // set inner xml
        $element->xml = $this->getElementInnerXML($element->element_id);

        $new_xml = $element->__toString() ?? '';

        $this->replaceDomElement($dom_element, $new_xml);

        return true;
    }

    /**
     * Get Element inner XML
     *
     * @param string $element_id
     * @return string
     */
    public function getElementInnerXML(string $element_id): string
    {
        $xml = '';

        $dom_element = $this->getDomElementByPlaceholderId($element_id);

        $children = $dom_element->childNodes;
        foreach ($children as $child) {
            $xml .= $dom_element->ownerDocument->saveXML($child);
        }

        return $xml;
    }

    /**
     * Replaces DOMElement from property DOM with contents provided
     *
     * @param DOMElement $element
     * @param string $new_xml
     */
    public function replaceDomElement(DOMElement $element, string $new_xml): void
    {
        // create a blank document fragment
        $fragment = $this->dom->createDocumentFragment();
        $fragment->appendXML($new_xml);

        // replace parent nodes child element with new fragment
        $element->parentNode->replaceChild($fragment, $element);
    }

    /**
     * Removes elements from the DOM
     *
     * @param array $lhtml_element
     * @return void
     */
    public function removeElements(array $lhtml_element): void
    {
        // iterate through handler's expression searching for applicable elements
        foreach ($this->queryFetchAll($lhtml_element['xpath']) as $dom_element) {
            $this->replaceDomElement($dom_element, '');
        }
    }

    /**
     * Instantiates elements from DOMElement's found during Xpath query against DOM property
     *
     * @param array $lhtml_element
     * @return bool
     */
    public function instantiateElements(array $lhtml_element): bool
    {

        // check for xpath and class
        if (
            !array_key_exists('xpath', $lhtml_element)
            || !array_key_exists('class_name', $lhtml_element)
        ) {
            return false;
        }

        // iterate through handler's expression searching for applicable elements
        foreach ($this->queryFetchAll($lhtml_element['xpath']) as $dom_element) {
            // if class does not exist replace element with informative comment
            $this->instantiateElement(
                $dom_element,
                $lhtml_element['class_name']
            );
        }

        return true;
    }

    /**
     * Instantiate a DOMElement as a Element using specified class_name
     *
     * @param DOMElement $element
     * @param string $class_name
     * @return bool
     */
    private function instantiateElement(DOMElement $element, string $class_name): bool
    {
        // skip if placeholder already assigned
        if ($element->hasAttribute(self::INDEX_ATTRIBUTE)) {
            return false;
        }

        // resolve $class_name {name} variable if present using $element
        if (strpos($class_name, '{name}') !== false) {
            if ($element->hasAttribute('name')) {
                $element_name = $element->getAttribute('name');
                $class_name = str_replace('{name}', $element_name, $class_name);
            } else {
                $this->replaceDomElement(
                    $element,
                    '<!-- Element "' . $class_name . '" Missing Name Attribute -->'
                );
                return false;
            }
        }

        // if class does not exist add debug comment
        if (!class_exists($class_name)) {
            $this->replaceDomElement(
                $element,
                '<!-- Element "' . $class_name . '" Not Found -->'
            );
            return false;
        }

        // instantiate element
        $element_object = new $class_name($this, $this->config->properties);

        // set element object placeholder
        $element->setAttribute(self::INDEX_ATTRIBUTE, $element_object->element_id);

        // add element to pool
        $this->element_pool->add($element_object);

        return true;
    }

    /**
     * Get DOMElement's attribute and child <args> elements and return as a single list
     * items within the list are called args as they are passed as parameters to element methods
     *
     * @param DOMElement $element
     * @return ArgumentArray
     */
    public function getElementArgs(DOMElement $element): ArgumentArray
    {
        $args = new ArgumentArray();

        // get attributes belonging to DOMElement as args
        if ($element->hasAttributes()) {
            foreach ($element->attributes as $name => $attribute) {
                $args[$name] = $attribute->value;
            }
        }

        // set all direct child arg DOMElements as args
        $arg_elements = $this->queryFetchAll('arg', $element);
        foreach ($arg_elements as $child_node) {
            $name = $child_node->getAttribute('name');

            // an arg must have a name
            if (($name === null) || ($name == '')) {
                continue;
            }

            // get value
            $innerHTML = '';
            foreach ($child_node->childNodes as $child) {
                $innerHTML .= $element->ownerDocument->saveXML($child);
            }
            $value = $innerHTML;

            // get type
            $type = $child_node->getAttribute('type') ?? 'string';

            // set value performing type juggling
            $args->set($name, $value, $type);
        }

        return $args;
    }

    /**
     * Remove args
     * @param string $xml
     * @return string
     */
    public function sanitizeXml(string $xml): string
    {
        // strip args
        $xml = preg_replace("/<arg.*?>(.*)?<\/arg>/im", '', $xml);

        return $xml;
    }

    /**
     * Strip attributes
     * @param array $attributes
     * @return void
     */
    public function stripAttributes(array $attributes): void
    {
        $xPath = new DOMXPath($this->dom);
        foreach ($attributes as $attribute) {
            $nodes = $xPath->query('//*[@' . $attribute . ']');
            foreach ($nodes as $node) {
                $node->removeAttribute($attribute);
            }
        }
    }

    /**
     * Get an elements child args by unique element id
     *
     * @param string $element_id
     * @return ArgumentArray
     */
    public function getArgsByElementId(string $element_id): ArgumentArray
    {
        $element = $this->getDomElementByPlaceholderId($element_id);
        $element_args = $this->getElementArgs($element);
        if ($element_args == null) {
            return new ArgumentArray();
        }
        return $element_args;
    }

    /**
     * Returns DomDocument property as HTML5
     *
     * @return string
     */
    public function __toString(): string
    {
        $this->stripAttributes([self::INDEX_ATTRIBUTE]);

        return $this->dom->saveHTML();
    }
}
