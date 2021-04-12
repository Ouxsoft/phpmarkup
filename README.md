<p align="center"><img src="https://github.com/Ouxsoft/PHPMarkup/raw/master/docs/logo.jpg" width="350"></p>

<p align="center">
    <a href="https://travis-ci.com/github/Ouxsoft/PHPMarkup"><img src="https://api.travis-ci.com/Ouxsoft/PHPMarkup.svg?branch=master&status=passed" alt="Build Status"></a>
    <a href="https://app.codacy.com/gh/Ouxsoft/PHPMarkup?utm_source=github.com&utm_medium=referral&utm_content=Ouxsoft/PHPMarkup&utm_campaign=Badge_Grade_Dashboard"><img alt="Codacy grade" src="https://img.shields.io/codacy/grade/86210d48e2ca45e497be865ace8a4029"></a>
    <a href="https://codecov.io/gh/Ouxsoft/phpmarkup"> <img alt="Codecov" src="https://img.shields.io/codecov/c/github/Ouxsoft/phpmarkup"> </a> 
    <a href="https://phpmarkup.readthedocs.io/en/latest/?badge=latest"><img src="https://readthedocs.org/projects/phpmarkup/badge/?version=latest" alt="Documentation Status"></a> 
</p>

<p align="center">
    <a href="https://packagist.org/packages/Ouxsoft/phpmarkup"><img alt="GitHub release (latest by date)" src="https://img.shields.io/github/v/release/Ouxsoft/phpmarkup"></a> 
    <a href="#tada-php-support" title="PHP Versions Supported"><img alt="PHP Versions Supported" src="https://img.shields.io/badge/php-7.3%20to%208.0-777bb3.svg?logo=php&logoColor=white&labelColor=555555"></a>  
    <a href="https://github.com/Ouxsoft/phpmarkup/blob/master/LICENSE" title="license"><img alt="LICENSE" src="https://img.shields.io/badge/license-MIT-428f7e.svg?logo=open%20source%20initiative&logoColor=white&labelColor=555555"></a>
</p>

## About

A Processor for Markup based on the [LHTML](https://github.com/Ouxsoft/LHTML) standard written in PHP. 
Allows extraction of Markup into a data structure, orchestrated manipulation of said structure, and output as 
(optimized) Markup. 

### Instructions
Create a PHPMarkup Element class used for processing
```php
/**
 * Class SayHello
 * DomElement process class
 */
class SayHello extends Ouxsoft\PHPMarkup\Element
{
    /**
     * @return string
     */
    public function onRender(): string
    {
        return 'Hello, ' . $this->getArgByName('who') . $this->innerText();
    }
}
```

Then add the class with a processor.

```php
use Ouxsoft\PHPMarkup\Factory\ProcessorFactory;

// Instantiate Processor and configure to parse output buffer
$processor = ProcessorFactory::getInstance();
$processor->addElement(['xpath' => '//greetings', 'class_name' => 'SayHello']);
$processor->addRoutine(['method' => 'onRender', 'execute' => 'RETURN_CALL']);
$processor->parseBuffer();

// Displays "Hello, World!" when rendered by Browser
?>
<html lang="en">
    <greetings>
        <arg name="who">World</arg>!
    </greetings>
</html>
```

## Installation

### Via Composer
PHPMarkup is available on [Packagist](https://packagist.org/packages/Ouxsoft/livingMarkup).

Install with [Composer](https://getcomposer.org/download/):
```shell script
composer require ouxsoft/phpmarkup
```

### Via Git
Install with [Git](https://git-scm.com/):
```shell script
git clone git@github.com:Ouxsoft/PHPMarkup.git
```

## Documentation
Read our docs for usage [phpmarkup.readthedocs.io](https://phpmarkup.readthedocs.io).

## Contributing
PHPMarkup is an open source project. If you find a problem or want to discuss new features or improvements
please create an issue, and/or if possible create a pull request. Contributing is easy with [phpmarkup-stack](https://github.com/Ouxsoft/phpmarkup-stack) 
a docker based development environment with test suite.

## Acknowledgement
Thanks to Matthew Heroux for leading the development of PHPMarkup. 
Thanks to Andy Beak for providing code reviews. 
Thanks to Bob Crowley for providing Project Management advising. 
Thanks to Aswin Vijayakumar for their useful comments. 
Thanks to Alexander Romanovich of White Whale Web Services for his work on the free class 
[XPHP](http://technologies.whitewhale.net/xphp/).
All of have led to changes to this implementation.
