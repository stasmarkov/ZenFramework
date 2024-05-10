<?php

declare(strict_types = 1);

namespace ZenFramework\Controller;

use ZenFramework\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The user controller.
 */
class UserController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function index(string $name, Request $request): Response {
    $response = new Response();
    $response->setContent($this->renderer->render('user.html.twig', [
      'name' => $name,
      'age' => 29,
      'time' => time(),
    ]));
    $response->setTtl(5);
    return $response;
  }

}
