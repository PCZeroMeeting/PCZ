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
		parent.location.reload();
	}
});


 </script> 
 
