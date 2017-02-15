<?php
abstract class TopupResult{
	Const AUTHENTICATION_FAILED="AUTHENTICATION_FAILED";
	Const INVALID_FORMAT="INVALID_FORMAT";
	Const PRODUCT_INVALID="PRODUCT_INVALID";
	Const USER_PROFITPATTERN_INVALID="USER_PROFITPATTERN_INVALID";
	Const CREDIT_LOW="CREDIT_LOW";
	Const WS_NOTAVAILABLE="WS_NOTAVAILABLE";
	Const SUCCESSFUL="SUCCESSFUL";
	Const UNSUCCESSFUL="UNSUCCESSFUL";
}
abstract class CellPhoneOperatorID{
	Const Hamrahe_Avval=6;
	Const Irancell=7;
	Const Ritel=12;
}
class Topup
{
	var $id,$name,$price,$operatorId;
	function __construct($id,$name,$price,$operatorId)
	{
		$id=$id;
		$name=$name;
		$price=$price;
		$operatorId=$operatorId;
	}
}
?>