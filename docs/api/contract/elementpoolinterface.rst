ElementPoolInterface
====================

:Qualified name: ``Ouxsoft\PHPMarkup\Contract\ElementPoolInterface``

.. php:interface:: ElementPoolInterface

  .. php:method:: public add (AbstractElement`  $element)

    :param AbstractElement`  $element:

  .. php:method:: public callRoutine (string $routine)

    :param string $routine:

  .. php:method:: public count () -> int

    :returns: int -- 

  .. php:method:: public getById ([])

    :param ?string $element_id:
      Default: ``null``
    :returns: AbstractElement|null

  .. php:method:: public getIterator ()

    :returns: ArrayIterator

  .. php:method:: public getPropertiesById (string $element_id) -> array

    :param string $element_id:
    :returns: array -- 

