Document
========

:Qualified name: ``Ouxsoft\PHPMarkup\Document``
:Implements: :interface:`DocumentInterface`

.. php:class:: Document

  .. php:method:: public __construct ()

    :class:`Document` constructor.


  .. php:method:: public createDocumentFragment () -> mixed

    :returns: mixed -- 

  .. php:method:: public loadSource (string $source) -> bool

    Loads source, which is in LHTML format, as DomDocument
A custom load page wrapper is required for server-side HTML5 entity support. Using $this->loadHTMLFile will removes HTML5 entities, such as

    :param string $source:
    :returns: bool -- 

  .. php:method:: public saveHTML () -> mixed

    :returns: mixed -- 

