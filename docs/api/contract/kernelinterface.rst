KernelInterface
===============

:Qualified name: ``Ouxsoft\PHPMarkup\Contract\KernelInterface``

.. php:interface:: KernelInterface

  .. php:method:: public __construct (EngineInterface`  $engine, BuilderInterface`  $builder, ConfigurationInterface`  $config)

    :class:`KernelInterface` constructor.

    :param EngineInterface`  $engine:
    :param BuilderInterface`  $builder:
    :param ConfigurationInterface`  $config:

  .. php:method:: public build () -> Engine

    :returns: :class:`Engine` -- 

  .. php:method:: public getBuilder () -> BuilderInterface

    :returns: :class:`BuilderInterface` -- 

  .. php:method:: public getConfig () -> ConfigurationInterface

    :returns: :class:`ConfigurationInterface` -- 

  .. php:method:: public setBuilder (string $builder_class)

    :param string $builder_class:

  .. php:method:: public setConfig (ConfigurationInterface $config)

    :param ConfigurationInterface $config:

