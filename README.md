# Register App

## Introduction
Howdy! This portfolio project is part of a [wider project](https://github.com/users/ajbleakley/projects/1) to build a simple, distributed system with user account management and authentication features.

This repository is for the registration application - a (basic) RESTful API that facilitates user account management.

The project goal is not to produce a finished system but to help demonstrate my current skillset at the project planning and technical implementation levels to prospective employers.

For more information about the project, please refer to the [full project description](https://github.com/users/ajbleakley/projects/1) - please click the "Project Details" icon (top-right of project view).

## Requirements

To run the project locally, you will need to have Docker installed on your host machine. Install [Docker Desktop](https://www.docker.com/products/docker-desktop/).

## Getting Started

Running the application environment is simple:

1. Run `composer install` to install project dependencies.
2. Run `docker compose up -d` to build and serve the application environment.
3. Visit http://localhost:8000/api/ping in your web browser to verify the application is running.

## Progress Summary

- [Introduce and plan project](https://github.com/users/ajbleakley/projects/1) ✅ (Please click the "Project Details" icon (top-right of project view))
- [Design API documentation](docs/openapi.yaml) ✅ (WIP - currently missing API endpoint(s) to facilitate authentication)
- Setup project environment on Docker ✅ (WIP - currently a solid starting point)
- Implement API design (TODO)
- End-to-end testing (TODO)
- API client application (TODO)

## Links

- [Project management board](https://github.com/users/ajbleakley/projects/1) - for an indication of progress and features coming soon.
- [API documentation](docs/openapi.yaml) - OpenAPI Specification currently acting as the design for the project (WIP).

## Useful Commands

To run composer commands inside the application container:
```
docker exec -it register-app-php-fpm-1 composer ...
```

To copy project dependencies from the container to your host:
```
docker cp register-app-php-fpm-1:/application/vendor/ ~/your/host/path/to/register-app
```
> Note - you will need Composer/PHP installed on your host machine to run composer commands outside of the container.
