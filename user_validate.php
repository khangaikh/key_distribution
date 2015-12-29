<?php 
    function derLength($length) { 
        if ($length < 128) return str_pad(dechex($length), 2, '0', STR_PAD_LEFT); 
        $output = dechex($length); 
        if (strlen($output) % 2 != 0) $output = '0'.$output; 
        return dechex(128 + strlen($output)/2) . $output; 
    } 
    function convertPemToDer($pem) { 
        $matches = array(); 
        if (!preg_match('~^-----BEGIN ([A-Z ]+)-----\s*?([A-Za-z0-9+=/\r\n]+)\s*?-----END \1-----\s*$~D', $pem, $matches)) { 
            die('Invalid PEM format encountered.'."\n"); 
        } 
        $derData = base64_decode(str_replace(array("\r", "\n"), array('', ''), $matches[2])); 
        $derData = pack('H*', '020100300d06092a864886f70d010101050004'.derLength(strlen($derData))) . $derData; 
                $derData = pack('H*', '30'.derLength(strlen($derData))) . $derData; 
                return $derData; 
    } 
?> 