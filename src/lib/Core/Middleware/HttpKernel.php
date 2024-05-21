<?php

declare(strict_types = 1);

namespace ZenFramework\Core\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class HttpKernel implements HttpKernelInterface {

  /**
   * {@inheritdoc}
   */
  public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = TRUE): Response {
    // TODO: Implement handle() method.
  }

}
