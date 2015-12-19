<?php

namespace Controllers;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ServiceProviderInterface;

/**
 * Class AbstractController
 *
 * @package Controllers
 */
abstract class AbstractController implements ControllerProviderInterface, ServiceProviderInterface
{
    /** @var Application */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function register(Application $app)
    {
        $controller = get_called_class();
        $app[$controller] = $app->share(function () use ($app, $controller) {
            return new $controller($app);
        });
    }

    public function boot(Application $app)
    {
        $controller = get_called_class();
        $app[$controller]->initialize();
    }

    protected function initialize()
    {
    }

    protected function json($data)
    {
        return $this->app->json($data);
    }
}