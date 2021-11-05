<?php
/*
 * Copyright (c) 2021, Bastian Leicht <mail@bastianleicht.de>
 *
 * PDX-License-Identifier: BSD-2-Clause
 */

namespace SubServices;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use SubServices\Exception\ParameterException;
use SubServices\Instance\Instance;

class SubServices
{
    private $httpClient;
    private $credentials;
    private $apiToken;

    /**
     * SubServices constructor.
     *
     * @param string    $token      API Token for all requests
     * @param null      $httpClient
     */
    public function __construct(
        string $token,
        $httpClient = null
    ) {
        $this->apiToken = $token;
        $this->setHttpClient($httpClient);
        $this->setCredentials($token);
    }

    /**
     * @param $httpClient Client|null
     */
    private function setHttpClient(Client $httpClient = null): void
    {
        $this->httpClient = $httpClient ?: new Client([
            'follow_redirects' => true,
            'timeout' => 120,
        ]);
    }

    /**
     * @param $credentials
     */
    private function setCredentials($credentials): void
    {
        if (!$credentials instanceof Credentials) {
            $credentials = new Credentials($credentials);
        }

        $this->credentials = $credentials;
    }

    /**
     * Returns the HTTP Client.
     * @return Client
     */
    private function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    /**
     * Returns the API Token.
     * @return string
     */
    public function getToken(): string
    {
        return $this->apiToken;
    }

    /**
     * Returns the current Credentials.
     * @return Credentials
     */
    private function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    /**
     * Request function.
     * @param string    $actionPath The resource path you want to request, see more at the documentation.
     * @param array     $params     Array filled with request params
     * @param string    $method     HTTP method used in the request
     * @return ResponseInterface
     *
     * @throws ParameterException If the given field in params is not an array
     */
    private function request(string $actionPath, array $params = [], string $method = 'GET'): ResponseInterface
    {
        $url = $this->getCredentials()->getUrl() . $actionPath;

        if (!is_array($params)) {
            throw new ParameterException();
        }

        $params['Authorization'] = 'Bearer ' . $this->apiToken;

        switch ($method) {
            case 'GET':
                return $this->getHttpClient()->get($url, [
                    'verify' => false,
                    'query'  => $params,
                ]);
            case 'POST':
                return $this->getHttpClient()->post($url, [
                    'verify' => false,
                    'headers'  => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->apiToken,
                    ],
                    'form_params'   => $params,
                ]);
            case 'PUT':
                return $this->getHttpClient()->put($url, [
                    'verify' => false,
                    'headers'  => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->apiToken,
                    ],
                    'form_params'   => $params,
                ]);
            case 'DELETE':
                return $this->getHttpClient()->delete($url, [
                    'verify' => false,
                    'headers'  => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->apiToken,
                    ],
                    'form_params'   => $params,
                ]);
            default:
                throw new ParameterException('Wrong HTTP method passed');
        }
    }

    /**
     * Processes the Request and returns a stdObject.
     * @param $response ResponseInterface
     * @return array|string
     */
    private function processRequest(ResponseInterface $response)
    {
        $response = $response->getBody()->__toString();
        $result = json_decode($response);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $result;
        }

        return $response;
    }

    /**
     * Performs a GET Request.
     * @param $actionPath
     * @param array $params
     * @return array|string
     */
    public function get($actionPath, $params = [])
    {
        $response = $this->request($actionPath, $params);

        return $this->processRequest($response);
    }

    /**
     * Performs a PUT Request.
     * @param $actionPath
     * @param array $params
     * @return array|string
     */
    public function put($actionPath, $params = [])
    {
        $response = $this->request($actionPath, $params, 'PUT');

        return $this->processRequest($response);
    }

    /**
     * Performs a POST Request.
     * @param $actionPath
     * @param array $params
     * @return array|string
     */
    public function post($actionPath, $params = [])
    {
        $response = $this->request($actionPath, $params, 'POST');

        return $this->processRequest($response);
    }

    /**
     * Performs a DELETE Request.
     * @param $actionPath
     * @param array $params
     * @return array|string
     */
    public function delete($actionPath, $params = [])
    {
        $response = $this->request($actionPath, $params, 'DELETE');

        return $this->processRequest($response);
    }

    private $instanceHandler;

    /**
     * @return Instance
     */
    public function instance(): Instance
    {
        if (!$this->instanceHandler) $this->instanceHandler = new Instance($this);
        return $this->instanceHandler;
    }

    /**
     * Returns a list of all available Locations.
     * @return array|string
     */
    public function locationList()
    {
        return $this->get('location/list');
    }

    /**
     * @return array|string
     */
    public function user()
    {
        return $this->get('user');
    }

}
