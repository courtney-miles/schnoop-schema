# Contributing

## Requirements

Docker is provided used to make development easier.  To take advantage of this, ensure Docker and Docker Compose is installed on your system.

* [Docker](https://docs.docker.com/install/)
* [Docker-compose](https://docs.docker.com/compose/install/)

## Getting Started

1. Fork Slurp from Github: https://github.com/courtney-miles/schnoop-schema
2. Clone your repository to your development box.
2. Run the tests.
    ```bash
   ./docker-run-tests.sh
    ```

## Check your code style

Before pushing any code changes you should check your code style. The package [FriendsOfPHP/PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) is used to check and correct coding styles.

To check your styles using docker, run the following command.

```bash
./docker-style-check.sh
```

To fix you code automatically, run the following command.

```bash
./docker-style-check.sh
```