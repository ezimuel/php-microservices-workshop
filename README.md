# Developing microservices in PHP using Expressive + Swoole + ELK stack

## Install using Vagrant

You can use [Vagrant](https://www.vagrantup.com/) to setup a Linux
environment to run the `php-microservices-workshop` application.

This setup will install the following environment:

- Linux Ubuntu 18.04
- PHP 7.3
- Swoole
- Elasticsearch 6.6.2, Kibana 6.6.2

In order to run Vagrant you need a VM hypervisor like [VirtualBox](https://www.virtualbox.org/)
that can be execute on Win, Mac and Linux operating systems.

To execute the Vagrant box you can use the command as follows:

```bash
vagrant up
```

This will require some times (the first execution). When finished, you can see
the application running at `localhost:8080` using [Swoole](https://www.swoole.co.uk/).

The project directory in the VM machine is `/home/vagrant/php-microservices-workshop`.

If you want to connect to the VM you can SSH into it, using the command:

```bash
vagrant ssh
```

If you want to close/stop the VM you can use the following command:

```bash
vagrant destroy
```

## Install using Docker

To execute the `php-microservices-workshop` application using [Docker](https://www.docker.com/)
you need to run the following command:

```bash
docker-compose up
```

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

You need to install also [Swoole](https://www.swoole.co.uk/docs/get-started/installation),
[Elasticsearch](https://www.elastic.co/guide/en/elasticsearch/reference/6.6/getting-started-install.html),
and [Kibana](https://www.elastic.co/guide/en/kibana/6.6/install.html).

## Enable development mode

If you want to customize the application I suggest to enable the development
mode using the following command:

```
composer development-enable
```
