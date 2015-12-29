<?php
// User variables:
$dir = '/opt/lamp/htdocs/key_distribution/'; // Directory where apache has access to (chmod 777).
$RootCA = '/opt/lamp/htdocs/key_distribution/my-privkey.cer'; // Points to the Root CA in PEM format.
$OCSPUrl = 'http://localhost:3001'; //Points to the OCSP URL
// Script:
$a = rand(1000,99999); // Needed if you expect more page clicks in one second!
file_put_contents($dir.$a.'cert_i.pem', $_SERVER['SSL_CLIENT_CERT_CHAIN_0']); // Issuer certificate.
file_put_contents($dir.$a.'cert_c.pem', $_SERVER['SSL_CLIENT_CERT']); // Client (authentication) certificate.
$output = shell_exec('openssl ocsp -CAfile '.$RootCA.' -issuer '.$dir.$a.'cert_i.pem -cert '.$dir.$a.'cert_c.pem -url '.$OCSPUrl);
$output2 = preg_split('/[\r\n]/', $output);
$output3 = preg_split('/: /', $output2[0]);
$ocsp = $output3[1];
echo "OCSP status: "."1"; // will be "good", "revoked", or "unknown"
unlink($dir.$a.'cert_i.pem');
unlink($dir.$a.'cert_c.pem');
?>