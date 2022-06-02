<?php

namespace Objement\DialFireApi;

use Exception;

class HttpJsonRequester
{
    const PAYLOAD_TYPE_JSON = 'json';
    const PAYLOAD_TYPE_CSV = 'csv';

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
    private function getCurlHandle($url, $httpHeaders)
    {
        $url = $this->buildUrl($url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($httpHeaders, ['Authorization: Bearer '.$this->bearerToken]));
        curl_setopt($ch, CURLINFO_HEADER_OUT, true); // enable tracking

        return $ch;
    }

    /**
     * @param resource $ch
     * @return object
     */
    private function processCurlRequest($ch): object {
        $result = curl_exec($ch);

        if (curl_errno($ch))  {
            throw new Exception('An error occurred. '.curl_error($ch));
        }


        curl_close($ch);

        return json_decode($result, false);
    }

    /**
     * @param $url
     * @param $payload
     * @return object
     * @throws Exception
     */
    public function post($url, $payload, $payloadType = self::PAYLOAD_TYPE_JSON): object
    {
        $ch = $this->getCurlHandle($url, ['Content-Type: text/data; charset=utf-8']);

        if ($payloadType == self::PAYLOAD_TYPE_JSON) {
            $payload = json_encode($payload);
        }

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return $this->processCurlRequest($ch);
    }

    /**
     * @param $url
     * @param $payload
     * @return object
     * @throws Exception
     */
    public function put($url, $payload, $payloadType = self::PAYLOAD_TYPE_JSON): object
    {
        $ch = $this->getCurlHandle($url);

        if ($payloadType == self::PAYLOAD_TYPE_JSON) {
            $payload = json_encode($payload);
        }

        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
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
        $ch = $this->getCurlHandle($url);

        return $this->processCurlRequest($ch);
    }

    /**
     * @param string $url
     * @return object
     * @throws Exception
     */
    public function delete(string $url): object
    {
        $ch = $this->getCurlHandle($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        return $this->processCurlRequest($ch);
    }
}