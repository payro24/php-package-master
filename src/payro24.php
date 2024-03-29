<?php

namespace payro24;

use payro24\payro\RestService;

define('PENDING', 1);
define('RETURNED', 2);
define('FAILED', 3);
define('SUCCESS', 100);

class payro24
{
    private $service;
    private $trackId;
    private $data;
    private $paymentPath = 'https://www.payro24.ir/link/';

    public function __construct($apiKey, $endpoint, $sandbox = false)
    {
        $this->service = new RestService();
        $this->service->setEndpoint($endpoint);
        $this->service->setApiKey($apiKey);
        if ($sandbox) {
            $this->service->setSandBox();
        }
    }

    /**
     * Create new payment on payro24
     * Get payment path and payment id.
     *
     * @param string $callback
     * @param string $amount
     * @param string $name
     * @param string $phone
     * @param string $description
     *
     * @return array|@paymentPath
     */
    public function payment($callback, $orderId, $amount, $name = null, $mail = null, $phone = null, $description = null)
    {
        $data = [
            'amount'    => $amount,
            'order_id'  => $orderId,
            'callback'  => $callback,
        ];

        if (!is_null($name) && !empty($name)) {
            $data['name'] = $name;
        }
        if (!is_null($mail) && !empty($mail)) {
            $data['mail'] = $mail;
        }
        if (!is_null($phone) && !empty($phone)) {
            $data['phone'] = $phone;
        }
        if (!is_null($description) && !empty($description)) {
            $data['desc'] = $description;
        }

        $result = $this->service->paymentRequest($data);

        var_dump($result);

        if ($result['Status'] == 'success') {
            if (isset($result['Result'])) {
                $this->trackId = $result['Result']['id'];
                $this->paymentPath = $result['Result']['link'];
            }

            return $result['Result'];
        }

        return false;
    }

    /**
     * Inquiry payment result by trackId and orderId.
     *
     * @param $trackId
     * @param $orderId
     *
     * @return array
     */
    public function inquiry($trackId, $orderId, $amount)
    {
        $data = [
            'id' => $trackId,
            'order_id'  => $orderId
        ];

        $result = $this->service->inquiryRequest($data);
        $result['Success'] = !empty($result['Result']['amount'])
            && $result['Result']['amount'] == $amount
            && $result['Result']['status'] == SUCCESS;

        return $result;
    }

    /**
     * Redirect user to the received payment path.
     */
    public function gotoPaymentPath()
    {
        header('Location: '. $this->paymentPath);
        exit;
    }

    /**
     * Check received data on payment callback.
     *
     * @return boolean
     */
    public function receiveData()
    {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $this->trackId = $_POST['id'];
            $this->data = $_POST;

            return true;
        }

        return false;
    }

    /**
     * Get track id of payment.
     *
     * @return string
     */
    public function getTrackId()
    {
        return $this->trackId;
    }
}