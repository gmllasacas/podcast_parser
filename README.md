
# About

Laravel 8.x application that parses and store the data from a podcast RSS feed given the URL using the command line, details of the process:

- Validation of the URL
- Validation of the XML
- Store the data of the podcast and its episodes on a database
- Includes feature tests

# Installation

Clone the repository with the following command:

```bash
git clone https://github.com/gmllasacas/podcast_parser.git
```

The dependencies are managed by composer, execute the command:

```bash
composer update
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