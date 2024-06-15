<?php

declare(strict_types=1);

use App\ADR\Action\API\CreateUserAction;
use App\ADR\Action\API\FetchUserAction;
use App\ADR\Action\API\ModifyUserAction;
use Mezzio\Application;
use Mezzio\Helper\BodyParams\BodyParamsMiddleware;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

/**
 * FastRoute route configuration
 *
 * @see https://github.com/nikic/FastRoute
 *
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/{id:\d+}', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');

    // API
    $app->get('/api/v1/users[/{identifier}]', [
        BodyParamsMiddleware::class,
        FetchUserAction::class,
    ], 'api.users');

    $app->post('/api/v1/users', [
        BodyParamsMiddleware::class,
        CreateUserAction::class,
    ]);

    $app->patch('/api/v1/users/{identifier}', [
        BodyParamsMiddleware::class,
        ModifyUserAction::class,
    ]);

    // API docs
    $app->get('/api/v1/doc/invalid-parameter', App\Doc\InvalidParameterHandler::class);
    $app->get('/api/v1/doc/method-not-allowed', App\Doc\MethodNotAllowedHandler::class);
    $app->get('/api/v1/doc/resource-not-found', App\Doc\ResourceNotFoundHandler::class);
    $app->get('/api/v1/doc/out-of-bounds', App\Doc\OutOfBoundsHandler::class);
    $app->get('/api/v1/doc/runtime-error', App\Doc\RuntimeErrorHandler::class);
};
