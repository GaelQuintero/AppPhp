<?php
session_start();
// Verifica si el usuario está autenticado

$clientID = '37583988013-7u0orfjak2g64fgt1nc6imrk6jd46qst.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost:8081/AppPhp/index.php';

$tokenRevocationUrl = 'https://oauth2.googleapis.com/revoke';

if (isset($_GET['logout'])) {
    $accessToken = $_SESSION['access_token'];

    if ($accessToken) {
        $reveokeParams = array(
            'token' => $accessToken
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenRevocationUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($reveokeParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $reveokeParams = curl_exec($ch);
        curl_close($ch);
    }
    // Limpiar la información de la sesión
    session_destroy();
    // Redireccionar al usuario después de cerrar sesión
    header('Location: http://localhost:8081/AppPhp/login.php');
    exit;
}

if (!isset($_GET['code'])) {
    $authorizationUrl = "https://accounts.google.com/o/oauth2/v2/auth";
  
    $params = array(
        'response_type' => 'code',
        'client_id' => $clientID,
        'redirect_uri' => $redirectUri,
        'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email'
    );

    header("Location: " . $authorizationUrl . '?' . http_build_query($params));
    exit;
}

$accessTokenUrl = "https://oauth2.googleapis.com/token";

$params = array(
    'code' => $_GET['code'],
    'client_id' => $clientID,
    'client_secret' => $clientSecret,
    'redirect_uri' => $redirectUri,
    'grant_type' => 'authorization_code',
);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $accessTokenUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$accessTokenData = json_decode($response, true);

if (isset($accessTokenData['access_token'])) {
    $_SESSION['access_token'] = $accessTokenData['access_token'];

    $userInfoUrl = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=" . $_SESSION['access_token'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $userInfoUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $userInfo = curl_exec($ch);
    curl_close($ch);
    $_SESSION['userInfoData'] = json_decode($userInfo, true);
} else {
    echo "Error en la recolección de datos";
}
?>
