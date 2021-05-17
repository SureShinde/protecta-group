<?php

    $curl = curl_init();

	
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://staging.protectagroup.com.au/index.php/rest/V1/get-customer-price/2",
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
      echo '<pre>';
	print_r($response);
    }
?>