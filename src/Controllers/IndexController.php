<?php

namespace Controllers;

use Silex\Application;

/**
 * Class IndexController
 *
 * @package Controllers
 */
class IndexController extends AbstractController
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'Controllers\IndexController:indexAction');

        return $controllers;
    }

    public function indexAction()
    {
        return $this->json(['greeting' => 'hello world!']);
    }
}