<?php

    $curl = curl_init();
	$product_data = array();
	$product_data[] = 
		array(
			array(
				'itemId'=>'1',
				'price'=>'10.50',
				'qty'=>'5'				
			),
			array(
				'itemId'=>'1',
				'price'=>'9.50',
				'qty'=>'10'				
			),
			array(
				'itemId'=>'16',
				'price'=>'6.50',
				'qty'=>'1'				
			),			
		)	
		;

	$customerData = json_encode(
					array('param' =>
					array(
							'customerId' => '10',
							'itemPricing' => $product_data,
						)
						  )
				);

	
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://staging.protectagroup.com.au/index.php/rest/V1/set-customer-price",
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