
# About

Laravel 8.x application that parses the data from a podcast RSS feed given the URL and then stores it on a MySQL 5.x database, using a generated artisan command, details of the process:

- Validation of the URL
- Validation of the XML
- Store the data of the podcast and its episodes on a database
- Includes feature tests

# Installation

## Application
To run on local, clone the repository with the following command:

```bash
git clone https://github.com/gmllasacas/podcast_parser.git
```

The dependencies are managed by composer, after the clone is done execute the command from the application folder:

```bash
composer update
```

## Database

Create a database with the following configuration:

- charset as utf8mb4 
- collation as utf8mb4_unicode_ci

Create a config file .env at the root of the application, then change the variables to match yours

```bash
...
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=database_user
DB_PASSWORD=database_passwaord
....
```

After this, execute the command to create the tables needed:

```bash
php artisan migrate
```

# Usage

The parser requires an URL, execute the command to pass a valid URL without quotes:

```bash
php artisan parse:podcast "url"
```

The command displays informative messages to understand the execution.

# Test

To run the feature tests, execute the command:

```bash
php artisan test
```