<?php 
	$userData = $this->ion_auth->user()->row();
	
?>
 <script type="text/javascript">
 <?php  

	$createdById = 0;
	if(!empty($userData) && $userData != null)
	{
		$createdById = $userData->id;
	}	
	if(empty($createdById)) $createdById = 0;
 ?> 
 
window.closeModal = function(){
   $('.modal').modal('hide');
};


 $( document ).ready(function() {
	SiteUI.CreatedById = <?php echo $createdById; ?>;
	SiteUI.IsAdmin = <?php echo $this->ion_auth->is_admin() ? 'true' : 'false';?>;
	var titleOnlyDisplay = false;
	var hideBadges = false;
	var resultFilter = "hide_this";
	if(SiteLinks.ShowLinkListExecuted == 0){
		if (typeof category === 'undefined' || category=="") category = '<?php echo $category = $this->input->get('category', TRUE); ?>';	
		//debugger;
		SiteLinks.ShowLinkList(20,"","#createLinks_bottom","#content",category,SiteUI.CreatedById,SiteUI.IsAdmin,function(){
			//debugger;
			$(".action-edit-item").on("click",function (event){
				event.preventDefault(); 
				//debugger;
				LinksModal.ShowEditModal($(this));				
			});

			$(".action-delete-item").on("click",function (event){
				event.preventDefault(); 
				//debugger;
				LinksModal.DeleteModal($(this));
				
			});
			
			//$("#accordion_toggle_<?php $widgetid ?>").trigger("click");
			//<?php echo base_url(); ?>index.php/links/create
		},titleOnlyDisplay,hideBadges,resultFilter,null,null,Enums.VotingType.MultiVote,Enums.VotingOrdering.Newest);

		SiteLinks.ShowWidgets(20,"","#widget_bottom","#widget_content","left",SiteUI.CreatedById,SiteUI.IsAdmin,function(){
 
			$('#accordion').on('hidden.bs.collapse', SiteUI.ToggleChevron);
			$('#accordion').on('shown.bs.collapse', SiteUI.ToggleChevron);
			$('.accordion-toggle-left').on("click",function (event){
				event.preventDefault();
				var widgetid = $(this).attr("widgetid");
				var filter = $(this).attr("filter");
	 
				if($("#widget_display_"+widgetid).html()==""){
					SiteLinks.ShowLinkList(20,"","#widget_bottom_"+widgetid,"#widget_display_"+widgetid,filter,SiteUI.CreatedById,SiteUI.IsAdmin,function(){
						//debugger;
						$(".action-edit-item").on("click",function (event){
							event.preventDefault(); 
							LinksModal.ShowEditModal($(this));
						});

						$(".action-delete-item").on("click",function (event){
							event.preventDefault(); 
							LinksModal.DeleteModal($(this));
							
						});
					},true,false,null,null,widgetid,$("#accordion_toggle_"+widgetid).attr("votingtype"),$("#accordion_toggle_"+widgetid).attr("votingordering"));		
				}
				//
			});
			
			var widgetid = SiteCommon.GetParameterByName("widgetid");
			if(widgetid && widgetid > 0){
				$("#accordion_toggle_"+widgetid).trigger("click");
			}
		},"accordion");
			 
		//$("#btnAddLink").on("click",function (event){
		//	event.preventDefault(); 
		//	$("#frmAddLink").attr("src",'<?php echo base_url(); ?>index.php/links/create');
		//	$('#createModal').modal('show');			
		//});
		
		SiteLinks.ShowWidgets(20,"","#widget_bottom1","#widget_content1","right",SiteUI.CreatedById,SiteUI.IsAdmin,function(){
		 /*
			$(".widget-badge-edit-item").on("click",function (event){
				event.preventDefault();  
				WidgetModal.Show($(this).attr('link_id')); 
			});

			$(".widget-badge-delete-item").on("click",function (event){
				event.preventDefault();  
 
				WidgetDeleteModal.Show($(this).attr('link_id'),$("#accordion_toggle_"+$(this).attr('link_id')).text()); 
			}); 
			*/
			
			$('#accordion1').on('hidden.bs.collapse', SiteUI.ToggleChevron);
			$('#accordion1').on('shown.bs.collapse', SiteUI.ToggleChevron);
			
			$('.accordion-toggle-right').on("click",function (event){
				event.preventDefault();
				var widgetid = $(this).attr("widgetid");
				var filter = $(this).attr("filter");
	 
				if($("#widget_display_"+widgetid).html()==""){
					SiteLinks.ShowLinkList(20,"","#widget_bottom_"+widgetid,"#widget_display_"+widgetid,filter,SiteUI.CreatedById,SiteUI.IsAdmin,function(){
						//debugger;
						$(".action-edit-item").on("click",function (event){
							event.preventDefault(); 
							LinksModal.ShowEditModal($(this));
							
						});

						$(".action-delete-item").on("click",function (event){
							event.preventDefault(); 
							LinksModal.DeleteModal($(this));
							
						});
					},true,false,null,null,widgetid,$("#accordion_toggle_"+widgetid).attr("votingtype"),$("#accordion_toggle_"+widgetid).attr("votingordering"));		
				}
			});
			
			var widgetid = SiteCommon.GetParameterByName("widgetid");
			if(widgetid && widgetid > 0){
				$("#accordion_toggle_"+widgetid).trigger("click");
			}
		},"accordion1");
			 
		//$("#btnAddLink").on("click",function (event){
			//event.preventDefault(); 
			//$("#frmAddLink").attr("src",'<?php echo base_url(); ?>index.php/links/create');
			//$('#createModal').modal('show');			
		//});		
	}
	
	SiteLinks.ShowLinkListExecuted++;

});
		/*{"results":[
		   {
			  "id":"4",
			  "title":"titleeeee",
			  "link":"http:xx.com",
			  "tags":"radioactive news",
			  "description":"textsss",
			  "createdDate":"2017-05-01 14:55:11",
			  "createdById":"0",
			  "isActive":"1"
		   }
		],
		"rows":"18",
		"pagecount":3,
		"issuccess":true,
		"message":"success"
		}"*/

 </script> 
<div class="container" style="margin-left:0px;">
	<div class="link-container col-md-4" >
		<div class="panel-group" id="accordion_main">
			<div class="panel panel-default" item="item">
				<div class="panel-heading" style="position:relative;">
					<h4 class="panel-title">		
						<a id="accordion_toggle_main" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_main" widgetid="main" filter="">Awesome Social Media Videos</a>
						<i class="indicator glyphicon glyphicon-chevron-down pull-right" style="color:lightgray;"></i>
						<span class=" widget-badge-add-item badge badge-info glyphicon glyphicon-plus" id="widget_badge_add_main" link_id="main" filter="" style="white-space:nowrap;display:inline;background-color:#269abc;left:80%;" title="Add Link"></span>
					</h4>	
				</div>
				<div id="collapse_main" class="panel-collapse collapse in" style="" aria-expanded="true">	  
					<a href="#" class="widget-badge-add-item glyphicon glyphicon-plus" filter="" title="Add Link" style="float:right;margin-right:20px; "></a>
					<br />
					<div class="panel-body">		
						<div id="content"></div> 
						<!--<div id="createLinks"  style="margin-top:5px;"><button type="button" class="btn btn-info btn-sm"  id="btnAddLink">Add Link</button></div>-->
						<div id="createLinks_bottom"></div>	
					</div>
				</div>
			</div>
		</div>	
	</div>
	<div class="link-container col-md-8" id="widget_rightpane">
		<div class="link-container col-md-6">
		<div id="widget_content"></div>
		<div id="widget_bottom"></div>		 
		</div>
		<div class="link-container col-md-6">
		<div id="widget_content1"></div>
		<div id="widget_bottom1"></div>		 
		</div>		
	</div>

 
</div>


<!-- Modal -->
<div id="createModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content container" style="height: 400px;width: 600px;">
	  <div class="modal-header">		
		<a id="newWindowLink_create" href="#" class="glyphicon glyphicon-new-window" style=""></a>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Add Links</h4>
	  </div>
	  <div class="modal-body">
		 <iframe id="frmAddLink" frameBorder="0" style="height: 300px;width: 500px;" src=""></iframe> 
	  </div>
	   <!-- <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>-->
	</div>

  </div>
</div>
<!-- Modal -->
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content container" style="height: 400px;width: 600px;">
	  <div class="modal-header">
		<a id="newWindowLink_edit" href="#" class="glyphicon glyphicon-new-window" ></a>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Edit Links</h4>
	  </div>
	  <div class="modal-body">
		 <iframe id="editIframe" frameBorder="0" style="height: 300px;width: 500px;" src=""></iframe> 
	  </div>
	   <!-- <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>-->
	</div>

  </div>
</div>	
<!-- Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Delete Link</h4>
	  </div>
	  <div class="modal-body" style="text-align:center;">
		 <iframe id="deleteIframe" frameBorder="0" style="height: 100px;width: 300px;text-align:center;" src="#"></iframe> 
	  </div>
	   <!-- <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>-->
	</div>

  </div>
</div>	