<?php

if (!session_id()) {
    session_start();
}

// Include the autoloader provided in the SDK
require_once __DIR__.'/facebook-php-sdk/autoload.php';

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

/*
 * Configuration and setup Facebook SDK
 */

// $appId = 'InsertAppID'; //Facebook App ID
// $appSecret = 'InsertAppSecret'; //Facebook App Secret
// $redirectURL = 'http://localhost/post_to_facebook_from_website/'; //Callback URL
// $fbPermissions = array('publish_actions'); //Facebook permission

// $fb = new Facebook(array(
//     'app_id' => env('FACEBOOK_APP_ID'),
//     'app_secret' => env('FACEBOOK_APP_SECRET'),
//     'default_graph_version' => 'v2.6',
// ));

// // Get redirect login helper
// $helper = $fb->getRedirectLoginHelper();

// // Try to get access token
// try {
//     if (isset($_SESSION['facebook_access_token'])) {
//         $accessToken = $_SESSION['facebook_access_token'];
//     } else {
//         $accessToken = $helper->getAccessToken();
//     }
// } catch (FacebookResponseException $e) {
//     echo 'Graph returned an error: '.$e->getMessage();
//     exit;
// } catch (FacebookSDKException $e) {
//     echo 'Facebook SDK returned an error: '.$e->getMessage();
//     exit;
// }
