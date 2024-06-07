# Register App (Unreleased - WIP)

## Introduction
Howdy! This portfolio project is part of a [wider project](https://github.com/users/ajbleakley/projects/1) to build a simple, distributed system with user account management and authentication features.

This repository is for the registration application - a (basic) RESTful API that facilitates user account management.

The project goal is not to produce a finished system but to help demonstrate my current skillset at the project planning and technical implementation levels to prospective employers.

For more information about the project, please refer to the [full project description](https://github.com/users/ajbleakley/projects/1) - please click the "Project Details" icon (top-right of project view).

## Requirements

To run the project locally, you will need to have Docker installed on your host machine. Install [Docker Desktop](https://www.docker.com/products/docker-desktop/).

[Postman](https://www.postman.com/) API platform is useful too, because you can download and import [this Postman collection](docs/postman_collection.json) to start exploring the API.

## Getting Started

To build and serve the application environment, simply run:
```
docker compose up --build -d
```

Ping the application to check it's running locally: http://localhost:8000/api/ping

Then explore the API using either the [API documentation](docs/openapi.yaml) or the [Postman collection](docs/postman_collection.json).

## Progress Summary

- [Introduce and plan project](https://github.com/users/ajbleakley/projects/1) ✅ (Please click the "Project Details" icon (top-right of project view))
- [Design API documentation](docs/openapi.yaml) ✅ (WIP - copy/paste the source code into [this online editor](https://editor.swagger.io/) to view)
- Setup project environment on Docker ✅ (WIP - currently a solid starting point)
- Add API endpoint to create a user  ✅ (Working example available in [Postman collection](docs/postman_collection.json))
- Implement rest of [API design](docs/openapi.yaml) (TODO)
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

To copy application dependencies from the container to your host:
```
docker cp register-app-php-fpm-1:/application/vendor/ ~/your/host/path/to/register-app
```
> Note - you will need Composer/PHP installed on your host machine to run composer commands outside of the container.
