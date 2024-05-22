<?php

declare(strict_types = 1);

namespace ZenFramework\Controller;

use ZenFramework\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Hub;
use Symfony\Component\Mercure\Jwt\StaticTokenProvider;
use Symfony\Component\Mercure\Update;

/**
 * The user controller.
 */
class MercurePublisher extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function index(Request $request): Response {
    // @todo Handle env variables properly.
    $hub = new Hub($_ENV['MERCURE_URL'], new StaticTokenProvider('eyJhbGciOiJIUzI1NiJ9.eyJtZXJjdXJlIjp7InB1Ymxpc2giOlsiKiJdfX0.PXwpfIGng6KObfZlcOXvcnWCJOWTFLtswGI5DZuWSK4'));
    // Serialize the update, and dispatch it to the hub,
    // that will broadcast it to the clients.
    $update = new Update('https://zen-framework.ddev.site/channel/test', json_encode(['value' => 'Hi from ZenFramework!' . date('d/m/y h:i;s')]));
    $hub->publish($update);

    $response = new Response();
    $response->setContent($this->renderer->render('mercure-publisher.html.twig'));
    return $response;
  }

}
