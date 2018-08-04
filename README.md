Baby Share
===============

[![Build Status](https://travis-ci.org/geoffrey-chameroy/baby-share.svg?branch=master)](https://travis-ci.org/geoffrey-chameroy/baby-share)

Installing Application
----------------------

The easiest way to install this application is by using [Docker](https://www.docker.com/)

```bash
$> cp docker-compose.override.yml.dist docker-compose.override.yml
$> docker-compose up -d
```

After that you'll have to install dependencies and database
```bash
$> docker-compose exec app composer install
$> docker-compose exec app php bin/console doctrine:database:create
$> docker-compose exec app php bin/console doctrine:schema:update -n 
```

Contributors
------------

- Geoffrey Chameroy
