# Contributing to PHPMarkup

* Please bare that in mind when contributing PHPMarkup is built to adhere to the Unix philosophy. It is designed to be used in other applications; not to be a monolithic solution.

## Workflow

*  Fork the project.
*  Make your code edit.
*  Update or add tests to avoid the change breaking in future releases.
*  Run `composer update` to update composer packages and commit new composer.lock.
*  Run `composer build` and ensure PSR Standards are adhered to.
*  Test your changes using `composer test`.
*  Submit a [pull request](https://github.com/ouxsoft/phpmarkup-dev/pulls).

## Coding Guidelines

*  PHPMarkup uses Laminas Framework (formally Zend Framework).
*  PHPMarkup implements a builder design pattern.
*  PHPMarkup use PHPDocs blocks.
*  Classes use S.O.L.I.D. Design Principle.
*  Work to improve Code Score on [Codacy](https://app.codacy.com/manual/hxtree/PHPMarkup).

## Setting up Development Environment

For the development environment, see [PHPMarkup-Dev](https://github.com/ouxsoft/phpmarkup-dev)

Don't push to master.
```
git config branch.master.pushRemote no_push
```

## Reporting issues

Please report issue and open new tickets:

*  [Report Issues](https://github.com/ouxsoft/livingMarkup/issues)