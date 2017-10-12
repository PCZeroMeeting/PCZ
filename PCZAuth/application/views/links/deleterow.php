 <script type="text/javascript">

 $(document).ready(function() {
	$("#noBtn").on("click",function(event){
		event.preventDefault();
		if(parent && SiteCommon.InIframe()){
			//$('.modal').modal('hide');
			window.parent.closeModal();
		}
	});
});


 </script>
 
<?php 
 
?>
<?php echo form_open('links/deleterow'); ?>
<input type="hidden" id="id" name="id" value="<?php echo !empty($id) ? $id : ''; ?>"/>
 
<div class="container" style="text-align:center;">
<input id="yesBtn" type="submit" value="Yes" class="btn btn-primary btn-md" style="width:80px;margin-right:10px;" /><input id="noBtn" type="button" value="No" class="btn btn-primary btn-md" style="width:80px;margin-right:10px;"/>
</div>
<?php echo form_close(); 

?>

