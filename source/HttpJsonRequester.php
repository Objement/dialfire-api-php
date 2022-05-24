<?php

namespace Objement\DialFireApi;

use Exception;

class HttpJsonRequester
{
    /**
     * @var string
     */
    private $baseUrl;
    /**
     * @var string
     */
    private $bearerToken;

    /**
     * @param string $baseUrl The base URL with trailing slash
     */
    public function __construct(string $baseUrl, string $bearerToken)
    {
        $this->baseUrl = $baseUrl;
        $this->bearerToken = $bearerToken;
    }

    private function buildUrl($url): string
    {
        return $this->baseUrl . $url;
    }

    /**
     * @param $url
     * @return resource
     */
    private function getCurlHandleForUrl($url)
    {
        $url = $this->buildUrl($url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$this->bearerToken));
        curl_setopt($ch, CURLINFO_HEADER_OUT, true); // enable tracking

        return $ch;
    }

    /**
     * @param resource $ch
     * @return object
     */
    private function processCurlRequest($ch): object {
        $result = curl_exec($ch);

        curl_close($ch);

        if (curl_errno($ch))  {
            throw new Exception('An error occurred. '.curl_error($ch));
        }

        return json_decode($result, false);
    }

    /**
     * @param $url
     * @param $payload
     * @return object
     * @throws Exception
     */
    public function post($url, $payload): object
    {
        $ch = $this->getCurlHandleForUrl($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return $this->processCurlRequest($ch);
    }

    /**
     * @param $url
     * @param $payload
     * @return object
     * @throws Exception
     */
    public function put($url, $payload): object
    {
        $ch = $this->getCurlHandleForUrl($url);

        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return $this->processCurlRequest($ch);
    }

    /**
     * @param string $url
     * @return object
     * @throws Exception
     */
    public function get(string $url): object
    {
        $ch = $this->getCurlHandleForUrl($url);

        return $this->processCurlRequest($ch);
    }

    /**
     * @param string $url
     * @return object
     * @throws Exception
     */
    public function delete(string $url): object
    {
        $ch = $this->getCurlHandleForUrl($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        return $this->processCurlRequest($ch);
    }
}