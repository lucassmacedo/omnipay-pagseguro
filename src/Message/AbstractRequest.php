<?php

namespace Omnipay\PagSeguro\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endpoint = 'https://ws.pagseguro.uol.com.br/v2';
    protected $sandboxEndpoint = 'https://ws.sandbox.pagseguro.uol.com.br/v2';
    protected $resource = '';

    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    public function getToken()
    {
        return $this->getParameter('token');
    }

    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    public function getSandbox()
    {
        return $this->getParameter('sandbox');
    }

    public function setSandbox($value)
    {
        return $this->setParameter('sandbox', $value);
    }

    public function getData()
    {
        $this->validate('email', 'token');

        return [
            'email' => $this->getEmail(),
            'token' => $this->getToken()
        ];
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function sendData($data)
    {
        $url = sprintf('%s/%s',
            $this->getEndpoint(),
            trim($this->getResource(), '/'));

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $httpResponse = $this->httpClient->request('POST', $url, $headers, http_build_query($data, '', '&'));

        return $this->createResponse(simplexml_load_string($httpResponse->getBody()->getContents()));
    }

    public function getEndpoint()
    {
        return $this->getSandbox() ? $this->sandboxEndpoint : $this->endpoint;
    }
}
