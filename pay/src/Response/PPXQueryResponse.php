<?php

namespace PingPong\src\Response;

class PPXQueryResponse extends AbstractPPXResponse
{
    protected $accId;
    protected $amount;
    protected $channel;
    protected $clientId;
    protected $currency;
    protected $description;
    protected $merchantTransactionId;
    protected $notificationUrl;
    protected $paymentType;
    protected $relateTransactionId;
    protected $shopperResultUrl;
    protected $sign;
    protected $signType;
    protected $status;
    protected $transactionId;
    protected $transactionTime;


    /**
     * @param mixed $accId
     * @return PPXQueryResponse
     */
    public function setAccId($accId): PPXQueryResponse
    {
        $this->accId = $accId;
        return $this;
    }

    /**
     * @param mixed $amount
     * @return PPXQueryResponse
     */
    public function setAmount($amount): PPXQueryResponse
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param mixed $channel
     * @return PPXQueryResponse
     */
    public function setChannel($channel): PPXQueryResponse
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @param mixed $clientId
     * @return PPXQueryResponse
     */
    public function setClientId($clientId): PPXQueryResponse
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @param mixed $currency
     * @return PPXQueryResponse
     */
    public function setCurrency($currency): PPXQueryResponse
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @param mixed $merchantTransactionId
     * @return PPXQueryResponse
     */
    public function setMerchantTransactionId($merchantTransactionId): PPXQueryResponse
    {
        $this->merchantTransactionId = $merchantTransactionId;
        return $this;
    }

    /**
     * @param mixed $notificationUrl
     * @return PPXQueryResponse
     */
    public function setNotificationUrl($notificationUrl): PPXQueryResponse
    {
        $this->notificationUrl = $notificationUrl;
        return $this;
    }

    /**
     * @param mixed $paymentType
     * @return PPXQueryResponse
     */
    public function setPaymentType($paymentType): PPXQueryResponse
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    /**
     * @param mixed $relateTransactionId
     * @return PPXQueryResponse
     */
    public function setRelateTransactionId($relateTransactionId): PPXQueryResponse
    {
        $this->relateTransactionId = $relateTransactionId;
        return $this;
    }

    /**
     * @param mixed $shopperResultUrl
     * @return PPXQueryResponse
     */
    public function setShopperResultUrl($shopperResultUrl): PPXQueryResponse
    {
        $this->shopperResultUrl = $shopperResultUrl;
        return $this;
    }

    /**
     * @param mixed $sign
     * @return PPXQueryResponse
     */
    public function setSign($sign): PPXQueryResponse
    {
        $this->sign = $sign;
        return $this;
    }

    /**
     * @param mixed $signType
     * @return PPXQueryResponse
     */
    public function setSignType($signType): PPXQueryResponse
    {
        $this->signType = $signType;
        return $this;
    }

    /**
     * @param mixed $status
     * @return PPXQueryResponse
     */
    public function setStatus($status): PPXQueryResponse
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param mixed $transactionId
     * @return PPXQueryResponse
     */
    public function setTransactionId($transactionId): PPXQueryResponse
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * @param mixed $transactionTime
     * @return PPXQueryResponse
     */
    public function setTransactionTime($transactionTime): PPXQueryResponse
    {
        $this->transactionTime = $transactionTime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccId()
    {
        return $this->accId;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return mixed
     */
    public function getMerchantTransactionId()
    {
        return $this->merchantTransactionId;
    }

    /**
     * @return mixed
     */
    public function getNotificationUrl()
    {
        return $this->notificationUrl;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @return mixed
     */
    public function getRelateTransactionId()
    {
        return $this->relateTransactionId;
    }

    /**
     * @return mixed
     */
    public function getShopperResultUrl()
    {
        return $this->shopperResultUrl;
    }

    /**
     * @return mixed
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @return mixed
     */
    public function getSignType()
    {
        return $this->signType;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return mixed
     */
    public function getTransactionTime()
    {
        return $this->transactionTime;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return PPXQueryResponse
     */
    public function setDescription($description): PPXQueryResponse
    {
        $this->description = $description;
        return $this;
    }

    public function toString()
    {
        return json_encode(get_object_vars($this));
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
