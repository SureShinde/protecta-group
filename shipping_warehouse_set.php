<?php

    $curl = curl_init();
	$product_data = array();
	$product_data = 
		array(
			array(
				'internal_id' => 32,
				'delete' => false,
				'countryName'=>'AU',
				'regionName'=>'WA',
				'zone'=>'20',
				'zipFrom'=>'2000',
				'zipTo'=>'2080',
				'weightFrom'=>'0',
				'weightTo'=>'25',
				'volumeFrom'=>'0',
				'volumeTo'=>'0.192',
				'profileName'=>'Standard',
				'shippingPrice'=>'65.00',
				'shippingName'=>'Next Day by 8:00am',
				'shippingDescription'=>'This is shipping description'
			),
			array(
				'internal_id' => 35,
				'delete' => true,
				'countryName'=>'AU',
				'regionName'=>'WA',
				'zone'=>'20',
				'zipFrom'=>'2000',
				'zipTo'=>'2080',
				'weightFrom'=>'0',
				'weightTo'=>'25',
				'volumeFrom'=>'0',
				'volumeTo'=>'0.192',
				'profileName'=>'Bulky',
				'shippingPrice'=>'75.00',
				'shippingName'=>'Next Day by 9:00am',
				'shippingDescription'=>'This is shipping description'				
			),
			array(
				'internal_id' => 38,
				'delete' => false,
				'countryName'=>'AU',
				'regionName'=>'VIC',
				'zone'=>'20',
				'zipFrom'=>'2000',
				'zipTo'=>'2080',
				'weightFrom'=>'0',
				'weightTo'=>'25',
				'volumeFrom'=>'0',
				'volumeTo'=>'0.192',
				'profileName'=>'Hoarding',
				'shippingPrice'=>'85.00',
				'shippingName'=>'Next Day by 10:00am',
				'shippingDescription'=>'This is shipping description'				
			),			
		)	
		;

	$customerData = json_encode(
					array('param' => $product_data					
						  )
				);

	
	
	
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://staging.protectagroup.com.au/index.php/rest/V1/set-shipping-warehouse-data",
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