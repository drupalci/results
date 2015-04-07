DrupalCI Results - CLI
======================

## Overview

Command line client for the results site.
It assumes you should have composer installed.

```bash
$ curl -sS https://getcomposer.org/installer | php
$ mv composer.phar /usr/local/bin/composer
$ composer install
```

## Usage

```
Usage:
  [options] command [arguments]

Options:
  --help           -h Display this help message.
  --quiet          -q Do not output any message.
  --verbose        -v|vv|vvv Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
  --version        -V Display this application version.
  --ansi              Force ANSI output.
  --no-ansi           Disable ANSI output.
  --no-interaction -n Do not ask any interactive question.

Available commands:
  create     Create a new build on the results site.
  help       Displays help for a command
  list       Lists commands
  progress   Progress the state of the build on the results site.
  states     Show the states that can be set on the remote build site.
  summary    Generate a summary message based on the artefacts.
  upload     Upload the build artefacts to the results site bulid.
```

## Example

### Configuration file

This contains the common configuration for the Results CLI. That file can be found here:

```
~/.drupalci-results.yml
```

Here is an example file:

```bash
# Basic configuration.
jenkins:
  user: "admin"
  pass: "password"
  host:  "http://drupalci-results.dev"

# Used for storing artefacts.
s3:
  bucket: "drupalci-results"
  key:    "XXXXXXXXXXXXXXXXXXXX"
  secret: "XXXXXXXXXXXXXXXXXXXX"
```

### Using the CLI

This is an example of progressing a build from:
* Brand new
* Setting the build to "Building"
* Submitting the build results summary
* Uploading build artefacts

```
# Check the config file.
$ cat ~/.drupalci-results.yml

# Create a new build.
$ BUILD=$(php bin/results-cli create --title="#123234234 - 1 - Test my stuff")

# Get the build states.
$ php bin/results-cli states

+----+----------+------------+
| ID | Name     | Percentage |
+----+----------+------------+
| 1  | New      | 20%        |
| 2  | Building | 60%        |
| 3  | Failed   | 100%       |
| 4  | Passed   | 100%       |
+----+----------+------------+

# Progress a build.
$ php bin/results-cli progress --state="2" --build=$BUILD

Updated build to the state: 2

# Generate a summary.
$ ls -l tests/assets
$ php bin/results-cli summary --sqlite="tests/assets/test.sqlite"

Assertions: 12, Failures: 113 and 1000 errors.

# Submit a summary.
$ php bin/results-cli summary --sqlite="tests/assets/test.sqlite" --build=$BUILD

Assertions: 12, Failures: 113 and 1000 errors.

# Upload the artefacts.
$ php bin/results-cli upload --artefacts="tests/assets" --build=$BUILD

Successfully upload artefacts to build: 13

# Mark the build as "passed".
$ php bin/results-cli progress --build=$BUILD --state="4"

Updated build to the state: 4
```
