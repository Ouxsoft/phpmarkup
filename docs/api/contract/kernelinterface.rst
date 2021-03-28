KernelInterface
===============

:Qualified name: ``Ouxsoft\PHPMarkup\Contract\KernelInterface``

.. php:interface:: KernelInterface

  .. php:method:: public __construct (EngineInterface`  $engine, BuilderInterface`  $builder, ConfigurationInterface`  $config)

    :param EngineInterface`  $engine:
    :param BuilderInterface`  $builder:
    :param ConfigurationInterface`  $config:

  .. php:method:: public build ()


  .. php:method:: public getBuilder ()


  .. php:method:: public getConfig ()


  .. php:method:: public setBuilder (string $builder_class)

    :param string $builder_class:

  .. php:method:: public setConfig (ConfigurationInterface $config)

    :param ConfigurationInterface $config:

