<html>
        <head>
				  <meta charset="UTF-8">
				  <meta name="description" content="Contains awesome videos such as facebook videos, youtube videos , twitter videos, social media videos, latest scandal videos , video links">
				  <meta name="keywords" content="videos, links, facebook , youtube, twitter, naked, scandal, latest video,facebook videos, youtube videos">
				  <meta name="author" content="John Doe">
				  <meta name="viewport" content="width=device-width, initial-scale=1.0">		
                <title>Floxblinks</title>				
<?php 
$isAuthPath = false;
if (strpos($_SERVER['REQUEST_URI'], 'auth') !== false) {
	$isAuthPath = true;
} 

$userData = $this->ion_auth->user()->row();
$userName = '';
$isLogin = false;
if(!empty($userData) && $userData != null)
{
	
	$userName = $userData->username;
	if($userData->id > 0)
	{
		$isLogin = true;
	}
}	

if(empty($donotloadthemes) || !(!empty($donotloadthemes) && $donotloadthemes===true)){
?>
				<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>themes/css/jquery-ui.min.css">
				<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>themes/css/jquery-ui.structure.min.css">
				<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>themes/css/jquery-ui.theme.css">
				<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>themes/css/jquery-ui.theme.min.css">
				<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>themes/css/bootstrap.min.css">
				<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>themes/css/bootstrap-theme.min.css">
				<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>themes/css/jquery-ui-timepicker-addon.css">
				<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>themes/css/animate.css">
				<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>themes/css/style.css">

				<script language="javaScript" type="text/javascript" src = "<?php echo base_url(); ?>themes/js/crongenerate/categories.js"></script>
				
				<script language="javaScript" type="text/javascript" src = "<?php echo base_url(); ?>themes/js/jquery-3.2.1.min.js"></script>
				<script language="javaScript" type="text/javascript" src = "<?php echo base_url(); ?>themes/js/jquery-ui.min.js"></script>
				<script language="javaScript" type="text/javascript" src = "<?php echo base_url(); ?>themes/js/bootstrap.min.js"></script>
				<script language="javaScript" type="text/javascript" src = "<?php echo base_url(); ?>themes/js/jquery.bootpag.min.js"></script>
				<script language="javaScript" type="text/javascript" src = "<?php echo base_url(); ?>themes/js/bootstrap-notify.min.js"></script>
				<script language="javaScript" type="text/javascript" src = "<?php echo base_url(); ?>themes/js/jquery-ui-timepicker-addon.js"></script>
				
				<script language="javaScript" type="text/javascript" src = "<?php echo base_url(); ?>themes/js/site_global_ui.js"></script>				
				<script language="javaScript" type="text/javascript" src = "<?php echo base_url(); ?>themes/js/site_global_modal.js"></script>
				<script language="javaScript" type="text/javascript" src = "<?php echo base_url(); ?>themes/js/site_global.js"></script>
				<script language="javaScript" type="text/javascript" src = "<?php echo base_url(); ?>themes/js/site_links.js"></script>
				 <script type="text/javascript">
					var category = '<?php echo $category = $this->input->get('category', TRUE); ?>';
					SiteProperties = {};
					SiteProperties.base_url = "<?php echo base_url(); ?>";
					SiteCommon.base_url = "<?php echo base_url(); ?>";
					WidgetModal = new SiteUI.AddWidgetModal();
					LinksModal = new SiteUI.AddLinksModal();
					WidgetDeleteModal = new SiteUI.DeleteWidgetModal();
					DescriptionModal = new SiteUI.DescriptionModal();
					DropdownMenuItem = new SiteUI.DropdownMenuItem();
					$( document ).ready(function() {
						 $.each($('.summernote-text'),function (){
							$(this).summernote({
							  height: 100,                 // set editor height
							  minHeight: null,             // set minimum height of editor
							  maxHeight: null,             // set maximum height of editor
							  // focus: true,                  // set focus to editable area after initializing summernote
							  // onImageUpload: function(files, editor, welEditable) {
							  //           sendFile(files[0], editor, welEditable);
							  //       }
							});
						});
					 	var visible = 7;
						var itemHtml = '<li class="'+((category == "" || category == "all") ? 'active' : '')+'"><a href="?category=all" >All</></li>';	
						<?php 
						if($isLogin)
						{
						?>
							itemHtml += '<li class="'+(category == "own" ? 'active' : '')+'"><a href="?category=own" >My Links</></li>';	
						<?php
						}
						?>
						var i = 0;
						var categorySelectedInVisible = false;
						while(i < visible && i < SiteData.Categories.length){		
							itemHtml += '<li class="'+(category == SiteData.Categories[i] ? 'active' : '')+'"><a href="?category='+SiteData.Categories[i]+'" >'+ucwords(SiteData.Categories[i].replace(/_/g,' '))+'</a></li>';
							if(category == SiteData.Categories[i]){
								categorySelectedInVisible = true;
							}								
							i++;						
						} 
						if(category != "" && !categorySelectedInVisible && category != "own" && category != "all"){
							itemHtml += '<li class="active"><a href="?category='+category+'" >'+ucwords(category.replace(/_/g,' '))+'</a></li>';
						}
						
						itemHtml += '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>';
						itemHtml += '<ul class="dropdown-menu" role="menu">';
						while(i < SiteData.Categories.length){		
							itemHtml += '<li class="'+(category == SiteData.Categories[i] ? 'active' : '')+'"><a href="?category='+SiteData.Categories[i]+'" >'+ucwords(SiteData.Categories[i].replace(/_/g,' '))+'</a></li>';
							i++;
						} 
						itemHtml += '</ul>';
						itemHtml += '</li>';
						<?php 
						if($isLogin)
						{
						?> 
						itemHtml += '<li class=""><a href="#" id="addWidget" >LoggedIn Menu</></li>';	
						<?php
						}
						?>		 
						$("#navCategoryBar").html(itemHtml);
						
						
						$("#addWidget").on("click",function (event){
							event.preventDefault();
							//debugger;
							WidgetModal.Show();
						});
						
						$(".logo-before,.logo-mid,.logo-after").on("click",function (event){
							event.preventDefault();
							location.reload(); 
						});
						 
					});
				</script>
<?php 
}		
		
?>
 
        </head>
        <body>
<!--<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">-->
<body>
	<div id="warningSection">
		<div id="alertGlobalWarning" role="alert" class="alert alert-warning fade in hide">
		  <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		  <strong id="alertGlobalWarningTitle"></strong> 
		  <p id="alertGlobalWarningMsg"></p>
		</div>
	</div>
	<div id="errorSection">
		<div id="alertGlobalError" role="alert" class="alert alert-danger fade in hide">
		  <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		  <h4 id="alertGlobalErrorTitle"></h4>
		  <p id="alertGlobalErrorMsg"></p>
		  <p id="alertGlobalErrorButtonDiv" class="hide">
			<button class="btn btn-danger" type="button" id="alertGlobalErrorYesButton">Yes</button>
			<button class="btn btn-default" type="button" id="alertGlobalErrorNoButton">No</button>
		  </p>
		</div>
	</div>

	<div id="modalAlertGlobal" class="modal fade hide">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 id="modalAlertGlobalTitle" class="modal-title"></h4>
		  </div>
		  <div class="modal-body">
			<p id="modalAlertGlobalMsg"></p>
		  </div>
		  <div id="modalAlertGlobalButtonDiv" class="modal-footer">
			<button id="modalAlertGlobalYesButton" type="button" class="btn btn-primary">Yes</button>		  
			<button id="modalAlertGlobalNoButton" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
<nav class="navbar navbar-default" role="navigation" style="background-color: #e3f2fd;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!--<a class="navbar-brand" href="#">Login dropdown</a>-->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav" id="navCategoryBar">
        <li class="active"><a href="#">Link</a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul> <!--
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>-->
      <ul class="nav navbar-nav navbar-right">
		<?php if(!$isLogin){ ?>
        <li><p class="navbar-text" data-toggle="modal" data-target="#createUser" style="cursor:pointer;">Already have an account?</p></li>
		<?php }else{ ?>
		<li>
		<a href="<?php echo base_url(); ?>index.php/auth/user_profile?id=<?php echo $userData->id;?>" class="" style="cursor:pointer;"><?php echo $userName; ?></a>
		<!--<p class="navbar-text" data-toggle="modal" data-target="#editUser" style="cursor:pointer;"><-?php echo $userName; ?-></p>-->
		</li>
		<?php } ?>
        <li class="dropdown">
		  <?php if(!$isLogin){ ?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="loginLink"><b>Login</b> <span class="caret"></span></a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div class="row">
							<div class="col-md-12">
							<!-- 
								Login via
								<div class="social-buttons">
									<a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i> Facebook</a>
									<a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i> Twitter</a>
								</div>
                                or -->
								 <form class="form" role="form" method="post" action="<?php echo $isAuthPath? "" : "auth\\"?>login" accept-charset="UTF-8" id="login-nav">
										<input type="hidden" id="mode" name="mode" value="ajax" />
										<div class="form-group">
											 <label class="sr-only" for="exampleInputEmail2">Email address</label>
											 <input type="text" class="form-control" name="identity" id="identity" placeholder="Email address" required>
										</div>
										<div class="form-group">
											 <label class="sr-only" for="exampleInputPassword2">Password</label>
											 <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                             <div class="help-block text-right"><a href="">Forget the password ?</a></div>
										</div>
										<div class="form-group">
											 <button type="submit" class="btn btn-primary btn-block">Sign in</button>
										</div>
										<div class="checkbox">
											 <label>
											 <input type="checkbox" id="remember" name="remember"> keep me logged-in
											 </label>
										</div>
										<br><br>
										<div class="form-group" style="color:#999;font-size:12px;">
											 <label>
											 Contact:
											 </label>
											 <span><a href="mailto:floxbsupport@floxb.com">floxbsupport@floxb.com</a></span>
										</div>
										<div class="form-group" style="color:#999;font-size:12px;">
											 <label>
											 Floxb © 2017
											 </label> 
										</div>
								 </form>
							</div>
							<!--
							<div class="bottom text-center">
								New here ? <a href="#"><b>Join Us</b></a>
							</div>-->
					 </div>
				</li>
			</ul>
		  <?php } else { ?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="logoutLink"><b>Logout</b> <span class="caret"></span></a>
			<ul id="logout-dp" class="dropdown-menu">
				<li>
					 <div class="row">
							<div class="col-md-12">
								 <form class="form" role="form" method="post" action="<?php echo $isAuthPath? "" : "auth\\"?>logout" accept-charset="UTF-8" id="login-nav">
										<input type="hidden" id="mode" name="mode" value="ajax" />
										<div class="form-group">
											 <button type="submit" class="btn btn-primary btn-block">Sign out</button>
										</div>
								 </form>
							</div>
							<!--
							<div class="bottom text-center">
								New here ? <a href="#"><b>Join Us</b></a>
							</div>-->
					 </div>
				</li>
			</ul>
			<?php } ?>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>		
<div class="header">
  
  
  <h1 style="color:#ff2052;text-align:center;">
  <!-- <img class="logo-before" src="<?php echo base_url(); ?>themes/images/before.jpg" alt="logo" style="cursor:pointer;"/>-->
  <span class="logo-mid" style="cursor:pointer;">PCZ Auth</span>
  <!-- <img class="logo-after" src="<?php echo base_url(); ?>themes/images/after.jpg" alt="logo" style="cursor:pointer;"/>-->
  </h1>
    
</div>

	<!-- Modal -->
	<div id="createUser" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Register</h4>
		  </div>
		  <div class="modal-body">
			 <iframe frameBorder="0" style="height: 320px;width: 450px;" src="<?php echo base_url(); ?>index.php/auth/create_user?mode=ajax"></iframe> 
		  </div>
		   <!-- <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>-->
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
	
		<!-- Modal -->
	<div id="createWidget" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div id="createWidget" class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="widgetTitleDisplay">Create Widget</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="widgetId" name="widgetId" value=""/>
				<label for="widgetTitle" class="widget-label" style="margin-right:30px;display:none;">Title</label><input type="text" id="widgetTitle" name="widgetTitle" size="50" placeholder="Place title here.." value=""/>
				<span id="widgetTitleValidation" style="color:red;display:none;">*</span>
				<br/>
				<label for="widgetFilter" class="widget-label" style="margin-right:24px;display:none;">Filter</label><input type="text" id="widgetFilter" name="widgetFilter" size="50" placeholder="Place filter here.." value=""/>
				<span id="widgetFilterValidation" style="color:red;display:none;">*</span>
				<br/>
				<label for="widgetGroup" class="widget-label" style="margin-right:15px;display:none;">Group</label>
				<input type="text" id="widgetGroup" name="widgetGroup" size="50" placeholder="Place Group here.." value="left"/>
				<span id="widgetGroupValidation" style="color:red;display:none;">*</span>		 
				<select id="ddGroupName">
				  <option value="left">left</option>
				  <option value="right">right</option> 
				</select> 
				<br/>
				<label for="widgetDescription" class="widget-label" style="margin-right:30px;display:none;">Description</label><textarea rows="2" cols="50" id="widgetDescription" name="widgetDescription" placeholder="Type description of the link..."></textarea>
				<span style="color:red;display:none;">*</span> 
				<br/>
				<label for="widgetGroup" class="widget-label radio-label" style="margin-right:15px;margin-bottom:0px;">Vote Type</label>
				<div class="radio" style="margin:0px;">
				  <label><input type="radio" name="ddVoteType" value="multivote" >User can vote multiple candidates.</label>
				</div> <!-- $('input[name=ddVoteType]'); -->
				<div class="radio" style="margin:0px;">
				  <label><input type="radio" name="ddVoteType" value="onevote" >User can only vote one candidate.</label>
				</div>
				<br/>
				<label for="widgetGroup" class="widget-label radio-label" style="margin-right:15px;margin-bottom:0px;">Ordering</label>
				<div class="radio" style="margin:0px;">
				  <label><input type="radio" name="ddVotingOrdering" value="winnerfirst" >Winner First</label>
				</div> <!-- $('input[name=interview]'); -->
				<div class="radio" style="margin:0px;">
				  <label><input type="radio" name="ddVotingOrdering" value="loserfirst">Loser First</label>
				</div>
				<div class="radio" style="margin:0px;">
				  <label><input type="radio" name="ddVotingOrdering" value="newest">Newest</label>
				</div>
				<div class="radio" style="margin:0px;">
				  <label><input type="radio" name="ddVotingOrdering" value="oldest">Oldest</label>
				</div>
				<div class="radio" style="margin:0px;">
				  <label><input type="radio" name="ddVotingOrdering" value="priority">Priority</label>
				</div>				
				<br/>
				<label for="votingExpiryDate" class="widget-label" style="margin-right:15px;display:none;">Voting Expiry</label>				
				<input type="text" id="votingExpiryDate" name="votingExpiryDate" size="50" placeholder="Voting Expiry.." value=""/>
				<br/>
				<input type="checkbox" name="widgetIsActive" id="widgetIsActive" value="1" checked style="">Active<br>		
			</div>
			<div class="modal-footer">
				<button type="button" id="btnCreateWidget" class="btn btn-default" >Create Widget</button>
				<!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
			</div>  
		</div>

	  </div>
	</div>	
	
	<div id="deleteWidget" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div id="createWidget" class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="widgetTitleDisplay">Create Widget</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="widgetDeleteId" name="widgetDeleteId" value=""/>
				<span>Are you sure you want to delete widget </span><span class="widget-name"></span>
			</div>
			<div class="modal-footer">
				<button type="button" id="btnDeleteWidget" class="btn btn-default" >Yes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
			</div> 
		</div>

	  </div>
	</div>
	<div id="descriptionItem" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<input type="hidden" id="itemId" name="itemId" value=""/>
		<!-- Modal content-->
		<div id="descItem" class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="itemTitleDisplay">Description</h4>
			</div>
			<div class="modal-body">
				 
				<span id="descriptionData"></span> 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			</div> 
		</div>

	  </div>
	</div>
	
	<div id="dropdownMenuItem" class="modal" role="dialog">
	  <div class="modal-dialog">
		<input type="hidden" id="itemId" name="itemId" value=""/>
		<!-- Modal content-->
		<div id="descItem" class="modal-content">
			 <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<!-- <h4 class="modal-title" id="itemTitleDisplay">Description</h4>-->
			</div> 
			<div class="modal-body">
				 
				<div id="menuData"></div> 
			</div>
		</div>

	  </div>
	</div>	
	
                