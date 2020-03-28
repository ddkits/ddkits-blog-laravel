<?php

namespace App\Http\Controllers;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Include FB configuration file
// require_once 'fbConfig.php';
class GraphController extends Controller
{
    private $api;

    public function __construct(Facebook $fb = null)
    {
        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(env('FACEBOOK_ACCESS_TOKEN'));
            $this->api = $fb;

            return $next($request);
        });
    }

    public function retrieveUserProfile()
    {
        try {
            $params = 'first_name,last_name,age_range,gender';

            $user = $this->api->get('/me?fields='.$params)->getGraphUser();

            dd($user);
        } catch (FacebookSDKException $e) {
        }
    }

    // Posting to Profiles
    // Add a new method publishToProfile to GraphController for handling requests to create profile posts.
    public function publishToProfile(Request $request)
    {
        try {
            $response = $this->api->post('/me/feed', [
                'message' => $request->message,
            ])->getGraphNode()->asArray();
            if ($response['id']) {
                // post created
            }
        } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }
    }

    /**
     * Posting to Pages
     * Method of posting to pages is different from profiles.
     *  When you’re posting to your profile, you’re using your own access
     * token to make the request. Every page your manage has its own access token and you
     * have to retrieve it before making any requests. Add a new method
     * getPageAccessToken to GraphController.
     */
    public function getPageAccessToken($page_id)
    {
        try {
            // Get the \Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $this->api->get('/me/accounts', Auth::user()->token);
        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: '.$e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: '.$e->getMessage();
            exit;
        }

        try {
            $pages = $response->getGraphEdge()->asArray();
            foreach ($pages as $key) {
                if ($key['id'] == $page_id) {
                    return $key['access_token'];
                }
            }
        } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }
    }

    public function publishToPage($page_id, $feed)
    {
        try {
            $post = $this->api->post(
                '/'.$page_id.'/feed',
                array(
                    'message' => $feed->title.' - '.env('APP_URL').'/'.$feed->path,
                ),
                $this->getPageAccessToken($page_id)
            );
            $post = $post->getGraphNode()->asArray();
            dd($post);
        } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }
    }

    public function publishToPageNew($page_id, $feed)
    {
        /*
        * Configuration and setup Facebook SDK
        */

        $redirectURL = env('FACEBOOK_REDIRECT'); //Callback URL
        $fbPermissions = array('publish_actions'); //Facebook permission

        $fb = new Facebook(array(
            'app_id' => env('FACEBOOK_APP_ID_ID', '584857442336768'),
            'app_secret' => env('FACEBOOK_APP_SECRET', 'd8cffd5f033b81df8a9d9845c3528e66'),
            'default_graph_version' => 'v2.6',
        ));

        // Get redirect login helper
        $helper = $fb->getRedirectLoginHelper();
        if (isset($accessToken)) {
            if (isset($_SESSION['facebook_access_token'])) {
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            } else {
                // Put short-lived access token in session
                $_SESSION['facebook_access_token'] = (string) env('FACEBOOK_ACCESS_TOKEN');

                // OAuth 2.0 client handler helps to manage access tokens
                $oAuth2Client = $fb->getOAuth2Client();

                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

                // Set default access token to be used in script
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }

            //FB post content
            $message = $feed->title;
            $title = $feed->title;
            $link = env('APP_URL').'/'.$feed->path;
            $description = $feed->title;
            $picture = env('APP_URL').'/'.$feed->image;

            $attachment = array(
                'message' => $message,
                'name' => $title,
                'link' => $link,
                'description' => $description,
                'picture' => $picture,
                'scope' => 'publish_actions',
            );

            try {
                // Post to Facebook
                $fb->post('/'.$page_id.'/feed?scope=publish_actions&scopes=publish_actions', $attachment, (string) env('FACEBOOK_ACCESS_TOKEN'));

                // Display post submission status
                echo 'The post was published successfully to the Facebook timeline.';
            } catch (FacebookResponseException $e) {
                echo 'Graph returned an error: '.$e->getMessage();
                exit;
            } catch (FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: '.$e->getMessage();
                exit;
            }
        } else {
            // Get Facebook login URL
            $fbLoginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);

            // Redirect to Facebook login page
            echo '<a href="'.$fbLoginURL.'"><img src="fb-btn.png" /></a>';
        }
    }
}
