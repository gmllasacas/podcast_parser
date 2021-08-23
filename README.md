
# About

Laravel 8.x application that parses and store the data from a podcast RSS feed given the URL using the command line, details of the process:

- Validation of the URL
- Validation of the XML
- Store the data of the podcast and its episodes on a database
- Includes feature tests

# Installation

To run on local, clone the repository with the following command:

```bash
git clone https://github.com/gmllasacas/podcast_parser.git
```

The dependencies are managed by composer, after the clone execute the command on the application folder:

```bash
composer update
```

It was developed on a MySQL 5.7.x database with charset utf8mb4 and collation utf8mb4_unicode_ci, after the creation of this database change the config file .env at the root of the application

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=database_user
DB_PASSWORD=database_passwaord
```

# Usage

The parser requires an URL, execute the command to pass a valid URL without quotes:

```bash
php artisan parse:podcast "url"
```

The command displays informatives messages to understand the execution.

# Test

To run the feature tests, execute the command:

```bash
php artisan test
```