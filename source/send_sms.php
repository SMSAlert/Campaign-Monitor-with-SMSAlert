<?php
	if($_SERVER['REQUEST_METHOD']=='POST'){
		//$campaign_id = $_POST['campaign_id'];
		$username = $_POST['app_id'];
		$password = '';
		$phone_number_field = $_POST['phone_number_field'];
		$all_lists = $_POST['all_lists'];
		
		$apikey = $_POST['apikey'];
		$senderid = $_POST['senderid'];
		$message = $_POST['message'];
	
		if(count($all_lists) > 0){
			
			foreach($all_lists as $list){
				$context = stream_context_create(array(
					'http' => array(
					'header'  => "Authorization: Basic " . base64_encode("$username:$password")
					)
				));			
				$active_users = @file_get_contents('https://api.createsend.com/api/v3.1/lists/'.$list.'/active.json',false,$context);
				$active_users = json_decode($active_users);
				
				
				foreach($active_users->Results as $active_user){
					
						$temp_message = $message;
						$name = $active_user->Name;
						$email = $active_user->EmailAddress;
						
						$temp_message = str_replace("[name]",$name,$temp_message);
						$temp_message = str_replace("[email]",$email,$temp_message);
						
						$temp_message = urlencode($temp_message);
					foreach($active_user->CustomFields as $custom_field){
						if($custom_field->Key=='['.$phone_number_field.']'){
							$user_phone_number = $custom_field->Value;
							//sending SMS
							$response = @file_get_contents('https://www.smsalert.co.in/api/push.json?apikey='.$apikey.'&sender='.$senderid.'&mobileno='.$user_phone_number.'&text='.$temp_message);
							
							
							
						}else{
							
						}
					}
				}
			}
		}
		?>
			<tr id="sent_message_section" class="dynamic_rows">
				<td>
				
				</td>
				<td>
					<div style="margin-left:10px;">
						<strong>Message Sent</strong>
					</div>
				</td>
			</tr>
		<?php
	}
	else{
		echo "not a post request";
	}
?>

	