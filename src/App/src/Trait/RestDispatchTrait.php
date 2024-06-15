<?php

declare(strict_types=1);

namespace App\Trait;

use App\Exception\MethodNotAllowedException;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function method_exists;
use function sprintf;
use function strtolower;
use function strtoupper;

trait RestDispatchTrait
{
    private readonly ResourceGenerator $resourceGenerator;

    private readonly HalResponseFactory $responseFactory;

    /**
     * Proxies to method named after lowercase HTTP method, if present.
     *
     * Otherwise, returns an empty 501 response.
     *
     * {@inheritDoc}
     *
     * @throws MethodNotAllowedException if no matching method is found.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $method = strtolower($request->getMethod());
        if (method_exists($this, $method)) {
            return $this->$method($request);
        }
        throw MethodNotAllowedException::create(sprintf(
            'Method %s is not implemented for the requested resource',
            strtoupper($method)
        ));
    }

    /**
     * Create a HAL response from the given $instance, based on the incoming $request.
     */
    private function createResponse(ServerRequestInterface $request, object $instance): ResponseInterface
    {
        return $this->responseFactory->createResponse(
            $request,
            $this->resourceGenerator->fromObject($instance, $request)
        );
    }
}
