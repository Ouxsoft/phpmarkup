ConfigurationInterface
======================

:Qualified name: ``Ouxsoft\PHPMarkup\Contract\ConfigurationInterface``

.. php:interface:: ConfigurationInterface

  .. php:method:: public __construct (DocumentInterface`  $document[, ?string $config_file_path])

    :class:`ConfigurationInterface` constructor.

    :param DocumentInterface`  $document:
    :param ?string $config_file_path:
      Default: ``null``

  .. php:method:: public addElement (array $element)

    :param array $element:

  .. php:method:: public addElements (array $elements)

    :param array $elements:

  .. php:method:: public addProperties (array & $properties)

    :param array & $properties:

  .. php:method:: public addProperty (string $property_key, & $property_value)

    :param string $property_key:
    :param & $property_value:

  .. php:method:: public addRoutine (array $routine)

    :param array $routine:

  .. php:method:: public addRoutines (array $routines)

    :param array $routines:

  .. php:method:: public clearConfig ()


  .. php:method:: public getElements () -> array

    :returns: array -- 

  .. php:method:: public getMarkup () -> string

    :returns: string -- 

  .. php:method:: public getProperties () -> array

    :returns: array -- 

  .. php:method:: public getRoutines () -> array

    :returns: array -- 

  .. php:method:: public loadFile ([])

    :param string $filepath:
      Default: ``null``

  .. php:method:: public setConfig (array $config)

    :param array $config:

  .. php:method:: public setMarkup (string $markup)

    :param string $markup:

