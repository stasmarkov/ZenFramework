<?php

declare(strict_types=1);


namespace ZenFramework\Core;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use ZenFramework\Core\Events\RequestEvent;
use ZenFramework\Core\Events\ResponseEvent;
use ZenFramework\Core\Renderer\TwigTemplateRenderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\CompiledUrlMatcher;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use ZenFramework\Controller\NotFoundController;
use ZenFramework\Controller\UserController;
use ZenFramework\EventSubscribers\GoogleAnalyticsEventSubscriber;

/**
 * The kernel class.
 */
class ZenFrameworkKernel implements HttpKernelInterface {

  /**
   * The renderer service.
   *
   * @var \ZenFramework\Core\Renderer\TwigTemplateRenderer
   */
  protected TwigTemplateRenderer $renderer;

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcher
   */
  protected EventDispatcher $eventDispatcher;

  /**
   * Constructs Kernel class.
   *
   * @param string $env
   *   The env type.
   * @param mixed $classLoader
   *   The class loader.
   */
  public function __construct(
    private string $env,
    private mixed  $classLoader,
  ) {
  }

  /**
   * Boots the current kernel.
   *
   * @return $this
   *   The kernel
   */
  public function boot() {
    $this->renderer = new TwigTemplateRenderer();
    $this->eventDispatcher = new EventDispatcher();
    return $this;
  }

  /**
   * Init event subscribers.
   */
  public function initSubscribers() {
    // @todo Add lookup subscribers.
    $this->eventDispatcher->addSubscriber(new GoogleAnalyticsEventSubscriber());
  }

  /**
   * {@inheritdoc}
   */
  public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = TRUE): Response {
    $this->boot();
    $this->initSubscribers();
    $response = new Response();

    $this->eventDispatcher->dispatch(new RequestEvent($response, $request), 'kernel:request');

    $routes = $this->registerRoutes();
    $context = new RequestContext();
    $url_matcher = new CompiledUrlMatcher($routes, $context);

    try {
      $request->attributes->add($url_matcher->match($request->getPathInfo()));
      $controller_resolver = new ControllerResolver();
      $argument_resolver = new ArgumentResolver();
      $controller = $controller_resolver->getController($request);
      $arguments = $argument_resolver->getArguments($request, $controller);
      $response = \call_user_func_array($controller, $arguments);
    }
    catch (ResourceNotFoundException $exception) {
      $response = \call_user_func([
        new NotFoundController($this->renderer),
        'index',
      ], $request);
    }
    catch (\Exception $exception) {
      $response = $this->handleException($exception, $request, $type);
    }

    $this->eventDispatcher->dispatch(new ResponseEvent($response, $request), 'kernel:response');

    $response->prepare($request);
    return $response;
  }

  /**
   * Handle the exception.
   *
   * @param \Exception $e
   *   The exception.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   * @param int $type
   *   The type of request.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The response.
   *
   * @throws \Exception
   *   Throws expception.
   */
  protected function handleException(\Exception $e, Request $request, int $type): Response {
    if ($e instanceof HttpExceptionInterface) {
      $response = new Response($e->getMessage(), $e->getCode());
      $response->headers->add($e->getHeaders());
      return $response;
    }

    throw $e;
  }

  /**
   * Register routes.
   *
   * @return array
   *   The route collection.
   */
  protected function registerRoutes(): array {
    // @todo Add lookup routes.
    $routes = new RouteCollection();
    $routes->add('user', new Route('/user/{name}', [
      '_controller' => [new UserController($this->renderer), 'index'],
    ]));
    $routes->add('404', new Route('/404', [
      '_controller' => [new NotFoundController($this->renderer), 'index'],
    ]));
    return (new CompiledUrlMatcherDumper($routes))->getCompiledRoutes();
  }

}
