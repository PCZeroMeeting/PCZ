 <script type="text/javascript">

 $( document ).ready(function() {
    var listElement = $('#newStuff');
	var perPage = 10; 
	var numItems = listElement.children().length;
	var numPages = Math.ceil(numItems/perPage);

	$('.pager').data("curr",0);

	var curr = 0;
	while(numPages > curr){
	  $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo('.pager');
	  curr++;
	}

	$('.pager .page_link:first').addClass('active');

	listElement.children().css('display', 'none');
	listElement.children().slice(0, perPage).css('display', 'block');

	$('.pager li a').click(function(){
	  var clickedPage = $(this).html().valueOf() - 1;
	  goTo(clickedPage,perPage);
	});
	


	function previous(){
	  var goToPage = parseInt($('.pager').data("curr")) - 1;
	  if($('.active').prev('.page_link').length==true){
		goTo(goToPage);
	  }
	}

	function next(){
	  goToPage = parseInt($('.pager').data("curr")) + 1;
	  if($('.active_page').next('.page_link').length==true){
		goTo(goToPage);
	  }
	}

	function goTo(page){
	  var startAt = page * perPage,
		endOn = startAt + perPage;
	  
	  listElement.children().css('display','none').slice(startAt, endOn).css('display','block');
	  $('.pager').attr("curr",page);
	}
	

	SiteCommon.GetUrlData("<?php echo base_url(); ?>index.php/links/getdisplaylist","",function(){},function(){});
});

 </script> 
 <div class="links-pagenation container">
    <div class="">
         <h4><?php echo !empty($title) ? $title : ""; ?></h4>

        <ul id="newStuff" class="nav nav-tabs nav-stacked">
<?php 
$titlelimit = 30;
$linklimit = 200;
$discriptionlimit = 500;
$displaylimit = 50;
foreach ($link_items as $item): 
			$title =  substr($item['title'],0,$titlelimit);
			$link = substr($item['link'],0,$linklimit);
			$displayFull = $title." (".$link;
			$display = substr($displayFull,0,$displaylimit);
			$display = $display.(strlen($displayFull) > $displaylimit ? "......" : "");
?>
		
            <li>
				<a  style="padding:0px 0px 0px 0px;" id="link_item_<?php echo $item['id']; ?>" target="_blank" title="<?php echo $item['title']; ?>" href="<?php echo $item['link']; ?>">
				<?php 		
				echo $display; 
				?>
				</a>
				
				<div id="div_item_<?php echo $item['id']; ?>" style="display:none;visibility:none;">
				<?php 		
					echo substr($item['description'],0,$discriptionlimit).(strlen($item['description']) > $discriptionlimit ? "......" : ""); 
				?>
				</div>
            </li>
 
<?php endforeach; ?>			
        </ul>
        <div class="pagination pagination-large" style="margin: 0px 0px 0px 0px;">
            <ul class="pager" style="margin: 0px 0px 0px 0px;"></ul>
        </div>
    </div>
</div>
 