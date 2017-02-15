<?php
require_once('../nusoap.php'); 
require_once('../enum/webserviceResults.php');
$topUp_client = new SoapClient("http://www.portal.mpj.ir/WebServices/Eila_WS.asmx?wsdl");
if(isset($_POST))
{
	switch(trim(strtolower($_POST['action']))){
		case 'getavailabletopup':
			$operatorId=findOperatorId($_POST['phoneNumber']);
			if($operatorId>0)
			{
				$availableTopupes = array();
				$result=$GLOBALS['topUp_client']->Get_AvailableTopup(array('aUsername' =>'28764' ,'aPassword'=>'1942'));
				if($result->Get_AvailableTopupResult->result=='SUCCESSFUL')
				{
					$list=$result->Get_AvailableTopupResult->_table->string;
					foreach ($list as $key=>$topup) 
						if(!trim($topup)=='')
						{
							$topupDetail=explode("#", $topup);
							if($topupDetail[3]!=$operatorId)
								unset($list[$key]);
						}
					if(count($list)>0)
					{
						echo  '<table class="table table-hover" id="tbl1">';
						echo '<thead>';
						echo '<TR align="right" valign="middle" class="info">';
						echo '<TH filter="false">نام</TH>';
						echo '</TR>';
						echo '</thead>';
						echo '<tbody>';
						foreach ($list as  $topup) {
							if(!trim($topup)=='')
							{
								$item=explode("#", $topup);
								echo '<TR align="right" valign="middle" class="rcord" id='.$item[0].' data-operator-id='.$item[3].'>'."\n";
								echo '<TD>'.$item[1].'</TD>'."\n";
								echo '</TR>'."\n";
								// array_push($availableTopupes,new Topup($item[0],$item[1],$item[2],$item[3]));
							}
						}
						echo '</tbody>';
						echo '</table>';
						// print_r($availableTopupes);
					}
					else
						echo "هيچ محصولي براي گروه مورد نظر در سيستم تعريف نشده است.";
				}
				else
					echo "خطا در اجرای سرویس";
			}
			else
				echo "هيچ محصولي براي گروه مورد نظر در سيستم تعريف نشده است.";
			break;
		case 'addtopuporder':
				echo topUpCharge($_POST['phoneNumber'],$_POST['productId']);
			break;
	}
}
function topUpCharge($phoneNumber,$productId)
{
	try{
		$param=array('aUsername' =>'28764' ,
					'aPassword'=>'1942',
					'aProductID'=>$productId,
					'aMobileNo'=>$phoneNumber );
		$res=$GLOBALS['topUp_client']->Add_TopUp_Order($param);
		switch ($res->Add_TopUp_OrderResult->result) {
			case TopupResult::INVALID_FORMAT:
				return "فرمت شماره موبایل صحیح نیست.";
				break;
			case TopupResult::CREDIT_LOW:
				return "اعتبار شما کافی نمی باشد.";
			case TopupResult::SUCCESSFUL:
				return "شارژ با موفقیت انجام شد.اعتبار فعلی شما ".$res->Add_TopUp_OrderResult->credit." ریال می باشد.شماره سفارش".$res->Add_TopUp_OrderResult->orderID;
			default:
				return "اجرای دستور با خطا";
				break;
		}
	}
	catch(SoapFault $e){
		return "خطا";
	}
}
function findOperatorId($phoneNumber)
{
	if(startsWith($phoneNumber,array('91','990')))
		return CellPhoneOperatorID::Hamrahe_Avval;
	else if(startsWith($phoneNumber,array('93','901','902','903')))
		return CellPhoneOperatorID::Irancell;
	else if(startsWith($phoneNumber,array('921','922')))
		return CellPhoneOperatorID::Ritel;
	return -1;
}
function startsWith($phoneNumber, $code)
{
     foreach ($code as $value) {
     	if(strpos($phoneNumber, $value) === 0)
     		return true;
     }
     return false;
}
?>