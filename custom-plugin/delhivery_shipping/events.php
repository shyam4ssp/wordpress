<?php
/**
*  -------------------------------------------------------------
*  ADD ACTION AFTER ORDER CREATED OR PROCESSED OR AFTER PAYMENT
*  -------------------------------------------------------------	
**/

// order created
//add_action( 'woocommerce_new_order', 'newOrderProcessed',  1, 1  );

// order processed
add_action( 'woocommerce_checkout_order_processed', 'newOrder',  1, 1  );

// order payment processed
add_action( 'woocommerce_payment_complete', 'newOrderAfterPayment',  1, 1  );


function newOrder($orderid,$retry = false){
	
	$token =  getAPIToken();
    $valid_token = isValidToken('110094');
	if(!empty($token)){
		global $wpdb;	

		if($retry){
			$order_det = existsOrderDetails($orderid);
			
			if($order_det==false){
				insertShippingOrder($orderid);	
			}
		}else{
			insertShippingOrder($orderid);	
		}
		$waybill = "";
		// GET PINCODE
		$pincode = getShippingPincode($orderid);
		// CALL CHECK PINCODE API
		$res_1  = checkPincode($pincode);
		$pincode_json = json_decode($res_1);
		//if(($res_1!="Login or API Key Required") && is_array($pincode_json)){
		if(true){
			updateOrderPincodeJson($orderid,"pincode done");
			//GET ORDER CREATION DATA    
			$data = getOrderCreationData($orderid);
			/************************/
			
			$order = wc_get_order( $orderid );
			$items = $order->get_items();
			$quantity = 0;
			$tax = 0;
			/*foreach ( $items as $item ) {*/
			foreach ($items as $item_id => $item_data) {
				$product_name[] = $item_data['name'];
				$item_quantity = $order->get_item_meta($item_id, '_qty', true);
				$quantity = $quantity + $item_quantity;
				$item_total_tax = $item_data['total_tax']; 
				$tax = $tax + $item_total_tax;
			}
			if($quantity == 0){
				$quantity = 1;
			}
			$product_name = implode(', ', $product_name);
			if(empty($product_name)){
				$product_name = '';
			}
			$pickup_address = getDefaultPickupLocation();
			$token = "Token d5866fd1742f70c6bc324f4c1a13622d33198cbb"; // replace this with your token key
			$url = "https://track.delhivery.com/api/cmu/create.json";
			$params = array(); // this will contain request meta and the package feed
			$package_data = array(); // package data feed
			$shipments = array();
			$pickup_location = array();
			/////////////start: building the package feed/////////////////////
			$shipment = array();
			$shipment['waybill'] = '';
			$shipment['client'] = 'ALCHEMIE SURFACE';
			$shipment['name'] = getShippingFirstName($orderid).' '.getShippingLastName($orderid);
			$shipment['order'] = $orderid; // client order number
			$shipment['products_desc'] = $product_name;
			$shipment['order_date'] = date('Ymd\Th:i:s'); // ISO Format
			$shipment['payment_mode'] = 'Prepaid';
			$shipment['total_amount'] = getOrderTotalAmount($orderid); // in INR
			$shipment['cod_amount'] = '0.0'; // amount to be collected, required for COD
			$shipment['add'] = getShippingAddress($orderid); // consignee address
			$shipment['city'] = getShippingCity($orderid);
			$shipment['state'] = getShippingState($orderid);
			$shipment['country'] = getShippingCountry($orderid);
			$shipment['phone'] = getBillingPhone($orderid);
			$shipment['pin'] = getBillingPincode($orderid);
			$shipment['return_add'] = ""; // consignee address
			$shipment['return_city'] = "";
			$shipment['return_country'] = "";
			$shipment['return_phone'] = "";
			$shipment['return_pin'] = "";
			$shipment['qc']['item']['descr'] = $product_name;
			$shipment['return_state'] = "";
			$shipment['supplier'] = "";
			$shipment['extra_parameters'] = "";
			$shipment['shipment_width'] = "";
			$shipment['shipment_height'] = "";
			$shipment['weight'] = "";
			$shipment['quantity'] = $quantity;
			$shipment['seller_inv']= ''; // invoice number of shipment
			$shipment['seller_inv_date']= date('Ymd\Th:i:s'); // ISO Format
			$shipment['seller_name']='NOVAGAMINGVENTURES'; //name of seller
			$shipment['seller_add']=''; // add of seller
			$shipment['seller_cst'] = ''; //cst number of seller
			$shipment['seller_tin'] = '';  //tin number of seller
			$shipment['consignee_tin'] = '';  //tin number of seller
			$shipment['commodity_value'] = '';  //tin number of seller
			$shipment['tax_value'] = $tax;  
			$shipment['sales_tax_form_ack_no'] = '';  //tin number of seller
			$shipment['category_of_goods'] = '';  //tin number of seller
			$shipment['seller_gst_tin'] = '';  //tin number of seller
			$shipment['client_gst_tin'] = '';  //tin number of seller
			$shipment['consignee_gst_tin'] = '';  //tin number of seller
			$shipment['hsn_code'] = '';  //tin number of seller
			$shipment['invoice_reference'] = '';  //tin number of seller
			$shipments = array($shipment);

			$pickup_location['add'] = $pickup_address[0]->address;
			$pickup_location['city'] = $pickup_address[0]->city;
			$pickup_location['country'] = $pickup_address[0]->country;
			$pickup_location['name'] = $pickup_address[0]->name; // Use client warehouse name
			$pickup_location['phone'] = $pickup_address[0]->phone;
			$pickup_location['pin'] = $pickup_address[0]->pincode;
			$pickup_location['state'] = $pickup_address[0]->state;
			$pickup = array($pickup_location);

			$package_data['dispatch_date'] = "";
			$package_data['dispatch_id'] = "";
			$package_data['shipments'] = $shipments;

			$params['output'] = 'json';
			$params['token'] = $token;
			$params['package_type'] ='Prepaid';
			$params['format'] = 'json';
			$params['data'] = json_encode($package_data);

			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>  "format=json&data=".json_encode($package_data),
			  CURLOPT_HTTPHEADER => array(
				"Authorization: ".$token."",
				"Cache-Control: no-cache",
				"Content-Type: application/json"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			$array = json_decode($response, true);
			
			$status = $array['packages'][0]['status'];
			if($status == 'Success'){
				$pi_stautus = 200;
				updateOrderJson($orderid,"order done");
				$waybill = $array['packages'][0]['waybill'];
				updateOrderWaybill($orderid,$waybill);
				$order_status = 'Confirmed';
				$return_url = $_POST['success_url'];
			}else{
				$pi_stautus = 200;
				$order_status = 'Pending';
				$return_url = $_POST['failure_url'];
			}
			/************************/
			
			
			
			// CALL API FOR ORDER CREATION
			/*$res_2 = createPackageOrder($data); */
			$order_creation = json_decode($response);
			
			
			
			if($order_creation->packages[0]->status == "Success"){
				updateOrderJson($orderid,"order done");

				
				$waybill = $order_creation->packages[0]->waybill;
				updateOrderWaybill($orderid,$waybill);

				// GET DATA FOR PICKUP REQUEST
				/*$pickup_data =  json_encode(array(
					'pickup_time'=> date('H:i:s',current_time( 'timestamp' )),
					'pickup_date'=> date('Ymd',strtotime(' +1 day')),
					'pickup_location'=>"CREMICA",  // do not change cremica to any address
					'expected_package_count'=>ceil(getTotalItemsInOrder($orderid) / getItemsPerPackage())
				));
 
				$res_3 = createPickupRequest($pickup_data);
				$pickup_order_request_response_data = json_decode($res_3);

				
				// check if pickup request
				if(isset($pickup_order_request_response_data->pickup_id) && !empty($pickup_order_request_response_data->pickup_id)){
					updateOrderPickupRequest($orderid,$pickup_order_request_response_data->pickup_id);
				}else{
					updateOrderPickupRequest($orderid,"pickup request fail");
				}*/
				
			}else{
				updateOrderJson($orderid,$order_creation->packages[0]->remarks."ORDER FAIL");
			}
			
		//}else{
		//	updateOrderPincodeJson($orderid,"pincode fail");
		}
                return true;
	}else{
            updateOrderPincodeJson($orderid,"pincode fail");
            return $valid_token;
	}	
}

//function newOrderProcessed($orderid){		
//}

//function newOrderAfterPayment($orderid){	
//}


// GET ORDER CREATION DATA FROM ORDER
function getOrderCreationData($orderid){

	// order details   ORDER DETAILS WILL COME HERE
	$shipping_return_address = getDefaultShippingLocation();
	$pickup_address = getDefaultPickupLocation();

	$data = array();
	$data['format']="json";
	$data['data'] = json_encode(array(
				  	"shipments"=> array(
					  		array(
							  "waybill" => '',
							  "client" => 'ALCHEMIE SURFACE',
							  "name"=> getShippingFirstName($orderid).' '.getShippingLastName($orderid),
							  "order"=> $orderid,
							  "products_desc"=> '',
							  "order_date"=> date('Ymd\Th:i:s'),
							  "payment_mode"=> 'Prepaid',
						      "total_amount"=> getOrderTotalAmount($orderid),
						      "cod_amount"=> '0.0',
							  "add"=> getShippingAddress($orderid),
							  "city"=> getShippingCity($orderid),
							  "state"=> getShippingState($orderid),
							  "country"=> getShippingCountry($orderid),
						      "phone"=> getBillingPhone($orderid),
							  "pin"=> getBillingPincode($orderid),
							  "return_add"=> '',
							  "return_city"=> '',
							  "return_country"=> '',
							  "return_phone"=> '',
							  "return_pin"=> '',
							  "return_state"=> '',
							  "supplier"=> '',
							  "extra_parameters"=> '',
							  "shipment_width"=> '',
							  "shipment_height"=> '',
							  "weight"=> '',
							  "quantity"=> '1',
							  "seller_inv"=> '',
							  "seller_inv_date"=> date('Ymd\Th:i:s'),
							  "seller_name"=> 'ALCHEMIE',
							  "seller_add"=> '',
							  "seller_cst"=> '',
							  "seller_tin"=> '',
							  "consignee_tin"=> '',
							  "commodity_value"=> '',
							  "tax_value"=> '',
							  "sales_tax_form_ack_no"=> '',
							  "category_of_goods"=> '',
							  "seller_gst_tin"=> '',
							  "client_gst_tin"=> '',
							  "consignee_gst_tin"=> '',
							  "hsn_code"=> '',
							  "invoice_reference"=> '',
					 	 	)
					),					
				  	"pickup_location"=>array(
					    "phone"=> $pickup_address[0]->phone,
					    "pin"=> $pickup_address[0]->pincode,
					    "name"=> $pickup_address[0]->name,
					    "add"=> $pickup_address[0]->address,
					    "country"=>$pickup_address[0]->country,
					    "city"=> $pickup_address[0]->city
				  	),
					"dispatch_date"=> '',
					"dispatch_id"=> '',
				));
	return $data;
}

?>
