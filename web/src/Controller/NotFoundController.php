<?php

declare(strict_types = 1);

namespace ZenFramework\Controller;

use ZenFramework\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The user controller.
 */
class NotFoundController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function index(Request $request): Response {
    $response = new Response();
    $response->setContent($this->renderer->render('404.html.twig'));
    $response->setStatusCode(404);
    return $response;
  }

}
