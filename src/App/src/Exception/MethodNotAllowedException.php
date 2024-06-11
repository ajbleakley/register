<?php

declare(strict_types=1);

namespace App\Exception;

use DomainException;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class MethodNotAllowedException extends DomainException implements ProblemDetailsExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(string $message): self
    {
        $e         = new self($message);
        $e->status = 405;
        $e->detail = $message;
        $e->type   = '/api/v1/doc/method-not-allowed-error';
        $e->title  = 'Method is not allowed';
        return $e;
    }
}
