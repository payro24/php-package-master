<?php

/**
 * @file
 * Rest service handler by GuzzleHttp API.
 * 
 * PHP version ^5.6
 * 
 * @author  Amir Koulivand <amir@koulivand.ir>
 * @copyright   2016-2018 The payro24 group
 */

namespace payro24\Bin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Request handler.
 */
class RestService
{
    protected $sandBox = false;
    protected $apiKey = 'xxxx-xxxx-xxxx-xxxx';
    protected $endpoint = 'https://www.payro24.ir/api/service/v1/';

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