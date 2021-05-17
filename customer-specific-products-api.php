<?php

    $curl = curl_init();	

	$customerData = json_encode(
					array('param' =>
					array(
							'productId'=>'12345678',
							'customerIds'=>'1000001,1000002,1000005,1000010,1000025,1000100'
						)
					)
				);

	/*echo '<pre>';
	print_r($customerData);
	exit();*/
	
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://staging.protectagroup.com.au/index.php/rest/V1/set-customer-specific-products",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $customerData,
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer xfc9y8dazdxvq8yiuv0scy2rz0ds4r37",
        "cache-control: no-cache",
		"Content-Type: application/json"
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