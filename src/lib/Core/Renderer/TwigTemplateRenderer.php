<?php

declare(strict_types = 1);

namespace ZenFramework\Core\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * The twig renderer interface.
 */
class TwigTemplateRenderer implements TemplateRendererInterface {

  /**
   * {@inheritdoc}
   */
  public function render(string $template_name, array $arguments = []): string {
    $loader = new FilesystemLoader(ZENFRAMEWORK_ROOT . '/public/templates');
    return (new Environment($loader))->render($template_name, $arguments);
  }

}
