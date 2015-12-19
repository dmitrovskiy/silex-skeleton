<?php

namespace Controllers;

use Silex\Application;
use Services\TransactionService;

/**
 * Class IndexController
 *
 * @package Controllers
 */
class UsersController extends AbstractController
{
    /** @var TransactionService */
    private $transactionService;

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'Controllers\UsersController:indexAction');

        return $controllers;
    }

    protected function initialize()
    {
        parent::initialize();

        $this->transactionService = $this->app['Services\TransactionService'];
    }

    public function indexAction()
    {
        return $this->transactionService->getUsers();
    }
}