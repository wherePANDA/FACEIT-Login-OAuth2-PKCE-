<?php
session_start();
$code = $_GET['code'] ?? null;
$codeVerifier = $_SESSION['pkce_code_verifier'] ?? null;
$clientId = "your_client_id";
$clientSecret = "your_client_secret";
$redirectUri = "https://yourdomain.com/auth/faceit_callback.php";
$tokenEndpoint = "https://api.faceit.com/auth/v1/oauth/token";

$postFields = http_build_query([
  'grant_type' => 'authorization_code',
  'code' => $code,
  'redirect_uri' => $redirectUri,
  'code_verifier' => $codeVerifier,
  'client_id' => $clientId
]);

$authHeader = "Authorization: Basic " . base64_encode("$clientId:$clientSecret");

$ch = curl_init($tokenEndpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [$authHeader, 'Content-Type: application/x-www-form-urlencoded']);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

$response = curl_exec($ch);
curl_close($ch);

$tokenInfo = json_decode($response, true);
if (isset($tokenInfo['access_token'])) {
  // Save token, create session or proceed
}
