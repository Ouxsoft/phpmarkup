# Contributing to phpmarkup

First off, thanks for taking the time to contribute!

For local package development use [Docker](https://www.docker.com/products/docker-desktop):

Build Test container
```
git clone https://github.com/Ouxsoft/phpmarkup.git
cd phpmarkup
docker build --target test --tag phpmarkup:latest -f Dockerfile .
docker run -it --mount type=bind,source="$(pwd)"/,target=/application/ phpmarkup:latest composer install
```

Run Automated Unit Tests using local volume
```
docker run -it --mount type=bind,source="$(pwd)"/,target=/application/ phpmarkup:latest composer test
```

Run Automated Benchmark Tests using local volume
```
docker run -it --mount type=bind,source="$(pwd)"/,target=/application/ phpmarkup:latest ./vendor/bin/phpbench run tests/src/Benchmark --report=default
```

Rebuild Docs
```
docker build --target docs --tag phpmarkup:docs-latest -f Dockerfile .
docker run -it --mount type=bind,source="$(pwd)"/,target=/app/ phpmarkup:docs-latest bash -c "cd /app/docs && doxygen Doxyfile && doxyphp2sphinx Ouxsoft::PHPMarkup"
```
