# Symfony-REST-Project

## Description

This project is an REST API whit Symfony for Epitech school

## Prerequisite
- php version 7.4.16 (installable with xampp)
- xampp version 3.2.4
- Composer version 2.0.11
- Symfony cli version 4.23.2
- Symfony version 5.2
- MariaDB version 10.4.18

## Install
1. Clone this repo in local `git clone https://github.com/Zachari-Blinn/Symfony-REST-Project`
2. Move to api directory `cd ./api`
3. Install dependencies `composer update`
4. Create Database `php bin/console doctrine:database:create`
5. start the project with `symfony serve -d --no-tls`

## Commands
Launch Symfony
```md
symfony serve -d --no-tls
```

Create DataBase
```md
php bin/console doctrine:database:create
```

Create Entity
```md
php bin/console make:entity
```

Make Migration
```md
php bin/console make:migration
```
```md
php bin/console doctrine:migrations:migrate
```
or
```md
php bin/console doctrine:schema:update --force
```
