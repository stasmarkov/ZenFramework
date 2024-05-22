<?php

declare(strict_types=1);

namespace ZenFramework\EventSubscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZenFramework\Core\Events\ResponseEvent;

/**
 * The google analytics event subscriber.
 */
class GoogleAnalyticsEventSubscriber implements EventSubscriberInterface {

  /**
   * The subscriber function.
   *
   * @param \ZenFramework\Core\Events\ResponseEvent $event
   *   The response.
   */
  public function onResponse(ResponseEvent $event): void {
    $response = $event->getResponse();
    $response->setContent($response->getContent() . 'GA ANALYTICS GOES HERE');
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      'kernel:response' => 'onResponse',
    ];
  }

}
