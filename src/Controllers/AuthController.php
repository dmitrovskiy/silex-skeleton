<?php

namespace Controllers;

use Services\TransactionService;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthController
 *
 * @package Controllers
 */
class AuthController extends AbstractController
{
    /**
     * @var TransactionService
     */
    private $transactionService;

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->post('/', 'Controllers\AuthController:authAction');

        return $controllers;
    }

    public function initialize()
    {
        $this->transactionService = $this->app['Services\TransactionService'];
    }

    public function authAction(Request $request)
    {
        $data = $request->request->all();
        $authResult = $this->transactionService->authenticate($data['login'], $data['password']);

        return $this->json($authResult);
    }
}