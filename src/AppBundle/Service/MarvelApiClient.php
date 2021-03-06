<?php

namespace AppBundle\Service;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class MarvelApiClient
{
    /**
     * @var string
     */
    private $baseUrl = 'http://gateway.marvel.com/v1/public/';

    /**
     * @var string
     */
    private $publicApiKey;

    /**
     * @var string
     */
    private $privateApiKey;

    /**
     * @param string $publicApiKey
     * @param string $privateApiKey
     */
    public function __construct(string $publicApiKey, string $privateApiKey)
    {
        $this->publicApiKey = $publicApiKey;
        $this->privateApiKey = $privateApiKey;
    }

    /**
     * Fetches lists of comic characters with optional filters.
     *
     * @param CharacterFilter|null $characterFilter
     *
     * @return CharacterDataWrapper
     */
    public function getCharacters(CharacterFilter $characterFilter = null) : Array
    {
        $response = $this->call('characters', $characterFilter);

        $response = $this->formatResponse($response);

        return $response;
    }

    /**
     * This method fetches a single character resource.
     *
     * @param int $id
     *
     * @return CharacterDataWrapper
     */
    public function getCharacter(int $id) : Array
    {
        $response = $this->call('characters/' . $id);

        $response = $this->formatResponse($response);

        return $response;
    }

    /**
     * @param string $operation
     * @param object|null $query
     *
     * @return Response
     */
    private function call(string $operation, $query = null) : Array
    {
        $url = $this->baseUrl . $operation;

        $params = array();
        if (!empty($query)) {
            $params = get_object_vars($query);
        }

        return $this->send($url, $params);
    }

    /**
     * @param string $url
     * @param array $params
     *
     * @return Response
     */
    private function send(string $url, array $params = array()) : Array
    {
        $client = new GuzzleClient();

        $query = [
            'ts' => time(),
            'apikey' => $this->publicApiKey,
            'hash' => md5(time() . $this->privateApiKey . $this->publicApiKey),
        ];

        foreach (array_filter($params) as $key => $value) {
            $query[$key] = $value;
        }

        try {
            $api_response = $client->request('GET', $url, ['query' => $query]);
            $formatted_response = json_decode($api_response->getBody()->getContents(),true);
            return $formatted_response;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                throw new ClientException($e->getMessage(), $e->getRequest());
            }
        }
    }

    /**
     * @param Response $response
     * @param string $dataWrapper
     *
     * @return Object
     */
    private function formatResponse($response)
    {
        if(count($response['data']['results']) > 1) {
            $response = $response['data']['results'];
        } else {
            $response = $response['data']['results'][0];
        }

        return $response;
    }
}