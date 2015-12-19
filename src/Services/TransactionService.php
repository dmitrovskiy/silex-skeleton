<?php

namespace Services;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * Class TransactionService
 *
 * @package Services
 */
class TransactionService extends AbstractService
{
    /** @var string */
    protected $endpoint;

    protected function initialize()
    {
        parent::initialize();

        $this->endpoint = $this->app['Services\TransactionService.endpoint'];
    }

    public function authenticate($login, $password)
    {
        return base64_decode($login . $password);
    }

    public function getUsers()
    {
        $client = new GuzzleClient();

        $request = new Request('get', "/users");

        try {
            $response = $this->send($client, $request);
            return $response;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param GuzzleClient $client
     * @param Request $request
     *
     * @return mixed
     */
    public function send(GuzzleClient $client, Request $request)
    {
        $uri = $request->getUri();
        $path = $this->endpoint . $uri->getPath();
        $uri = $uri->withPath($path);
        $request = $request->withUri($uri);

        try {
            $response = $client->send($request);
            return $response->getBody();
        } catch (GuzzleClientException $e) {
            throw new Exception('Auth service request error', $e);
        }
    }
}