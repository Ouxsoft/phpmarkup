Configuration
=============

:Qualified name: ``Ouxsoft\PHPMarkup\Configuration``
:Implements: :interface:`ConfigurationInterface`

.. php:class:: Configuration

  .. php:method:: public __construct (DocumentInterface`  $document[, ?string $config_file_path])

    :class:`Configuration` constructor

    :param DocumentInterface`  $document:
    :param ?string $config_file_path:
      Default: ``null``

  .. php:method:: public addElement (array $element)

    Adds a element

    :param array $element:

  .. php:method:: public addElements (array $elements)

    Adds multiple elements at once

    :param array $elements:

  .. php:method:: public addProperties (array & $properties)

    Add multiple properties

    :param array & $properties:

  .. php:method:: public addProperty (string $property_name, & $property_value)

    Add an property that will be passed to and become an property of all initialized elements

    :param string $property_name:
    :param & $property_value:

  .. php:method:: public addRoutine (array $routine)

    Adds a routine

    :param array $routine:

  .. php:method:: public addRoutines (array $routines)

    Adds multiple routines at once

    :param array $routines:

  .. php:method:: public clearConfig ()

    Clear config


  .. php:method:: public getElements () -> array

    Get elements

    :returns: array -- 

  .. php:method:: public getMarkup () -> string

    Get source

    :returns: string -- 

  .. php:method:: public getProperties () -> array

    Get element params

    :returns: array -- 

  .. php:method:: public getRoutines () -> array

    Get routines

    :returns: array -- 

  .. php:method:: public loadFile ([])

    load a configuration file

    :param string $filepath:
      Default: ``null``
    :returns: void

  .. php:method:: public setConfig (array $config)

    Set entire config at once

    :param array $config:

  .. php:method:: public setMarkup (string $markup)

    Set LHTML source/markup

    :param string $markup:

