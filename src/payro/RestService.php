<?php

namespace payro24\payro;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Request handler.
 */
class RestService
{
    protected $sandBox = true;
    protected $apiKey = 'Your API KEY'; // panel.payro24.ir
    protected $endpoint = 'https://api.payro24.ir/v1.0/';

    /**
     * Create payment request.
     *
     * @param $data
     *
     * @return array
     */
    public function paymentRequest($data)
    {
        $result = $this->httpRequest('payment', $data);

        if ($result['code'] == 201) {
            return [
                'Status' => 'success',
                'Result' => $result['data'],
            ];
        } else {
            return [
                'Status' => 'error',
                'Message' => !empty($result['message']) ? $result['message'] : null,
            ];
        }
    }

    /**
     * Inquiry request.
     *
     * @param $inputs
     *
     * @return array
     */
    public function inquiryRequest($data)
    {
        $result = $this->httpRequest('payment/inquiry', $data);

        if ($result['code'] == 200) {
            return [
                'Status' => 'success',
                'Result' => $result['data'],
            ];
        } else {
            return [
                'Status' => 'error',
                'Message'  => !empty($result['message']) ? $result['message'] : null,
            ];
        }
    }

    /**
     * Send request by Client api pass response.
     *
     * @param $resource
     * @param $data
     *
     * @return mixed
     */
    private function httpRequest($resource, $data)
    {
        try {
            $client = new Client(['base_uri' => $this->endpoint]);
            $response = $client->request(
                'POST', $resource, [
                    'json' => $data,
                    'headers' => [
                        'Accept'    => 'application/json',
                        'P-TOKEN' => $this->apiKey,
                        'P-SANDBOX' => $this->sandBox
                    ]
                ]
            );

            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);

            return [
                'Status' => true,
                'code' => $response->getStatusCode(),
                'data' => $result,
            ];
        } catch (RequestException $e) {

            $result = [
                'Status' => false,
                'message' => "Connection failed.",
            ];

            $response = $e->getResponse();
            if (!is_null($response)) {
                $result['message'] = $response->getBody()->getContents();
                $result['message'] = json_decode($result['message'], true);
                $result['code'] = $response->getStatusCode();
            }

            return $result;
        }
    }

    /**
     * @param mixed $endpoint
     *
     * @return void
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @param mixed $apiKey
     *
     * @return void
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Set sandbox mode.
     * 
     * @return void
     */
    public function setSandBox()
    {
        $this->sandBox = true;
    }
}