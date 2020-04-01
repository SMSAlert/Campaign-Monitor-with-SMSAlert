<?php
require_once 'header.php';


if (file_exists('settings.xml')) {
   $xml = simplexml_load_file('settings.xml');
   if($xml!="")
   {
		$apikey=(string)$xml->smsalert->apikey;
		$senderid=(string)$xml->smsalert->senderid;
		$campaignMonitorApi=(string)$xml->campaignmonitor->api;
		$phone_number_field=(string)$xml->campaignmonitor->phonenumberfield;
   }
}
?>
  <div id="defaults" class="pageWrapper">
		<div class="logoWrapper">
			<img src="smsalert-logo.png" alt="Smsalert" width="200">
			<img id="loader" src="loading.gif" height="33px" width="33px" style="display:none;">
		</div>
		
        <table class="tableStyle">
            <tr>
                <td colspan="2"> 
                    <div class="areaHeader">
                        Configuration Settings
						<a class="blueBtn" href="home.php" style="float:right">Home</a>
                    </div>
                </td>
            </tr>
            
                <td class="auto-style2">
                    <label for="dLine1">
                       SMS Alert ApiKey:</label>
                </td>
                <td class="auto-style1">
                    <input id="NSecret" type="text" value=<?php if(isset($apikey) && $apikey!="") echo $apikey;?> >
                </td>
            </tr>
            <tr>
                <td class="auto-style2">
                    <label for="dLine2">
                        Senderid:</label>
                </td>
                <td class="auto-style1">
                    <input id="NUser" type="text" value=<?php if(isset($senderid) && $senderid!="") echo $senderid;?>>
                </td>
            </tr>
			
			 		
			 <tr>
                <td class="auto-style2">
                    <label for="dLine2">
                        Phone Number field:</label>
                </td>
                <td class="auto-style1">
                    <input id="phone_number_field" type="text" name="phone_number_field" value=<?php if(isset($phone_number_field) && $phone_number_field!="") echo $phone_number_field;?>>
                </td>
            </tr>
			
            <tr>
			<td class="auto-style2">&nbsp;</td>
                <td class="auto-style1">
                    <div>
					<?php if(!empty($campaignMonitorApi) || !empty($senderid) || !empty($apikey) || !empty($phone_number_field )){?>
					    <button id="saveDefaults" class="blueBtn">Update</button>
					<?php } else{?>
					
						<button id="saveDefaults" class="blueBtn">Save</button>
					<?php }?>
                    </div>
                </td>
            </tr>
        </table>
		</form>
    </div>

	
<script>
$("#saveDefaults").click(function(){
	$('#loader').show();
	if($("#NKey").val()=="" || $("#NSecret").val()=="" || $("#phone_number_field").val()=="")
	{
		alert("Please enter all the values");
		$('#loader').hide();
	}
	else{
			$.ajax({
						url: 'saveConfiguration_details.php',
						async: 'false',
						cache: 'false',
						type: 'POST',
						data:{ 
						    apikey:$("#NSecret").val(),
							senderid:$("#NUser").val(),
							campaign_monitor:$("#ApiKey").val(),
							phone_number_field:$(phone_number_field).val(),
						},
						success: function(result){
							alert(result);
							//alert("Settings saved successfully");
							$('#loader').hide();
							$("#NKey").val("");
							$("#NSecret").val("");
							$("#NUser").val("");
							$("#ApiKey").val("");
							window.location.href="index.php";
						}
					});
	}
});
	

</script>