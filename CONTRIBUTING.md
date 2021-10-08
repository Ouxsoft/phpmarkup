# Contributing to phpmarkup

First off, thanks for taking the time to contribute!

For local package development use [Docker](https://www.docker.com/products/docker-desktop):

**Step 1**) Pull code and build Test container
```
git clone https://github.com/Ouxsoft/phpmarkup.git
cd phpmarkup
docker build --target test --tag phpmarkup:latest -f Dockerfile .
docker run -it --mount type=bind,source="$(pwd)"/,target=/application/ phpmarkup:latest composer install
```

**Step 2**) Make code changes.

**Step 3**) Run Automated QA using local volume
```
docker run -it --mount type=bind,source="$(pwd)"/,target=/application/ phpmarkup:latest composer qa
```

**Step 4**) Rebuild Docs
```
docker build --target docs --tag phpmarkup:docs-latest -f Dockerfile .
docker run -it --mount type=bind,source="$(pwd)"/,target=/app/ phpmarkup:docs-latest bash -c "cd /app/docs && doxygen Doxyfile && doxyphp2sphinx Ouxsoft::PHPMarkup"
```

**Step 5**) Submit PR