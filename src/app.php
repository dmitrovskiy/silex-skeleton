<?php

use Silex\Application;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use JDesrosiers\Silex\Provider\CorsServiceProvider;

$app = new Application();
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new HttpFragmentServiceProvider());

// CORS support
$app->register(
    new CorsServiceProvider(),
    array(
        "cors.allowOrigin"   => "*",
        'cors.exposeHeaders' => "X-RateLimit-Remaining, X-Total-Count",
    )
);
$app->after($app['cors']);

$app->before(
    function (Request $request) {

        if (false !== strpos(
                $request->headers->get('Content-Type'),
                'json'
            )
            && $request->getContent() != ""
            && $request->getContent() != "null"
        ) {
            $data = json_decode($request->getContent(), true);

            if ($data === null) {
                throw new \Exception(
                    "Invalid JSON format"
                );
            }
            $request->request->replace(
                is_array($data) ? $data : array()
            );
        }
    }
);

return $app;
