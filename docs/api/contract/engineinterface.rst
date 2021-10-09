EngineInterface
===============

:Qualified name: ``Ouxsoft\PHPMarkup\Contract\EngineInterface``

.. php:interface:: EngineInterface

  .. php:method:: public __construct (DocumentInterface`  $document, ElementPoolInterface`  $element_pool, ConfigurationInterface`  $config)

    :class:`EngineInterface` constructor.

    :param DocumentInterface`  $document:
    :param ElementPoolInterface`  $element_pool:
    :param ConfigurationInterface`  $config:

  .. php:method:: public __toString () -> string

    :returns: string -- 

  .. php:method:: public callRoutine (array $routine) -> bool

    :param array $routine:
    :returns: bool -- 

  .. php:method:: public getArgsByElementId (string $element_id) -> ArgumentArray

    :param string $element_id:
    :returns: :class:`ArgumentArray` -- 

  .. php:method:: public getDomElementByPlaceholderId (string $element_id)

    :param string $element_id:
    :returns: DOMElement|null

  .. php:method:: public getElementAncestorProperties (string $element_id) -> array

    :param string $element_id:
    :returns: array -- 

  .. php:method:: public getElementArgs (DOMElement $element) -> ArgumentArray

    :param DOMElement $element:
    :returns: :class:`ArgumentArray` -- 

  .. php:method:: public getElementInnerXML (string $element_id) -> string

    :param string $element_id:
    :returns: string -- 

  .. php:method:: public instantiateElements (array $lhtml_element) -> bool

    :param array $lhtml_element:
    :returns: bool -- 

  .. php:method:: public queryFetch (string $query[, DOMElement $node])

    :param string $query:
    :param DOMElement $node:
      Default: ``null``
    :returns: DOMElement|null

  .. php:method:: public queryFetchAll (string $query[, DOMElement $node])

    :param string $query:
    :param DOMElement $node:
      Default: ``null``
    :returns: DOMNodeList|null

  .. php:method:: public removeElements (array $lhtml_element)

    :param array $lhtml_element:

  .. php:method:: public renderElement (string $element_id) -> bool

    :param string $element_id:
    :returns: bool -- 

  .. php:method:: public replaceDomElement (DOMElement $element, string $new_xml)

    :param DOMElement $element:
    :param string $new_xml:

  .. php:method:: public sanitizeXml (string $xml) -> string

    :param string $xml:
    :returns: string -- 

  .. php:method:: public stripAttributes (array $attributes)

    :param array $attributes:
    :returns: void

