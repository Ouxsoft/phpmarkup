<p align="center"><img src="https://github.com/Ouxsoft/phpmarkup/raw/master/docs/logo.jpg" width="350"></p>

<p align="center">
    <a href="https://travis-ci.com/github/Ouxsoft/phpmarkup"><img src="https://api.travis-ci.com/Ouxsoft/phpmarkup.svg?branch=master&status=passed" alt="Build Status"></a>
    <a href="https://www.codacy.com/gh/Ouxsoft/phpmarkup/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Ouxsoft/phpmarkup&amp;utm_campaign=Badge_Grade"><img src="https://app.codacy.com/project/badge/Grade/68c52ad139cb4f7fbb5e78c2eace6800"/></a>
    <a href="https://codecov.io/gh/Ouxsoft/phpmarkup"> <img alt="Codecov" src="https://img.shields.io/codecov/c/github/Ouxsoft/phpmarkup"> </a> 
    <a href="https://phpmarkup.readthedocs.io/en/latest/?badge=latest"><img src="https://readthedocs.org/projects/phpmarkup/badge/?version=latest" alt="Documentation Status"></a> 
</p>

<p align="center">
    <a href="https://packagist.org/packages/Ouxsoft/phpmarkup"><img alt="GitHub release (latest by date)" src="https://img.shields.io/github/v/release/Ouxsoft/phpmarkup"></a> 
    <a href="#tada-php-support" title="PHP Versions Supported"><img alt="PHP Versions Supported" src="https://img.shields.io/badge/php-7.3%20to%208.0-777bb3.svg?logo=php&logoColor=white&labelColor=555555"></a>  
    <a href="https://github.com/Ouxsoft/phpmarkup/blob/master/LICENSE" title="license"><img alt="LICENSE" src="https://img.shields.io/badge/license-MIT-428f7e.svg?logo=open%20source%20initiative&logoColor=white&labelColor=555555"></a>
</p>

## About
PHPMarkup is a lightweight markup processor written in PHP. 
It facilitates the extraction of markup into a data structure, orchestrated manipulation of said structure, and output as 
(optimized) markup. It is based on the [LHTML](https://github.com/Ouxsoft/LHTML) standard. 

### Instructions
Create a PHPMarkup Element to instruct DOMElement processing.
```php
/**
 * Class MessagesElement
 */
class MessagesElement extends Ouxsoft\PHPMarkup\Element
{
    private $messages;

    public function onLoad() : void
    {
        $this->messages = $this->db->query('SELECT `msg` FROM `messages`;');
    }

    public function onRender(): string
    {
        $out = '';
        foreach($this->messages as $row){
            $out .= $row['msg'] . $this->getArgByName('delimiter');
        }
        return $out;
    }
}
```

Process a DOM using the class created.

```php
use Ouxsoft\PHPMarkup\Factory\ProcessorFactory;

$processor = ProcessorFactory::getInstance();
$processor->addElement(['xpath' => '//messages', 'class_name' => 'MessagesElement']);
$processor->addRoutine(['method' => 'onLoad']);
$processor->addRoutine(['method' => 'onRender', 'execute' => 'RETURN_CALL']);
$processor->addProperty('db', new PDO('sqlite:/example.db'));
$processor->parseBuffer();
?>
<html lang="en">
    <messages>
        <arg name="delimiter">;</arg>
    </messages>
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
git clone git@github.com:Ouxsoft/phpmarkup.git
```

## Documentation
Read the docs [phpmarkup.readthedocs.io](https://phpmarkup.readthedocs.io).

## Contributing
PHPMarkup is an open source project. If you find a problem or want to discuss new features or improvements
**please** create an issue, and/or if possible create a pull request. Contributing is easy with [phpmarkup-stack](https://github.com/Ouxsoft/phpmarkup-stack) 
a docker based development environment with test suite.

## Acknowledgement
Thanks to Matthew Heroux for leading the development of PHPMarkup. 
Thanks to Andy Beak for providing code reviews. 
Thanks to Bob Crowley for providing Project Management advising. 
Thanks to Aswin Vijayakumar for their useful comments. 
Thanks to Alexander Romanovich of White Whale Web Services for his work on the free class 
[XPHP](http://technologies.whitewhale.net/xphp/).
All of have led to changes to this implementation.
