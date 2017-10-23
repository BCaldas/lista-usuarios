<?php
namespace lib;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;

class RequestHandler
{
    private $client;


    public function __construct($baseUri)
    {
        $this->client = new Client(['base_uri' => $baseUri]);
    }

    public function get($uri = null)
    {
        $response = null;
        try {
            $response = $this->client->get($uri,[
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'verify' => false]);

            return $response;

        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }
    }
}