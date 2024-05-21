<?php

declare(strict_types=1);

namespace ZenFramework\Core\Events;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The response event.
 */
class RequestEvent extends Event {

  /**
   * Constructs the ResponseEvent class.
   *
   * @param \Symfony\Component\HttpFoundation\Response $response
   *   The response.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   */
  public function __construct(
    private Response $response,
    private Request $request,
  ) {}

  /**
   * Get response.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The response.
   */
  public function getResponse(): Response {
    return $this->response;
  }

  /**
   * Set response.
   *
   * @param \Symfony\Component\HttpFoundation\Response $response
   *   The response.
   */
  public function setResponse(Response $response): void {
    $this->response = $response;
  }

  /**
   * Get the request.
   *
   * @return \Symfony\Component\HttpFoundation\Request
   *   The request.
   */
  public function getRequest(): Request {
    return $this->request;
  }

  /**
   * Set the request.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   */
  public function setRequest(Request $request): void {
    $this->request = $request;
  }

}
