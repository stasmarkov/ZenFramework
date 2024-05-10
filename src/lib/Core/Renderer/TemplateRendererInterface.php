<?php

declare(strict_types=1);

namespace ZenFramework\Core\Renderer;

/**
 * The renderer service.
 */
interface TemplateRendererInterface {

  /**
   * Render the template.
   *
   * @param string $template_name
   *   The template name.
   * @param array $arguments
   *   List of arguments.
   *
   * @return string
   *   The rendered result.
   */
  public function render(string $template_name, array $arguments = []): string;

}
