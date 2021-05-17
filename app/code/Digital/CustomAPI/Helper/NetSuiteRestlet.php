<?php

namespace Digital\CustomAPI\Helper;

use WEBO\NetSuite\Helper\CustomLogger;

class NetSuiteRestlet {

    private $requestType;
    private $url;
    private $queryString;
    private $consumerKey;
    private $consumerSecret;
    private $tokenID;
    private $tokenSecret;
    private $oauthSigMethod;
    private $scriptID;
    private $deployID;
    private $oauthVersion;
    private $account;
    private $action;

    function __construct()
    {
        $this->consumerKey = '27ed476050b6ba1687358f18f7e61211e99e6d66b65567cae89e1dce97722fe5';
        $this->consumerSecret = 'd122a13515c58f5a6dbc203bb4f6fd02638b9e569980ca65264474a28da20323';
        $this->tokenID = '74b5611fcca28e1d51194db6a4ea1241c97f550a5b23213a30d247a80a14a973';
        $this->tokenSecret = 'd043da3e7b02eae3344ce4cf8c11d71fd5e1111be0a351a25de50ff93a720fc6';
        $this->scriptID = 552;
        $this->deployID = 1;
        $this->account = '4012583_SB1';
        $this->oauthSigMethod = 'HMAC-SHA256';
        $this->oauthVersion = '1.0';
        $this->url = 'https://4012583-sb1.restlets.api.netsuite.com/app/site/hosting/restlet.nl';
    }

    private function setAuthentication()
    {
        $oauthNonce = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
        $oauthTimestamp = time();

        if($this->requestType == 'GET') {
            $baseString = $this->requestType."&".urlencode($this->url)."&".urlencode(
                "deploy=".$this->deployID
                ."&id=".$this->action
                ."&oauth_consumer_key=".$this->consumerKey
                ."&oauth_nonce=".$oauthNonce
                ."&oauth_signature_method=".$this->oauthSigMethod
                ."&oauth_timestamp=".$oauthTimestamp
                ."&oauth_token=".$this->tokenID
                ."&oauth_version=".$this->oauthVersion
                ."&script=".$this->scriptID
            );
        } else {
            $baseString = $this->requestType."&".urlencode($this->url)."&".urlencode(
                "deploy=".$this->deployID
                ."&oauth_consumer_key=".$this->consumerKey
                ."&oauth_nonce=".$oauthNonce
                ."&oauth_signature_method=".$this->oauthSigMethod
                ."&oauth_timestamp=".$oauthTimestamp
                ."&oauth_token=".$this->tokenID
                ."&oauth_version=".$this->oauthVersion
                ."&script=".$this->scriptID
            );
        }

        $sigString = urlencode($this->consumerSecret).'&'.urlencode($this->tokenSecret);
        $signature = base64_encode(hash_hmac('sha256', $baseString, $sigString, true));
        $authHeader = "OAuth "
            . 'oauth_signature="' . rawurlencode($signature) . '", '
            . 'oauth_version="' . rawurlencode($this->oauthVersion) . '", '
            . 'oauth_nonce="' . rawurlencode($oauthNonce) . '", '
            . 'oauth_signature_method="' . rawurlencode($this->oauthSigMethod) . '", '
            . 'oauth_consumer_key="' . rawurlencode($this->consumerKey) . '", '
            . 'oauth_token="' . rawurlencode($this->tokenID) . '", '
            . 'oauth_timestamp="' . rawurlencode($oauthTimestamp) . '", '
            . 'realm="' . rawurlencode($this->account) .'"';
            return $authHeader;
    }

    public function callRestlet( $requestType, $action = '', $data = null )
    {
        $this->requestType = $requestType;
        $this->action = $action;
        if($requestType == 'GET') {

            $parameters = http_build_query(
                array(
                    'script' => $this->scriptID,
                    'deploy' => $this->deployID,
                    'id' => $action,
                )
            );
        } else {
            $parameters = http_build_query(
                array(
                    'script' => $this->scriptID,
                    'deploy' => $this->deployID,
                )
            );
        }

        $authorizationHeader = $this->setAuthentication();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->requestType);
        curl_setopt($ch, CURLOPT_URL, $this->url. '?'.$parameters);

        if($requestType == 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: '.$authorizationHeader,
            'Content-Type: application/json',
        ]);
        $response = array();
        $response['request'] = $this->url. '?'.$parameters;
        $response['response']['body'] = json_decode(curl_exec($ch));
        $response['response']['code']  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $response;
    }
}
