<?php
/*Create ccustomer API*/
    /*$userData = array("username" => "superadmin", "password" => "admin123");
    $ch = curl_init("http://protecta.23digital-prod8.com/index.php/rest/V1/integration/admin/token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Lenght: " . strlen(json_encode($userData))));

    $token = curl_exec($ch);

    //echo $token; exit;

    $customerData = [
        'customer' => [
            "email" => "user@example.com",
            "firstname" => "John",
            "lastname" => "Doe",
            "storeId" => 1,
            "websiteId" => 1
        ],
        "password" => "Demo1234"
    ];

    $ch = curl_init("http://protecta.23digital-prod8.com/index.php/rest/V1/customers");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . json_decode($token)));

    $result = curl_exec($ch);

    $result = json_decode($result, 1);
    echo '<pre>';print_r($result);

    End */

    /* Get Customer Details API */

    
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://protecta.23digital-prod8.com/index.php/rest/V1/customers/29",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer xfc9y8dazdxvq8yiuv0scy2rz0ds4r37",
        "cache-control: no-cache"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
        $result = json_decode($response, 1);
      echo '<pre>';print_r($result);
    }
?>