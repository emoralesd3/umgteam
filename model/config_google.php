<?php
    require_once('GoogleAPI/vendor/autoload.php');
    $google_client = new Google_Client();
    $google_client->setClientId('773838975358-ius9t4l2d5ru1fdbrs7qnre57kedujd3.apps.googleusercontent.com');
    $google_client->setClientSecret('BvHlSk4l7EpCRBKwu98sa98T');
    $google_client->setRedirectUri('http://ec2-34-224-173-168.compute-1.amazonaws.com/umgteam/g-callback.php');
    $google_client->addScope('profile','https://www.googleapis.com/auth/plus.me','email','https://www.googleapis.com/auth/userinfo.email');