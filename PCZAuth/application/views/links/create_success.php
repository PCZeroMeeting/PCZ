 <script type="text/javascript">

 $(document).ready(function() {
	 //$("#link").on("paste", function(e){
    // access the clipboard using the api
        // var pastedData = e.originalEvent.clipboardData.getData('text');
		//alert(pastedData);
	 //} );
	  
	
	//$("#link").on("keydown click focus", function(e) {
		 //e.preventDefault();
    
         //if($(this).val()== ""){
			//$("#link").trigger("paste");
			//alert(window.clipboardData.getData('Text'));
		 //}
    //});
	if(parent && SiteCommon.InIframe()){
		//parent.location.reload();
		var url = parent.location.href; 
		parent.location.href = SiteCommon.UpdateUrlParameter(url,'widgetid',<?php echo $widgetid;?>);
	}
});


 </script> 
 
Links Addition is a success! <a href="<?php echo base_url(); ?>index.php/links/create">Click here to add Link again..</a>
