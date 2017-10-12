 <script type="text/javascript">

 $(document).ready(function() {

	SiteUI.RegisterGenerateTagOptions("#tagsOptions");
 
	$("#showTags").on("click",function (event){
		event.preventDefault();
		$("#tags").slideToggle();
	});
});


 </script>

 <style>
.checkbox {
	margin: 0px 5px 0px 0px;
	padding: 0px 0px 0px 0px;
	position:relative;
	font-size:small;
} 
.input-checkbox{
	position:relative;
	
	margin-left : -13px;
} 
input[type=checkbox], input[type=radio]{
	margin: 2px 0px 0px;
		margin-left : -13px !important;
}
<?php if($fullscreenmode){}?>
 </style>
<?php 

$validateTxt = validation_errors(); 

$titleRequired = false;
$linkRequired = false;
$tagsRequired = false;
$descriptionRequired = false;

if (strpos($validateTxt, 'Title') !== false) {
    $titleRequired = true;
}
if (strpos($validateTxt, 'Link') !== false) {
    $linkRequired = true;
}
if (strpos($validateTxt, 'Tags') !== false) {
    $tagsRequired = true;
}
if (strpos($validateTxt, 'Description') !== false) {
    $descriptionRequired = true;
}
?>
<?php echo form_open('links/create'); ?>
<input type="hidden" id="widgetid" name="widgetid" value="<?php echo !empty($widgetid) ? $widgetid : ''; ?>"/>
<input type="hidden" id="fullscreenmode" name="fullscreenmode" value="<?php echo !empty($fullscreenmode) ? $fullscreenmode : ''; ?>"/>
<?php if($fullscreenmode){ echo "<br/>";}?>
<?php if($fullscreenmode){ echo '<a id="newWindowLink_home" href="'.base_url().'index.php?widgetid='.$widgetid.'" class="glyphicon glyphicon-new-window" style="margin-left:10px;"></a><br/><br/><div style="margin-left:10px;">';}?>
<input type="text" id="link" name="link" size="50" placeholder="Place link here.." value="<?php echo !empty($link) ? $link : ''; ?>"/>
<?php if($fullscreenmode){ echo "<br/>";}?>
<?php echo (($linkRequired) ? '<span style="color:red;display:inline;">*</span>' : ''); ?><br/>
<input type="text" id="title" name="title" size="50" placeholder="Place title here.." value="<?php echo !empty($title) ? $title : ''; ?>"/>
<?php echo (($titleRequired) ? '<span style="color:red;display:inline;">*</span>' : ''); ?><br/>


<div id="tagsOptions" style="margin-top:10px;"></div>

<span id="showTags" class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true" style="cursor:pointer;"></span><br/>
<textarea style="display:none;" rows="4" cols="50" id="tags" name="tags" placeholder="Type link tags for easy identification...">
<?php echo !empty($tags) ? $tags : ''; ?>
</textarea>

<?php echo (($tagsRequired) ? '<span style="color:red;display:inline;">*</span>' : ''); ?> 
<?php if($fullscreenmode){ echo "<br/>";}?>
<textarea rows="2" cols="50" id="description" name="description" placeholder="Type description of the link...">
<?php echo !empty($description) ? str_ireplace(array("<br />","<br>","<br/>"), "\r", $description) : ''; ?>
</textarea>
<?php echo (($descriptionRequired) ? '<span style="color:red;display:inline;">*</span>' : ''); ?>
<br/>
<input type="text" id="priority" name="priority" size="15" placeholder="Priority.." value="<?php echo !empty($priority) ? $priority : ''; ?>"/>
<br/><br/>
<div><input type="submit" value="Submit" /></div>
<?php if($fullscreenmode){ echo '</div>';}?>
<?php echo form_close(); 
echo $validateTxt;
?>

