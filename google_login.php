<?php
class GoogleOAuth {
    private $clientID;
    private $clientSecret;
    private $redirectUri;
    private $tokenRevocationUrl;
    private $accessTokenUrl;
    private $authorizationUrl;
    
    public function __construct($clientID, $clientSecret, $redirectUri) {
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
        $this->tokenRevocationUrl = 'https://oauth2.googleapis.com/revoke';
        $this->accessTokenUrl = 'https://oauth2.googleapis.com/token';
        $this->authorizationUrl = 'https://accounts.google.com/o/oauth2/v2/auth';
    }
    
    public function authenticate() {
        session_start();

        if (isset($_GET['logout'])) {
            $accessToken = $_SESSION['access_token'];

            if ($accessToken) {
                $reveokeParams = array(
                    'token' => $accessToken
                );
                $this->revokeToken($reveokeParams);
            }
            session_destroy();
            header('Location: http://localhost:8081/AppPhp/login.php');
            exit;
        }

        if (!isset($_GET['code'])) {
            $params = array(
                'response_type' => 'code',
                'client_id' => $this->clientID,
                'redirect_uri' => $this->redirectUri,
                'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email'
            );

            header("Location: " . $this->authorizationUrl . '?' . http_build_query($params));
            exit;
        }

        $params = array(
            'code' => $_GET['code'],
            'client_id' => $this->clientID,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code',
        );

        $accessTokenData = $this->getAccessToken($params);

        if (isset($accessTokenData['access_token'])) {
            $_SESSION['access_token'] = $accessTokenData['access_token'];

            $userInfoUrl = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=" . $_SESSION['access_token'];

            $userInfo = $this->getUserInfo($userInfoUrl);
            $_SESSION['userInfoData'] = json_decode($userInfo, true);
        } else {
            echo "Error en la recolección de datos";
        }
    }

    private function getAccessToken($params) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->accessTokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    private function revokeToken($reveokeParams) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->tokenRevocationUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($reveokeParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $reveokeParams = curl_exec($ch);
        curl_close($ch);
    }

    private function getUserInfo($userInfoUrl) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $userInfoUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $userInfo = curl_exec($ch);
        curl_close($ch);
        return $userInfo;
    }
}

// Uso del objeto GoogleOAuth
$clientID = '37583988013-7u0orfjak2g64fgt1nc6imrk6jd46qst.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost:8081/AppPhp/index.php';

$googleOAuth = new GoogleOAuth($clientID, $clientSecret, $redirectUri);
$googleOAuth->authenticate();
?>
