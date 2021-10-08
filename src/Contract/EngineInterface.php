<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\PHPMarkup\Contract;

use Ouxsoft\PHPMarkup\ArgumentArray;
use DOMElement;
use DOMNodeList;
use Ouxsoft\PHPMarkup\Configuration;

/**
 * Interface EngineInterface
 * @package Ouxsoft\PHPMarkup\Contract
 */
interface EngineInterface
{
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
    );

    /**
     * @param array $routine
     * @return bool
     */
    public function callRoutine(array $routine): bool;

    /**
     * @param string $element_id
     * @return array
     */
    public function getElementAncestorProperties(string $element_id): array;

    /**
     * @param string $element_id
     * @return DOMElement|null
     */
    public function getDomElementByPlaceholderId(string $element_id): ?DOMElement;

    /**
     * @param string $query
     * @param DOMElement|null $node
     * @return DOMElement|null
     */
    public function queryFetch(string $query, DOMElement $node = null): ?DOMElement;

    /**
     * @param string $query
     * @param DOMElement|null $node
     * @return DOMNodeList|null
     */
    public function queryFetchAll(string $query, DOMElement $node = null): ?DOMNodeList;

    /**
     * @param string $element_id
     * @return bool
     */
    public function renderElement(string $element_id): bool;

    /**
     * @param string $xml
     * @return string
     */
    public function sanitizeXml(string $xml): string;

    /**
     * @param string $xml
     * @param array $attributes
     * @return string
     */
    public function stripAttributes(string $xml, array $attributes): string;

    /**
     * @param string $element_id
     * @return string
     */
    public function getElementInnerXML(string $element_id): string;

    /**
     * @param DOMElement $element
     * @param string $new_xml
     */
    public function replaceDomElement(DOMElement $element, string $new_xml): void;

    /**
     * @param array $lhtml_element
     */
    public function removeElements(array $lhtml_element): void;

    /**
     * @param array $lhtml_element
     * @return bool
     */
    public function instantiateElements(array $lhtml_element): bool;

    /**
     * @param DOMElement $element
     * @return ArgumentArray
     */
    public function getElementArgs(DOMElement $element): ArgumentArray;

    /**
     * @param string $element_id
     * @return ArgumentArray
     */
    public function getArgsByElementId(string $element_id): ArgumentArray;

    /**
     * @return string
     */
    public function __toString(): string;
}
