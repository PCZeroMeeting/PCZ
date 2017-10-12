<script language="javaScript" type="text/javascript" src = "<?php echo base_url(); ?>themes/js/jquery-3.2.1.min.js"></script>
				
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
	if(parent){
		parent.location.reload();
	}
});


 </script> 
 
Registering is a success! <a href="<?php echo base_url(); ?>index.php/links/create">View Home Page..</a>
