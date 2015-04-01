DrupalCI Results
================

## Overview

Build reporting for build projects.


## Diagram

![Diagram](docs/diagram.png "Diagram")

## Build

**Standard build**

```bash
$ packer build packer/packer.json
```

**Build off a different base AMI**

```bash
$ packer build -var 'source_ami=ami-123456' packer/packer.json
```
