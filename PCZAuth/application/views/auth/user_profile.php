<script type="text/javascript">
	$(document).ready(function() {
		$(".btn-pref .btn").click(function () {
			$(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
			// $(".tab").addClass("active"); // instead of this do the below 
			$(this).removeClass("btn-default").addClass("btn-primary");   
		});
		
		SiteUI.CreatedById = <?php echo $user->id; ?>;
		SiteUI.IsAdmin = <?php echo $this->ion_auth->is_admin() ? 'true' : 'false';?>;
		/*
		var titleOnlyDisplay = false;
		var hideBadges = false;		
		var resultFilter = "hide_this";
		if(SiteLinks.ShowLinkListExecuted == 0){
			if (typeof category === 'undefined' || category=="") category = '<?php echo $category = $this->input->get('category', TRUE); ?>';	
			SiteLinks.ShowLinkList(20,"","#createLinks_bottom","#content",category,SiteUI.CreatedById,SiteUI.IsAdmin,function(){
				
				$(".action-edit-item").on("click",function (event){
					event.preventDefault(); 
					
					LinksModal.ShowEditModal($(this));
				});

				$(".action-delete-item").on("click",function (event){
					event.preventDefault(); 
					LinksModal.DeleteModal($(this));
				});
				 
			},titleOnlyDisplay,hideBadges,resultFilter,"createdbyid="+SiteUI.CreatedById);	
		}
		*/		
	});
</script>

<div class="col-lg-6 col-sm-6">
    <div class="card hovercard">
        <div class="card-background">
            <img class="card-bkimg" alt="" src="<?php echo base_url(); ?>themes/images/after.jpg">
            <!-- http://lorempixel.com/850/280/people/9/ -->
        </div>
        <div class="useravatar">
            <img alt="" src="<?php echo base_url(); ?>themes/images/blank.png">
        </div>
        <div class="card-info"> <span class="card-title"><?php echo $user->username; ?></span>

        </div>
    </div>
    <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" id="stars" class="btn btn-primary" href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <div class="hidden-xs">User Details</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" id="favorites" class="btn btn-default" href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                <div class="hidden-xs">Posts</div>
            </button>
        </div>
		<!--
        <div class="btn-group" role="group">
            <button type="button" id="following" class="btn btn-default" href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <div class="hidden-xs">Following</div>
            </button>
        </div>-->
    </div>

        <div class="well">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1">
          <!--<h3>This is tab 1</h3>-->
		  <?php
		  if($show_first_name) { ?>
		  <p>
				<?php echo lang('create_user_fname_label', 'first_name');  ?> <br />
				<?php echo $user->first_name; ?>
		  </p>
		  <?php
		  }
		  if($show_last_name) {
		  ?>
		  <p>
				<?php echo lang('create_user_lname_label', 'last_name'); ?> <br />
				<?php echo $user->last_name; ?>
		  </p>
		  <?php
		  } 
		  ?>
		  <?php
		  if($identity_column!=='email' || $show_username) {
			  echo '<p>';
			  echo lang('create_user_identity_label', 'identity');
			  echo '<br />';
			  echo $user->username;
			  echo '</p>';
		  }
		  ?>
		  <?php
		  if($show_company) {
		  ?>
		  <p>
				<?php echo lang('create_user_company_label', 'company'); ?> <br />
				<?php echo $user->company; ?>
		  </p>
		  <?php
		  } 
		  ?>
		  <p>
				<?php echo lang('create_user_email_label', 'email');?> <br />
				<?php echo $user->email;?>
		  </p>
		  <?php
		  if($show_phone) {
		  ?>
		  <p>
				<?php echo lang('create_user_phone_label', 'phone'); ?> <br />
				<?php echo $user->phone; ?>
		  </p>
		  <?php
		  } 
		  ?>		
		  <a class="" href="javascript:void(0);" data-toggle="modal" data-target="#editUser" style="cursor:pointer;">Edit Password</a>		  
        </div>
        <div class="tab-pane fade in" id="tab2">
			<!--<h3>This is tab 2</h3>-->
			<div class="link-container " >
				<div id="content"></div>
				<div id="createLinks"  style="margin-top:5px;"><button type="button" class="btn btn-info btn-sm"  id="btnAddLink">Add Link</button></div>
				<div id="createLinks_bottom"></div>	
			</div>		  
        </div>
		<!--
        <div class="tab-pane fade in" id="tab3">
          <h3>This is tab 3</h3>
        </div>
		-->
      </div>		
    </div>
    
    </div>

	<!-- Modal -->
	<div id="editUser" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit User</h4>
		  </div>
		  <div class="modal-body">
			 <iframe frameBorder="0" style="height: 320px;width: 450px;" src="<?php echo base_url(); ?>index.php/auth/change_password?mode=ajax"></iframe> 
		  </div>
		   <!-- <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>-->
		</div>

	  </div>
	</div>	
    