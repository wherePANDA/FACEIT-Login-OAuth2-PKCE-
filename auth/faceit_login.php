<?php
session_start();
function generatePkceCodeVerifier() {
  return bin2hex(random_bytes(32));
}
function generatePkceCodeChallenge($verifier) {
  return rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');
}
$clientId = "your_client_id";
$codeVerifier = generatePkceCodeVerifier();
$_SESSION['pkce_code_verifier'] = $codeVerifier;
$codeChallenge = generatePkceCodeChallenge($codeVerifier);
$authUrl = "https://accounts.faceit.com/accounts?redirect_popup=true"
  . "&response_type=code"
  . "&client_id=" . urlencode($clientId)
  . "&code_challenge=" . urlencode($codeChallenge)
  . "&code_challenge_method=S256"
  . "&redirect_uri=" . urlencode("https://yourdomain.com/auth/faceit_callback.php");
header("Location: $authUrl");
exit();
