<?php
class GoogleAuth{
    protected $client;

    public function __construct(Google_Client $googleClient = null){
        $this->client = $googleClient;
        if($this->client){
            $this->client->setClientId('773838975358-ius9t4l2d5ru1fdbrs7qnre57kedujd3.apps.googleusercontent.com');
            $this->client->setClientSecret('BvHlSk4l7EpCRBKwu98sa98T');
            $this->client->setRedirectUri('http://ec2-34-224-173-168.compute-1.amazonaws.com/umgteam/index.php');
            $this->client->setScopes('email');
        }
    }

    public function isLoggedIn(){
        return isset($_SESSION['access_token']);
    }

    public function getAuthUrl(){
        return $this->client->createAuthUrl();
    }

    public function checkRedirectCode(){
        if(isset($_GET['code'])){
            $this->client->authenticate($_GET['code']);
            $this->setToken($this->client->getAccessToken());
            return true;
        }
        return false;
    }

    public function setToken($token){
        $_SESSION['access_token'] = $token;
        $this->client->setAccessToken($token);
    }
}