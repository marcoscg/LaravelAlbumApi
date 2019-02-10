<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

class SigninController extends Controller
{

    private $em;

    /**
     * 
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;    
    }

    /**
     * 
     */
    protected function signin(Request $request)
    {  

        $data = $request->all();

        $provider = $data['provider'];
        $email = $data['email'];
        $picture = $data['image'];        
        $token = $this->gerarChaveAcesso();

        if($provider == 'google') {
            // Specify the CLIENT_ID of the app that accesses the backend
            $idToken = $data['idToken'];
            $client = new \Google_Client(['client_id' => '113898429595-4vnmg7gpga2vo3epqqi3ohj3rk6q3mb1.apps.googleusercontent.com']);  // Specify the CLIENT_ID of the app that accesses the backend
            $payload = $client->verifyIdToken($idToken);
            if ($payload) {
                $name = $payload['name'];
                $email = $payload['email'];
                $picture = $payload['picture'];
            } else {
                // Invalid ID token
                return response()->json(['message' => 'Invalid ID token!'], 401);
            }
        } else if($provider == 'facebook') {
            $idToken = $data['token'];
            $app_secret = '125188';
            
            //$appsecret_proof= hash_hmac('sha256', $idToken, $app_secret);

            $fb = new \Facebook\Facebook([
                'app_id' => '258044878213668',
                'app_secret' => '8fc4f37ff42610fbc9a6aff984265094',
                'default_graph_version' => 'v2.11'
              ]);

              try {
                $response = $fb->get('/me',  $idToken);
              } catch(\Facebook\Exceptions\FacebookResponseException $e) {
                return response()->json(['message' => 'Graph returned an error: ' . $e->getMessage()], 401);  
              } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                return response()->json(['message' => 'Facebook SDK returned an error: ' . $e->getMessage()], 401);    
              }
              
              $me = $response->getGraphUser();
              $name = $me->getName();
        } else {
            // Invalid ID token
            return response()->json(['message' => 'Invalid ID token!'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'expires_in'   => 7200,
            'token_type'   => 'Bearer',
            'scope'        => '',
            'name'         => $name,
            'email'        => $email,
            'picture'      => $picture,
        ]);        

    } 

}
