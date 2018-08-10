Baby Share
===============

[![buddy pipeline](https://app.buddy.works/geoffreychameroy/baby-share/pipelines/pipeline/147635/badge.svg?token=eae23eb4a245269757ce999d67a5c00771d4cde3c953cf735a0287df6be29452 "buddy pipeline")](https://app.buddy.works/geoffreychameroy/baby-share/pipelines/pipeline/147635)

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
