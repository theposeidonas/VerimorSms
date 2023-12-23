<?php

namespace Theposeidonas\VerimorSms;

use Illuminate\Support\Facades\Http;
use Theposeidonas\VerimorSms\Contracts\VerimorSms as VerimorContract;

class VerimorSms implements VerimorContract
{
    /**
     * @var
     */
    protected $config;

    /**
     * @var
     */
    protected $dest;

    /**
     * @var
     */
    protected $msg;

    /**
     * @var
     */
    protected $parameters;

    /**
     *  Register verimor config
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Send with POST method
     *
     * @param $msg
     * @param $dest
     * @param $parameters
     * @return array|mixed
     */
    public function send($msg, $dest, $parameters = [])
    {
        $this->dest = $dest;
        $this->msg = $msg;
        $this->parameters = $parameters;
        return $this->request();
    }

    /**
     * Send with GET method
     *
     * @param $msg
     * @param $dest
     * @param $parameters
     * @return array|mixed
     */
    public function sendGet($msg, $dest, $parameters = [])
    {
        $this->dest = $dest;
        $this->msg = $msg;
        $this->parameters = $parameters;
        return $this->requestGet();
    }

    /**
     * Request with GET method
     *
     * @return object
     */
    public function requestGet()
    {
        $datacoding = $this->parameters['datacoding'] ?? $this->config['datacoding'];
        $valid_for = $this->parameters['valid_for'] ?? $this->config['valid_for'];
        $url = 'https://sms.verimor.com.tr/v2/send?username='.$this->config['username'].'&password='.$this->config['password'].'&source_addr='.$this->config['source_addr'].'&msg='.$this->msg.'&dest='.$this->dest.'&datacoding='.$datacoding.'&valid_for='.$valid_for;
        $request = Http::get($url);
        $request = (object) ['message'=>$request->body(), 'status'=>$request->status()];
        return $request;
    }

    /**
     * Request with POST method
     *
     * @return object
     */
    public function request()
    {
        $data = [
            'username' => $this->config['username'],
            'password' => $this->config['password'],
            'source_addr' => $this->parameters['source_addr'] ?? $this->config['source_addr'],
            'valid_for' => $this->parameters['valid_for'] ?? $this->config['valid_for'],
            'send_at' => $this->parameters['send_at'] ?? '',
            'custom_id' => $this->parameters['custom_id'] ?? uniqid(),
            'datacoding' => $this->parameters['datacoding'] ?? $this->config['datacoding'],
            'messages' => [
                'dest' => $this->dest,
                'msg' => $this->msg
            ]
        ];
        $request = Http::post('https://sms.verimor.com.tr/v2/send.json', $data);
        $request = (object) ['message'=>$request->body(), 'status'=>$request->status()];
        return $request;
    }

    /**
     * Check remaining credit
     *
     * @return object
     */
    public function creditCheck()
    {
        $url = 'https://sms.verimor.com.tr/v2/balance?username='.$this->config['username'].'&password='.$this->config['password'];
        $request = Http::get($url);
        $request = (object) ['credit'=>$request->body(), 'status' => $request->status()];
        return $request;
    }
}