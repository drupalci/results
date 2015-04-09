The canonical copy of this project lives @ https://www.drupal.org/project/drupalci_results

DrupalCI Results
================

## Overview

Build reporting for build projects.


## Diagram

![Diagram](docs/diagram.png "Diagram")

## Build

**Local**

```bash
$ vagrant up
$ vagrant provision
$ vagrant ssh
$ cd /var/www/results
$ phing
```
Point web browser at `192.168.50.10`

**Credentials**

The following will setup your authentication to AWS.

```bash
$ export AWS_ACCESS_KEY='Super secret access key'
$ export AWS_SECRET_KEY='Super secret secret key'
```

**Standard build**

```bash
$ packer build packer/packer.json
```

**Build off a different base AMI**

```bash
$ packer build -var 'source_ami=ami-123456' packer/packer.json
```
