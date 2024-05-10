<?php

declare(strict_types = 1);

namespace ZenFramework\Core\Controller;

use ZenFramework\Core\Renderer\TemplateRendererInterface;
use ZenFramework\Core\Renderer\TwigTemplateRenderer;

/**
 * The controller base class.
 */
abstract class ControllerBase implements ControllerInterface {

  /**
   * Constructs the ControllerBase class.
   *
   * @param \ZenFramework\Core\Renderer\TemplateRendererInterface $renderer
   *   The renderer service.
   */
  public function __construct(
    protected TemplateRendererInterface $renderer = new TwigTemplateRenderer()
  ) {}

}
