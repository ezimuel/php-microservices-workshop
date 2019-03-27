# Developing microservices in PHP using Expressive + Swoole + ELK stack

## Install using Vagrant

## Install using Docker

## Manual installation

You need to install the project using [composer](https://getcomposer.org/):

```
composer install
```

If you don't have composer installed globally please check [this documentation](https://getcomposer.org/doc/00-intro.md#globally).

Composer will install all the dependencies for this project.

After the installation you need to generate the SQLite database used as example.
It can be generated using the following command (from the root of the project):

```
sqlite3 data/db/users.sqlite < data/db/users.sql
```

## Enable development mode

If you want to customize the application I suggest to enable the development
mode using the following command:

```
composer development-enable
```
