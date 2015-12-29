<?php
    require_once 'includes/Twig/Autoloader.php';
    use Parse\ParseObject;
    use Parse\ParseClient;
    use Parse\ParseQuery;
    use Parse\ParseUser;
    
    session_start();
    //register autoloader
    Twig_Autoloader::register();
    //loader for template files
    $loader = new Twig_Loader_Filesystem('templates');
    //twig instance
    $twig = new Twig_Environment($loader, array(
        'cache' => 'cache',
    ));
    //load template file
    $twig->setCache(false);

    if(isset($_SESSION['user'])){
    }
    else{
        if(isset($_GET['get_key'])){
            
            // Create the keypair
            $res=openssl_pkey_new();
            // Get private key
            openssl_pkey_export($res, $privkey, "PassPhrase number 1" );

            // Get public key
            $pubkey=openssl_pkey_get_details($res);
            $pubkey=$pubkey["key"];
            
            // Create the keypair
            $res2=openssl_pkey_new();

            // Get private key
            openssl_pkey_export($res2, $privkey2, "This is a passPhrase *µà" );

            // Get public key
            $pubkey2=openssl_pkey_get_details($res2);
            $pubkey2=$pubkey2["key"];
            var_dump($privkey2);
            var_dump($pubkey2);

            $data = "Only I know the purple fox. Trala la !";

            openssl_seal($data, $sealed, $ekeys, array($pubkey, $pubkey2));

            var_dump("sealed");
            var_dump(base64_encode($sealed));
            var_dump(base64_encode($ekeys[0]));
            var_dump(base64_encode($ekeys[1]));

            // decrypt the data and store it in $open
            if (openssl_open($sealed, $open, $ekeys[1], openssl_pkey_get_private  ($privkey2  ,"This is a passPhrase *µà" ) ) ) {
                echo "here is the opened data: ", $open;
            } else {
                echo "failed to open data";
            }

            echo 1;
        }
        
    }
    


?>

