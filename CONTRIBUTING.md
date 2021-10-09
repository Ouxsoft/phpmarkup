# Contributing to phpmarkup

First off, thanks for taking the time to contribute!

## Workflow
For local package development use [Docker](https://www.docker.com/products/docker-desktop):

### Step 1
*  Pull code and build Test container.
*  Fork the project.

```
git clone https://github.com/Ouxsoft/phpmarkup.git
cd phpmarkup
docker build --target test --tag phpmarkup:latest -f Dockerfile .
docker run -it --mount type=bind,source="$(pwd)"/,target=/application/ phpmarkup:latest composer install
```

### Step 2
*  Make your code changes using CODING_STANDARDS.md.
*  Run Automated QA using local volume.
*  Test your changes using `composer test`.
*  Update or add tests to avoid the change breaking in future releases.

```
docker run -it --mount type=bind,source="$(pwd)"/,target=/application/ phpmarkup:latest composer qa
```

### Step 4
*  Run `composer update` to update composer packages and commit new `composer.lock` file.
*  Rebuild Docs

```
docker build --target docs --tag phpmarkup:docs-latest -f Dockerfile .
docker run -it --mount type=bind,source="$(pwd)"/,target=/app/ phpmarkup:docs-latest bash -c "cd /app/docs && doxygen Doxyfile && doxyphp2sphinx Ouxsoft::PHPMarkup"
```

### Step 5
*  Submit a [pull request](https://github.com/ouxsoft/phpmarkup-dev/pulls).

## Reporting issues

Please report issue and open new tickets:

*  [Report Issues](https://github.com/ouxsoft/livingMarkup/issues)
