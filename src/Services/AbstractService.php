<?php

namespace Services;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class AbstractService
 *
 * @package Services
 */
abstract class AbstractService implements ServiceProviderInterface
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
}