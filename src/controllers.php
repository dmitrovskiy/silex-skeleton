<?php

use Services\TransactionService;
use Controllers\IndexController;
use Controllers\AuthController;
use Controllers\UsersController;

$app->register(
    new TransactionService($app),
    [
        'Services\TransactionService.endpoint' => 'http://9eba26e.ngrok.com'
    ]
);
$app->register(new IndexController($app));
$app->register(new AuthController($app));
$app->register(new UsersController($app));

$app->mount('/', new IndexController($app));
$app->mount('/auth', new AuthController($app));
$app->mount('/users', new UsersController($app));