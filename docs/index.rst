|alt text|

Welcome to PHPMarkup Documentation
=====================================

| **PHPMarkup is an PHP implementation of a LHTML parser.**
| It is a powerful and flexible way to build dynamic web pages.


.. code-block:: php
   
    <?php
    use Ouxsoft\PHPMarkup\Factory\ProcessorFactory;

    $processor = ProcessorFactory::getInstance();

    $processor->addElement([
    'xpath' => '//partial',
    'class_name' => 'Partial\{name}'
    ]);

    $processor->addRoutine([
    'method' => 'onRender',
    'execute' => 'RETURN_CALL'
    ]);

    $processor->parseBuffer();
    ?>
    <html lang="en">
    <partial name="Alert" type="success">
        This is a success alert.
    </partial>
    </html>


Installation
------------

Get an instance of PHPMarkup up and running in less than 5 minutes.

PHPMarkup is available on Packagist.

Install with Composer:

.. code-block:: bash

    composer require ouxsoft/phpmarkup

That's it. You're done! Please take the rest of the time to read our docs.

Contribute
----------

- Issue Tracker: https://github.com/ouxsoft/PHPMarkup/issues
- Source Code: https://github.com/ouxsoft/PHPMarkup

Navigation
==========

.. toctree::
   :maxdepth: 1
   :caption: Project Information
   
   project/processor.rst
   project/routines.rst
   project/elements.rst
   project/configuration.rst
   project/security.rst
   Classes <api.rst>
   project/code-of-conduct.rst

Indices and tables
==================

* :ref:`genindex`
* :ref:`search`

.. |alt text| image:: https://github.com/ouxsoft/PHPMarkup/raw/master/docs/logo.jpg