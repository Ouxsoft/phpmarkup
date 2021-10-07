# PHPMarkup

[![CI](https://github.com/Ouxsoft/phpmarkup/actions/workflows/ci.yml/badge.svg)](https://github.com/Ouxsoft/phpmarkup/actions/workflows/ci.yml)
[![Code Quality](https://app.codacy.com/project/badge/Grade/68c52ad139cb4f7fbb5e78c2eace6800)](https://www.codacy.com/gh/Ouxsoft/phpmarkup/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Ouxsoft/phpmarkup&amp;utm_campaign=Badge_Grade)
[![Code Coverage](https://img.shields.io/codecov/c/github/Ouxsoft/phpmarkup)](https://codecov.io/gh/Ouxsoft/phpmarkup)
[![Docs Status](https://readthedocs.org/projects/phpmarkup/badge/?version=latest&style=flat)](https://readthedocs.org/projects/phpmarkup)

[![Latest Stable Version](https://img.shields.io/packagist/v/Ouxsoft/phpmarkup.svg)](https://packagist.org/packages/Ouxsoft/phpmarkup)
[![PHP Versions Supported](https://img.shields.io/badge/php-7.3%20to%208.0-777bb3.svg?logo=php&logoColor=white&labelColor=555555)](https://api.travis-ci.com/Ouxsoft/phpmarkup.svg?branch=master&status=passed)
[![License](https://img.shields.io/badge/license-MIT-428f7e.svg?logo=open%20source%20initiative&logoColor=white&labelColor=555555)](https://github.com/Ouxsoft/phpmarkup/blob/master/LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/Ouxsoft/phpmarkup.svg)](https://packagist.org/packages/Ouxsoft/phpmarkup)

## Installation

Install the latest version:
```shell script
$ composer require ouxsoft/phpmarkup
```

## Basic Usage
Create an Element class containing DOMElement processing instructions.
```php
<?php

namespace App\Elements;

class Messages extends Ouxsoft\PHPMarkup\Element
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

Configure a Processor to process a DOM using the Element class created.
```php
<?php

use Ouxsoft\PHPMarkup\Factory\ProcessorFactory;
use App\Elements\Messages;

$processor = ProcessorFactory::getInstance();
$processor->addElement(['xpath' => '//messages', 'class_name' => App\Elements\Messages::class]);
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

## About
PHPMarkup is a lightweight markup processor written in PHP. 
It facilitates the extraction of markup into a data structure, orchestrated manipulation of said structure, and output as 
(optimized) markup. It is based on the [LHTML](https://github.com/Ouxsoft/LHTML) standard. 

### Documentation
*  [Processor](https://phpmarkup.readthedocs.io/en/latest/project/processor.html)
*  [Routines](https://phpmarkup.readthedocs.io/en/latest/project/routines.html)
*  [Elements](https://phpmarkup.readthedocs.io/en/latest/project/elements.html)
*  [Configuration](https://phpmarkup.readthedocs.io/en/latest/project/configuration.html)
*  [API](https://phpmarkup.readthedocs.io/en/latest/api.html)

### Author
Matthew Heroux<br />
See also the [list of contributors](https://github.com/Ouxsoft/phpmarkup/graphs/contributors) who participated in this project.

### Contributing
PHPMarkup is an open source project. If you find a problem or want to discuss new features or improvements
**please** create an issue, and/or if possible create a pull request. Easy contribute using 
[test docker image](https://github.com/Ouxsoft/phpmarkup/blob/master/CONTRIBUTING.md).

### License
PHPMarkup is licensed under the MIT License - see the [LICENSE](https://github.com/Ouxsoft/phpmarkup/LICENSE) file for details.

### Acknowledgement
Thanks to Andy Beak for providing code reviews. 
Thanks to Bob Crowley for providing Project Management advising. 
Thanks to Aswin Vijayakumar for their useful comments. 
Thanks to Alexander Romanovich of White Whale Web Services for his work on the free class 
[XPHP](http://technologies.whitewhale.net/xphp/).
All of have led to changes to this implementation.
