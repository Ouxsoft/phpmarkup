AbstractElement
===============

:Qualified name: ``Ouxsoft\PHPMarkup\Element\AbstractElement``

.. php:class:: AbstractElement

  .. php:method:: public __construct (EngineInterface`  $engine[, array & $dynamic_properties])

    Element constructor

    :param EngineInterface`  $engine:
    :param array & $dynamic_properties:
      Default: ``[]``

  .. php:method:: public __invoke (string $method) -> bool

    Invoke wrapper call to method if exists

    :param string $method:
    :returns: bool -- 

  .. php:method:: public __toString () -> string

    Call onRender if exists on echo / output

    :returns: string -- 

  .. php:method:: public getArgByName (string $name)

    Get live arg by name

    :param string $name:
    :returns: mixed|null

  .. php:method:: public getArgs () -> ArgumentArray

    Get all live args

    :returns: :class:`ArgumentArray` -- 

  .. php:method:: public getId () -> string

    Gets the ID of the Element, useful for :class:`ElementPool`

    :returns: string -- 

  .. php:method:: public innerText ()

    Get sanitized innerText with args processing info removed

    :returns: string|null

  .. php:method:: public onRender () -> mixed

    Abstract output method called by magic method The extending class must define this method

    :returns: mixed -- 

