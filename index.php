<html>
<head>
<title>Charge Phone</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap-rtl.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="script/jquery-1.10.2.js"></script>
<script type="text/javascript" src="script/bootstrap.js"></script>
<body>
<div id="container">
<form class="form-horizontal" data-toggle="validator">
  <div class="form-group">
    <label for="phoneNumber" class="col-sm-3 control-label">شماره تلفن</label>
    <div class="col-sm-8">
      <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="10" class="form-control" id="phoneNumber"  placeholder="شماره موبایل بدون صفر ابتدایی وارد شود." >
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" id="charge" class="btn btn-info">خرید</button>
    </div>
  </div>
</form>
</div>
<div id="availableTopup">
</div>
<script>
	$(document).ready(function() 
	{
		$('#charge').click(function(e){
			e.preventDefault();
			var amount=$("#amount").val();
			$.ajax({
			url:"webservice/TopUpCharge.php",
			type:"post",
			data:{"action":"getAvailableTopup"},
			success:function(response){
				$("#availableTopup").html(response);
				$("#availableTopup").css('display','block');
				}
			})
		})
	$('#availableTopup').on("click"," #tbl1 tr",function() {

        var productId=$(this).attr('id');
		var phoneNumber=$("#phoneNumber").val();
        $.ajax({
			url:"webservice/TopUpCharge.php",
			type:"post",
			data:{"action":"addTopUpOrder","phoneNumber":phoneNumber,"productId":productId},
			success:function(response){
				alert(response);
				location.reload();
				}
			})
    });
	})
</script>
</body>
</html>