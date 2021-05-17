<?php

    $curl = curl_init();
	$product_data = array();
	$product_data = 
		array(
			array(
				'internal_id' => 22,
				'delete' => false,
				'zone'=>'10',
				'nsw'=>'1',
				'qld'=>'3',
				'vic'=>'2',
				'wa'=>'1'				
			),
			array(
				'internal_id' => 25,
				'delete' => false,
				'zone'=>'20',
				'nsw'=>'3',
				'qld'=>'2',
				'vic'=>'',
				'wa'=>'1'				
			),
			array(
				'internal_id' => 27,
				'delete' => false,
				'zone'=>'30',
				'nsw'=>'1',
				'qld'=>'3',
				'vic'=>'2',
				'wa'=>''			
			),			
		)	
		;

	$customerData = json_encode(
					array('param' => $product_data					
						  )
				);

	

	

	
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://staging.protectagroup.com.au/index.php/rest/V1/set-shipping-zone-data",
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