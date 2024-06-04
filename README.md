# Register App

## Introduction
A portfolio project - let's build a simple, distributed system with user account management and authentication features.

The project goal is not to produce a finished system but to help demonstrate my current skillset at the project planning and technical implementation levels to prospective employers.

For more information about the project, please refer to the [full project description](https://github.com/users/ajbleakley/projects/1) - please click the "Project Details" icon at the top right corner.

## Requirements

To run the project locally, you will need to have Docker installed on your machine. Install [Docker Desktop](https://www.docker.com/products/docker-desktop/)

A temporary requirement is to have Composer and PHP 8.0 installed on your machine. Instructions:
- [Install Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
- [Install PHP on Mac](https://www.geeksforgeeks.org/how-to-install-php-on-macos/)
- [Install PHP on Windows](https://www.geeksforgeeks.org/how-to-install-php-in-windows-10/)
- [Install PHP on Linux](https://www.geeksforgeeks.org/how-to-install-php-on-linux/)

> I plan to alter the docker compose configuration soon, so that Docker installs dependencies when spinning up the application container(s)

## Getting Started

Running the application environment is as simple as:

1. Run `composer install` to install project dependencies.
2. Run `docker compose up -d` to build and serve the application environment.
3. Visit http://localhost:8000/api/ping in your web browser to verify the application is running.

## Links

- [Project management board](https://github.com/users/ajbleakley/projects/1) - for an indication of progress and features coming soon.
- [API documentation](docs/openapi.yaml) - OpenAPI Specification currently acting as the design for the project (WIP).
