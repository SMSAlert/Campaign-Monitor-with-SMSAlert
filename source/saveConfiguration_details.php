<?php 

if($_SERVER['REQUEST_METHOD']=='POST'){
		
		$clean_api_secret = trim($_POST['apikey']);
		if($clean_api_secret !=""){
				
			$response=@file_get_contents('https://www.smsalert.co.in/api/creditstatus.json?apikey='.$clean_api_secret);//fetching from number
			$msg_from=(array)json_decode($response,true);
			if(isset($msg_from['status']) && ($msg_from['status']=="success")){
				$secret_key = $clean_api_secret;
				$phone_number_field = $_POST['phone_number_field'];
				$senderid = $_POST['senderid'];
				$doc = new DOMDocument(); 
				$doc->formatOutput = true; 

				$s = $doc->createElement("settings");
				$doc->appendchild($s);

				$r = $doc->createElement("smsalert" ); 
				$doc->appendChild( $r );


				$secretkey = $doc->createElement( "apikey" ); 
				$secretkey->appendChild( 
				$doc->createTextNode( $secret_key ) 
				);
				$r->appendChild( $secretkey ); 

				$fromnumber = $doc->createElement( "senderid" ); 
				$fromnumber->appendChild( 
				$doc->createTextNode( $senderid ) 
				);
				$r->appendChild( $fromnumber ); 

				$s->appendChild($r);

				$b = $doc->createElement("campaignmonitor" ); 
				$doc->appendChild( $b );

								$phonenumberfield = $doc->createElement( "phonenumberfield" ); 
				$phonenumberfield->appendChild( 
					$doc->createTextNode( $phone_number_field ) 
				);
				$b->appendChild( $phonenumberfield );

				$s->appendChild($b);
				$doc->saveXML(); 

				$doc->save("settings.xml");	
				echo "Settings saved successfully";
			}else{
				echo "Please enter valid APIKEY.";
			}
		}else{
			echo "API key and senderid can not be empty.";
		}
		//
		
		
}
  ?>

