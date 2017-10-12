SiteLinks = {};
SiteLinks.ShowLinkListExecuted = 0;

//////////////////////////////SiteLinks.ShowLinkList
//Enums.VotingType.OneVote
//Enums.VotingType.MultiVote
//
//Enums.VotingOrdering.LoserFirst
//Enums.VotingOrdering.WinnerFirst
//Enums.VotingOrdering.Newest
//Enums.VotingOrdering.Oldest

SiteLinks.ShowLinkList = function (rowPerPage,topJsSelector,bottomJsSelector,contentJsSelector,categoryData,
								createdByIdData,isAdmin,successCallBack,
								titleOnlyDisplay,hideBadges,resultFilter,
								queryStringExtension,widgetId,votingType,votingordering){
	var isFirstAnObject = (rowPerPage !== null && typeof rowPerPage === 'object');
	var isSecondAnObject = (topJsSelector !== null && typeof topJsSelector === 'object');
	//debugger;
	if(isFirstAnObject || isSecondAnObject){
		var criteria = null;
		
		if(isFirstAnObject){ 
			criteria = rowPerPage;		
			rowPerPage = criteria.RowPerPage;
		}
		else if(isSecondAnObject) { criteria = topJsSelector;}
		if(criteria != null){
			topJsSelector = criteria.TopJsSelector;
			bottomJsSelector = criteria.BottomJsSelector;
			contentJsSelector = criteria.ContentJsSelector;
			categoryData = criteria.CategoryData;
			createdByIdData = criteria.CreatedByIdData;
			isAdmin = criteria.IsAdmin;
			successCallBack = criteria.SuccessCallBack;
			titleOnlyDisplay = criteria.TitleOnlyDisplay;
			hideBadges = criteria.HideBadges;
			resultFilter = criteria.ResultFilter;
			queryStringExtension = criteria.QueryStringExtension;
			widgetId = criteria.WidgetId;
			votingType = criteria.VotingType;
			votingordering = criteria.VotingOrdering;
		}
	}
		
	if(!hideBadges) hideBadges = false;
	if(!titleOnlyDisplay) titleOnlyDisplay = false;
	if(!createdByIdData) createdByIdData=0;
	if(!rowPerPage) rowPerPage = 20;
	if(!topJsSelector) topJsSelector = "";
	if(!bottomJsSelector) bottomJsSelector = "";
	if(!contentJsSelector) contentJsSelector = "";
	if(!resultFilter) resultFilter = "";
	if(!queryStringExtension) queryStringExtension = "";
	if(!widgetId) widgetId = 0;
	if(!votingType) votingType = "";//onevote,multivote
	if(!votingordering) votingordering = "";//loserfirst,winnerfirst,newest,oldest

	SiteCommon.GetUrlData(SiteCommon.base_url+"index.php/links/getdisplaylist?page=1&rows="+rowPerPage+"&category="+categoryData+"&filterout="+resultFilter+"&votingType="+votingType+"&votingordering="+votingordering+"&"+queryStringExtension,"",function(jsonResultData){
		////array('results'=>$results,'rows'=>$rows,'pagecount' => $pageCount);
		if(jsonResultData != null){
			jsonResultData = JSON.parse(jsonResultData);
			if(jsonResultData.issuccess){
				if(jsonResultData.pagecount <= 1){
					$(bottomJsSelector).hide();
				}
				else {
					$(bottomJsSelector).show();
				}				
				jsonResultData.rows = parseInt(jsonResultData.rows);
				var selectorStr = topJsSelector != "" ? (topJsSelector +","+bottomJsSelector) : bottomJsSelector;
				$(selectorStr).bootpag({
					total: jsonResultData.pagecount,
					page: 1,
					maxVisible: 10,
					leaps: true,
					firstLastUse: true,
					first: '?',
					last: '?',
					wrapClass: 'pagination',
					activeClass: 'active',
					disabledClass: 'disabled',
					nextClass: 'next',
					prevClass: 'prev',
					lastClass: 'last',
					firstClass: 'first'
				}).on("page", function(event, num){
					$(".content4").html("Page " + num); // or some ajax content loading...
					SiteCommon.GetUrlData(SiteCommon.base_url+"index.php/links/getdisplaylist?page="+num+"&rows="+rowPerPage+"&category="+categoryData+"&filterout="+resultFilter,"",function(jsonResultData){
						////array('results'=>$results,'rows'=>$rows,'pagecount' => $pageCount);
						if(jsonResultData != null){
							jsonResultData = JSON.parse(jsonResultData);
							if(jsonResultData.issuccess){
								if(jsonResultData.pagecount <= 1){
									$(bottomJsSelector).hide();
								}
								else {
									$(bottomJsSelector).show();
								}								
								jsonResultData.rows = parseInt(jsonResultData.rows);
								SiteLinks.DisplayItems(jsonResultData.results,contentJsSelector,createdByIdData,isAdmin,titleOnlyDisplay,hideBadges,resultFilter,categoryData,widgetId,votingType);
							}
							else{
								SiteLinks.DisplayItems(null,contentJsSelector,createdByIdData,isAdmin,titleOnlyDisplay,hideBadges,resultFilter,categoryData,widgetId,votingType);
							}
						}
						else  {
							SiteLinks.DisplayItems(null,contentJsSelector,createdByIdData,isAdmin,titleOnlyDisplay,hideBadges,resultFilter,categoryData,widgetId,votingType);
						}
						
						if(successCallBack){
							successCallBack(jsonResultData);
						}
					},function(){});					
				}); 
				SiteLinks.DisplayItems(jsonResultData.results,contentJsSelector,createdByIdData,isAdmin,titleOnlyDisplay,hideBadges,resultFilter,categoryData,widgetId,votingType);
				if(successCallBack){
					successCallBack();
				}
			}
			else{
				SiteLinks.DisplayItems(null,contentJsSelector,createdByIdData,isAdmin,titleOnlyDisplay,hideBadges,resultFilter,categoryData,widgetId,votingType);
				if(successCallBack){
					successCallBack();
				}				
			}
		}
		else  {
			SiteLinks.DisplayItems(null,contentJsSelector,createdByIdData,isAdmin,titleOnlyDisplay,hideBadges,resultFilter,categoryData,widgetId,votingType);
			if(successCallBack){
				successCallBack();
			}			
		}
	},function(){},$(bottomJsSelector).parent().parent());
};
					
SiteLinks.DisplayItems = function (results,contentJsSelector,createdByIdData,isAdmin,titleOnlyDisplay,hideBadges,resultFilter,categoryData,widgetId,votingType){
	if(!hideBadges) hideBadges = false;
	if(!resultFilter) resultFilter = "";
	if(!contentJsSelector) contentJsSelector = "#content";
	var itemTempateHeader = '        <ul id="newStuff" class="nav nav-tabs nav-stacked">		';

	var itemTempateRow = '';
	
	var itemTempateFooter = '        </ul>';
	var titlelimit = 40;
	var linklimit = 100;
	var descriptionlimit = 500;
	var displaylimit = 40;
	
	if(results != null){
		for(var i = 0;i < results.length;i++){
			var item = results[i];
			var iscategory = (item.tags.includes(categoryData) && !(categoryData == "all" || categoryData == ""));
			//if(resultFilter != "" && item.tags.includes(resultFilter) && !iscategory){ 
			//	continue;
			//}
			var createdById = item.createdById;
			var id = item.id;
			var link = item.link.substring(0, linklimit);
			link = link.replace("\\","");
			link = link.replace("//","");
			link = link.replace("https:","");
			link = link.replace("http:","");
			link = link.replace("www.","");
			var title = item.title.substring(0, titlelimit);
			var description = item.description.substring(0, descriptionlimit);
			var display = titleOnlyDisplay ? title : (title+"|"+link).substring(0, displaylimit)+"...";
			var isnew = item.isnew;
			
			var okEditDelete = (createdById !=0 && createdById == createdByIdData) || isAdmin;
 
			var badgesHtml = '<div id="badge_edit_item_'+id+'" class="badge-edit-item" style="">'+
			(votingType == Enums.VotingType.OneVote ? '<span class="reaction-vote glyphicon glyphicon-arrow-up item-default-color badge-vote-'+id+'" id="badge_vote_'+id+'" widgetid="'+widgetId+'" link_id="'+id+'" oldreaction="-" style="white-space:nowrap;display: inline;font-size: small;cursor:pointer;" title="Vote">'+SiteCommon.GetValueOrDefault(item.votes,0)+'</span>' : "")+
			(votingType == Enums.VotingType.MultiVote ? '<span class="reaction-up glyphicon glyphicon-arrow-up item-default-color badge-up-'+id+'" id="badge_up_'+id+'" link_id="'+id+'" oldreaction="-" style="white-space:nowrap;display: inline;font-size: small;cursor:pointer;" title="Move Up">'+SiteCommon.GetValueOrDefault(item.reactionUp,0)+'</span>' : "")+
			(votingType == Enums.VotingType.MultiVote ? '<span class="reaction-down glyphicon glyphicon-arrow-down item-default-color badge-down-'+id+'" id="badge_down_'+id+'" link_id="'+id+'" oldreaction="-" style="white-space:nowrap;display: inline;font-size: small;cursor:pointer;" title="Move Down">'+SiteCommon.GetValueOrDefault(item.reactionDown,0)+'</span>' : "")+
			'<span class="glyphicon glyphicon-collapse-down item-default-color badge-details-'+id+'" id="badge_details_'+id+'" link_id="'+id+'"  style="white-space:nowrap;display: inline;font-size: small;cursor:pointer;" title="Move Down" data-toggle="collapse" data-target="#collapseExample_'+id+'_'+widgetId+'" aria-expanded="false" aria-controls="collapseExample_'+id+'_'+widgetId+'">&nbsp;</span>'+
			'</div><div class="collapse" id="collapseExample_'+id+'_'+widgetId+'"><div class="card card-body" style="padding: 0px;margin:0px;">'+
			'<div class="panel panel-default">'+
			'  <div class="panel-heading"><span></span>'+
			(!hideBadges && okEditDelete ? (
			'	<a href="#" class="action-delete-item glyphicon glyphicon-remove" link_id="'+id+'" widgetId="'+widgetId+'" title="Delete Link" style="float:right;"></a>&nbsp;&nbsp;'+			
			'	<a href="#" class="action-edit-item glyphicon glyphicon-edit" link_id="'+id+'" widgetId="'+widgetId+'" title="Edit Link" style="float:right;margin-right:20px;"></a>'
			) : '')+
			'  </div>'+
			'  <div class="panel-body">'+
			'    '+item.description+''+
			'  </div>'+
			'  <div class="panel-footer">Posted by: <a href="'+SiteCommon.base_url+'index.php/auth/user_profile?id='+(item.userid == null? '#' : item.userid)+'" class="glyphicon glyphicon-user" target="_blank">&nbsp;'+(item.username == null ? 'anonymous' : item.username)+'</a></div>'+
			'</div>'+
			'</div></div>';
 
			itemTempateRow = itemTempateRow+''+
			'            <li id="list_item_link_'+id+'" class="list-item-link list-item-link-'+id+'" itemid="'+id+'">'+
			//'               <span>'+item.createdDate+'</span>'+style="display: inline"
			'				<a  style="padding:0px 0px 0px 0px;display: inline;" id="link_item_'+id+'" '+
			'				target="_blank" title="'+item.title+'" href="'+item.link+'">'+display+
			(isnew == 1 ? '<span class="badge-new-item badge">new</span>' : '')+					
			'				</a>'+ badgesHtml +
			'				<div id="div_item_'+id+'" style="display:none;visibility:none;">				'+description+
			'				</div>'+
			'            </li>';
 
		}
		for(var i = 0;i < results.length;i++){
			var item = results[i];
			SiteLinks.UpdateReactions(item.id,createdByIdData,null);
		}
		
		
	}
	$(contentJsSelector).html(itemTempateHeader+itemTempateRow+itemTempateFooter);
	
	$(".list-item-link").off("mouseover");
	$(".list-item-link").on("mouseover",function (event){
		
		var itemid=$(this).attr("itemid");
		//$("#div_btn_item_menu_"+itemid).show(); 
		$("#div_btn_item_menu_"+itemid+" .caret").css("color","gray");
	});
	$(".list-item-link").off("mouseout");
	$(".list-item-link").on("mouseout",function (event){
		event.preventDefault();
		var itemid=$(this).attr("itemid");
		//$("#div_btn_item_menu_"+itemid).hide();
		//$("#div_btn_item_menu_"+itemid).fadeOut( "slow");
		$("#div_btn_item_menu_"+itemid+" .caret").css("color","white");
		
	});	
 
	$(".reaction-up").off("click");
	$(".reaction-up").on("click",function (event){
		event.preventDefault();
		$me = $(this);
		var link_id=$(this).attr("link_id");
		var widgetid =$(this).attr("widgetid");
		
		//SiteLinks.SaveReaction = function (reference,referenceId,reaction,oldreaction,createdbyid,$loadingObject,SuccessCallback, ErrorCallback)
		//TODO: we need to put the oldreaction, the old reaction data will be acquired by SiteLinks.GetReaction
		SiteLinks.SaveReaction("weblinksdata",link_id,"up",$me.attr("oldreaction"),createdByIdData,widgetid,$("#badge_edit_item_"+link_id),function (data){
			//debugger;
			if(data.issuccess){				
				SiteLinks.UpdateItem(data.referenceData,data.reactionData);
				SiteUI.Alert("Voting up a success!","","success");
			}
			else {
				SiteUI.Alert(data.message);
			}
			//alert("success");
		},function (data){
			//debugger;
			//alert("error");
		});
		//$("#div_btn_item_menu_"+itemid).show();
	});
	$(".reaction-down").off("click");
	$(".reaction-down").on("click",function (event){
		event.preventDefault();
		$me = $(this); 
		var link_id=$(this).attr("link_id");
		var widgetid =$(this).attr("widgetid");
		
		//SiteLinks.SaveReaction = function (reference,referenceId,reaction,oldreaction,createdbyid,$loadingObject,SuccessCallback, ErrorCallback)
		//TODO: we need to put the oldreaction, the old reaction data will be acquired by SiteLinks.GetReaction
		SiteLinks.SaveReaction("weblinksdata",link_id,"down",$me.attr("oldreaction"),createdByIdData,widgetid,$("#badge_edit_item_"+link_id),function (data){
			//debugger;
			if(data.issuccess){
				SiteLinks.UpdateItem(data.referenceData,data.reactionData);
				SiteUI.Alert("Voting down a success!","","success");
			}
			else {
				SiteUI.Alert(data.message);
			}
			//alert("success");
		},function (data){
			//debugger;
			SiteUI.Alert(data.message);
		});
		//$("#div_btn_item_menu_"+itemid).show();
		//$("#div_btn_item_menu_"+itemid).hide();
	});	
	$(".reaction-vote").off("click");
	$(".reaction-vote").on("click",function (event){
		event.preventDefault();
		$me = $(this); 
		var link_id=$(this).attr("link_id");
		var widgetid =$(this).attr("widgetid");
		//SiteLinks.SaveReaction = function (reference,referenceId,reaction,oldreaction,createdbyid,$loadingObject,SuccessCallback, ErrorCallback)
		//TODO: we need to put the oldreaction, the old reaction data will be acquired by SiteLinks.GetReaction
		//debugger;
		SiteLinks.SaveReaction("weblinksdata",link_id,"vote",$me.attr("oldreaction"),createdByIdData,widgetid,$("#badge_edit_item_"+link_id),function (data){
			//debugger;
			if(data.issuccess){
				SiteLinks.UpdateItem(data.referenceData,data.reactionData,data.lastVoteRefId);
				SiteUI.Alert("Voting down a success!","","success");
			}
			else {
				SiteUI.Alert(data.message);
			}
			//alert("success");
		},function (data){
			//debugger;
			SiteUI.Alert(data.message);
		});
		//$("#div_btn_item_menu_"+itemid).show();
		//$("#div_btn_item_menu_"+itemid).hide();
	});		
};

SiteLinks.UpdateItem = function (weblinkData,reactionData,lastVoteRefId){
	var $badgeups = null;
	var $badgedowns = null;
	var $badgevotes = null;
	var $badgeoldvote = null;
	
	if(weblinkData != null){
		$badgeups = $(".badge-up-"+weblinkData.id);
		$badgedowns = $(".badge-down-"+weblinkData.id);
		$badgevotes = $(".badge-vote-"+weblinkData.id);
		if(lastVoteRefId !== 0 && lastVoteRefId > 0){
			$badgeoldvote = $(".badge-vote-"+lastVoteRefId);
		}
		
		$badgeups.removeClass("item-default-color").removeClass("item-selected-color").addClass("item-default-color");
		$badgedowns.removeClass("item-default-color").removeClass("item-selected-color").addClass("item-default-color");
		$badgevotes.removeClass("item-default-color").removeClass("item-selected-color").addClass("item-default-color");
		if($badgeoldvote != null){
			$badgeoldvote.removeClass("item-default-color").removeClass("item-selected-color").addClass("item-default-color");
		}
		$.each($badgeups,function(item){
			$(this).text(SiteCommon.GetValueOrDefault(weblinkData.reactionUp,0));
		});
		
		$.each($badgedowns,function(item){
			$(this).text(SiteCommon.GetValueOrDefault(weblinkData.reactionDown,0));
		});	
		//lastVoteRefId
		$.each($badgevotes,function(item){
			$(this).text(SiteCommon.GetValueOrDefault(weblinkData.votes,0));
		});
		if($badgeoldvote != null){
			$.each($badgeoldvote,function(item){
				$(this).text(0);
			});
		}
	}
	//debugger;
	if(reactionData != null){
		if($badgeups == null){
			$badgeups = $(".badge-up-"+reactionData.referenceId);
		}
		if($badgedowns == null){
			$badgedowns = $(".badge-down-"+reactionData.referenceId);
		}
		if($badgevotes == null){
			$badgevotes = $(".badge-vote-"+reactionData.referenceId);
		}
		
		if($badgeoldvote == null && lastVoteRefId !== 0 && lastVoteRefId > 0){
			$badgeoldvote = $(".badge-vote-"+lastVoteRefId);
		}
		
		$badgeups.removeClass("item-default-color").removeClass("item-selected-color").addClass("item-default-color");
		$badgedowns.removeClass("item-default-color").removeClass("item-selected-color").addClass("item-default-color");
		$badgevotes.removeClass("item-default-color").removeClass("item-selected-color").addClass("item-default-color");
		if($badgeoldvote != null){
			$badgeoldvote.removeClass("item-default-color").removeClass("item-selected-color").addClass("item-default-color");
		}
		
		if(reactionData.reaction == "up"){
			$badgeups.addClass("item-selected-color");
		}
		else if(reactionData.reaction == "down"){
			$badgedowns.addClass("item-selected-color");
		}
		else if(reactionData.reaction == "vote"){
			$badgevotes.addClass("item-selected-color");
		}
	}
};
SiteLinks.ShowWidgets = function (rowPerPage,topJsSelector,bottomJsSelector,contentJsSelector,categoryData,createdByIdData,isAdmin,successCallBack,accordionId){
	if(!createdByIdData) createdByIdData=0;
	if(!rowPerPage) rowPerPage = 20;
	if(!topJsSelector) topJsSelector = "";
	if(!bottomJsSelector) bottomJsSelector = "";
	if(!contentJsSelector) contentJsSelector = "";
	if(!accordionId) accordionId = "accordion";
	
	SiteCommon.GetUrlData(SiteCommon.base_url+"index.php/links/GetWidgetDisplaylist?page=1&rows="+rowPerPage+"&category="+categoryData,"",function(jsonResultData){
		////array('results'=>$results,'rows'=>$rows,'pagecount' => $pageCount);
		if(jsonResultData != null){
			//debugger;
			jsonResultData = JSON.parse(jsonResultData);
			if(jsonResultData.issuccess){
				if(jsonResultData.pagecount <= 1){
					$(bottomJsSelector).hide();
				}
				else {
					$(bottomJsSelector).show();
				}
				jsonResultData.rows = parseInt(jsonResultData.rows);
				var selectorStr = topJsSelector != "" ? (topJsSelector +","+bottomJsSelector) : bottomJsSelector;
				$(selectorStr).bootpag({
					total: jsonResultData.pagecount,
					page: 1,
					maxVisible: 10,
					leaps: true,
					firstLastUse: true,
					first: '?',
					last: '?',
					wrapClass: 'pagination',
					activeClass: 'active',
					disabledClass: 'disabled',
					nextClass: 'next',
					prevClass: 'prev',
					lastClass: 'last',
					firstClass: 'first'
				}).on("page", function(event, num){
					$(".content4").html("Page " + num); // or some ajax content loading...
					SiteCommon.GetUrlData(SiteCommon.base_url+"index.php/links/GetWidgetDisplaylist?page="+num+"&rows="+rowPerPage+"&category="+categoryData,"",function(jsonResultData){
						////array('results'=>$results,'rows'=>$rows,'pagecount' => $pageCount);
						if(jsonResultData != null){
							jsonResultData = JSON.parse(jsonResultData);
							if(jsonResultData.issuccess){
								if(jsonResultData.pagecount <= 1){
									$(bottomJsSelector).hide();
								}
								else {
									$(bottomJsSelector).show();
								}								
								jsonResultData.rows = parseInt(jsonResultData.rows);
								SiteLinks.DisplayWidgetItems(jsonResultData.results,contentJsSelector,createdByIdData,isAdmin,accordionId,categoryData);
							}
							else{
								SiteLinks.DisplayWidgetItems(null,contentJsSelector,createdByIdData,isAdmin,accordionId,categoryData);
							}
						}
						else  {
							SiteLinks.DisplayWidgetItems(null,contentJsSelector,createdByIdData,isAdmin,accordionId,categoryData);
						}
						
						if(successCallBack){
							successCallBack(jsonResultData);
						}
						$(".widget-badge-edit-item").off("click");
						$(".widget-badge-delete-item").off("click");						
						$(".widget-badge-add-item").off("click");
						$(".widget-badge-add-item").on("click",function (event){
							event.preventDefault(); 
							//debugger;
							//$("#frmAddLink").attr("src",SiteCommon.base_url+'index.php/links/create');
							//$('#createModal').modal('show');
							LinksModal.ShowCreateModal($(this));
						});
		
						$(".widget-badge-edit-item").on("click",function (event){
							event.preventDefault();  
							WidgetModal.Show($(this).attr('link_id')); 
						});

						$(".widget-badge-delete-item").on("click",function (event){
							event.preventDefault();  
							WidgetDeleteModal.Show($(this).attr('link_id'),$("#accordion_toggle_"+$(this).attr('link_id')).text()); 
						}); 
			
					},function(){});					
				}); 
				SiteLinks.DisplayWidgetItems(jsonResultData.results,contentJsSelector,createdByIdData,isAdmin,accordionId,categoryData);
				$(".widget-badge-edit-item").off("click");
				$(".widget-badge-delete-item").off("click");
				$(".widget-badge-add-item").off("click");
				$(".widget-badge-add-item").on("click",function (event){
					event.preventDefault(); 
					//debugger;
					//$("#frmAddLink").attr("src",SiteCommon.base_url+'index.php/links/create?filter='+$(this).attr('filter'));
					//$('#createModal').modal('show');
					LinksModal.ShowCreateModal($(this));
				});				
				$(".widget-badge-edit-item").on("click",function (event){
					event.preventDefault();  
					WidgetModal.Show($(this).attr('link_id')); 
				});

				$(".widget-badge-delete-item").on("click",function (event){
					event.preventDefault();  
					WidgetDeleteModal.Show($(this).attr('link_id'),$("#accordion_toggle_"+$(this).attr('link_id')).text()); 
				});
				if(successCallBack){
					successCallBack();
				}
			}
			else{
				SiteLinks.DisplayWidgetItems(null,contentJsSelector,createdByIdData,isAdmin,accordionId,categoryData);
				$(".widget-badge-edit-item").off("click");
				$(".widget-badge-delete-item").off("click");
				$(".widget-badge-add-item").off("click");
				$(".widget-badge-add-item").on("click",function (event){
					event.preventDefault(); 
					//debugger;
					//$("#frmAddLink").attr("src",SiteCommon.base_url+'index.php/links/create?filter='+$(this).attr('filter'));
					//$('#createModal').modal('show');
					LinksModal.ShowCreateModal($(this));
				});				
				
				$(".widget-badge-edit-item").on("click",function (event){
					event.preventDefault();  
					WidgetModal.Show($(this).attr('link_id')); 
				});

				$(".widget-badge-delete-item").on("click",function (event){
					event.preventDefault();  
					WidgetDeleteModal.Show($(this).attr('link_id'),$("#accordion_toggle_"+$(this).attr('link_id')).text()); 
				});
				if(successCallBack){
					successCallBack();
				}				
			}
		}
		else  {
			SiteLinks.DisplayWidgetItems(null,contentJsSelector,createdByIdData,isAdmin,accordionId,categoryData);
				$(".widget-badge-edit-item").off("click");
				$(".widget-badge-delete-item").off("click");
				$(".widget-badge-add-item").off("click");
				$(".widget-badge-add-item").on("click",function (event){
					event.preventDefault(); 
					//debugger;
					//$("#frmAddLink").attr("src",SiteCommon.base_url+'index.php/links/create?filter='+$(this).attr('filter'));
					//$('#createModal').modal('show');
					LinksModal.ShowCreateModal($(this));
				});				
				
				$(".widget-badge-edit-item").on("click",function (event){
					event.preventDefault();  
					WidgetModal.Show($(this).attr('link_id')); 
				});

				$(".widget-badge-delete-item").on("click",function (event){
					event.preventDefault();  
					WidgetDeleteModal.Show($(this).attr('link_id'),$("#accordion_toggle_"+$(this).attr('link_id')).text()); 
				});
			if(successCallBack){
				successCallBack();
			}			
		}
	},function(){});
};
					
SiteLinks.DisplayWidgetItems = function (results,contentJsSelector,createdByIdData,isAdmin,accordionId,categoryData){
	if(!contentJsSelector) contentJsSelector = "#content";
	if(!accordionId) accordionId = "accordion";
	
	var itemTempateHeader = '        	<div class="link-container">'+
		'<div class="panel-group" id="'+accordionId+'">';

	var itemTempateRow = '';
	
	var itemTempateFooter = '		</div>	'+
	'</div>';
	var titlelimit = 30;
	var linklimit = 200;
	var descriptionlimit = 500;
	var displaylimit = 50;
	
	if(results != null){
		for(var i = 0;i < results.length;i++){
			var item = results[i];
			var createdById = item.createdById;
			var id = item.id;
			var filter = item.filter_query.substring(0, linklimit);
			var title = item.title.substring(0, titlelimit);
			var titleNoLimit = item.title;
			var description = item.description.substring(0, descriptionlimit);
			var votingtype = item.votingtype;
			var votingordering = item.votingordering;
			var votingexpirydate = item.votingexpirydate;
			
			//var display = (title+"|"+link).substring(0, displaylimit)+"...";
			var isnew = item.isnew;
			
			itemTempateRow = itemTempateRow+'  <div class="panel panel-default" item="item">'+
			'	<div class="panel-heading" style="position:relative;">'+
			'	  <h4 class="panel-title">'+
			'		<a id="accordion_toggle_'+id+'" title="'+titleNoLimit+'" class="accordion-toggle-'+categoryData+'" data-toggle="collapse" data-parent="#'+accordionId+'" href="#collapse_'+id+'" widgetid="'+id+'" votingtype="'+votingtype+'" votingordering="'+votingordering+'" votingexpirydate="'+votingexpirydate +'" filter="'+filter+'">'+
			'		 '+title+
			'		</a><i class="indicator glyphicon glyphicon-chevron-up pull-right"></i>'+
			'	  </h4>'+
			//((createdById !=0 && createdById == createdByIdData) || isAdmin ? '<span class=" widget-badge-add-item badge badge-info glyphicon glyphicon-plus" id="widget_badge_add_'+id+'" link_id="'+id+'" filter="'+filter+'" style="white-space:nowrap;display:inline;background-color:#269abc;" title="Add Link"></span>' : '')+				
			//((createdById !=0 && createdById == createdByIdData) || isAdmin ? '<span class=" widget-badge-edit-item badge badge-info glyphicon glyphicon-edit" id="widget_badge_edit_'+id+'" link_id="'+id+'" style="white-space:nowrap;display:inline;" title="Edit Widget"></span>' : '')+				
			//((createdById !=0 && createdById == createdByIdData) || isAdmin ? '<span class=" label-danger widget-badge-delete-item badge badge-info glyphicon glyphicon-remove" id="widget_badge_delete_'+id+'" link_id="'+id+'" style="white-space:nowrap;background-color:#d9534f;display:inline;"  title="Delete Widget"></span>' : '')+																						
			'	</div>'+
			'	<div id="collapse_'+id+'" class="panel-collapse collapse">'+
			((createdById !=0 && createdById == createdByIdData) || isAdmin ? '	<a href="#" class="widget-badge-delete-item glyphicon glyphicon-remove" link_id="'+id+'" title="Delete Link" style="float:right;"></a>&nbsp;&nbsp;':'')+		
			((createdById !=0 && createdById == createdByIdData) || isAdmin ? '	<a href="#" class="widget-badge-edit-item glyphicon glyphicon-edit" link_id="'+id+'" title="Edit Link" style="float:right;margin-right:20px;"></a>':'')+			
			((createdById !=0 && createdById == createdByIdData) || isAdmin ? '	<a href="#" class="widget-badge-add-item glyphicon glyphicon-plus" link_id="'+id+'" filter="'+filter+'" title="Add Link" style="float:right;margin-right:20px; "></a>&nbsp;&nbsp;':'')+			
			'<p style="margin: 0px 10px 10px 10px;">'+description+'</p>'+
			'	  <div class="panel-body">'+
			'		<div id="widget_display_'+id+'"></div>'+
			'		<div id="widget_bottom_'+id+'"></div>'+
			'	  </div>'+
			'	</div>'+
			'  </div>';
		}
	}
	$(contentJsSelector).html(itemTempateHeader+itemTempateRow+itemTempateFooter);
};


SiteLinks.SaveReaction = function (reference,referenceId,reaction,oldreaction,createdbyid,widgetid,$loadingObject,SuccessCallback, ErrorCallback){
	if(!reference) reference = "weblinksdata";
	if(!referenceId) referenceId = 0;
	if(!reaction) reaction = "up";
	if(!oldreaction) oldreaction = "-";
	if(!createdbyid) createdbyid = -1;
	if(!widgetid) widgetid = 0;
	var jsonData = {
		reference : reference,
		referenceId : referenceId,
		reaction : reaction,
		oldreaction :  oldreaction,
		createdbyid : createdbyid,
		widgetId : widgetid
	};
	
	SiteCommon.PostToUrl(SiteCommon.base_url+"index.php/links/Save_Reaction", jsonData, //post or get your data here
			function (jsonResultData) { 
				jsonResultData = JSON.parse(jsonResultData);
				
				if(SuccessCallback){
					SuccessCallback(jsonResultData); 
				}
			},
			function (jsonResultData) { 
				jsonResultData = JSON.parse(jsonResultData);
				
				if(ErrorCallback){
					ErrorCallback(jsonResultData); 
				}
			},{Message : "", Div1 : $loadingObject,CallBack : function ($loaderObj){
				if($loaderObj && $loaderObj.length > 0){
					if(reaction == "down"){
						$loaderObj.children(".loading").css("left","15px");
					}
					else if(reaction == "up"){
						$loaderObj.children(".loading").css("left","0px");
					}
					else if(reaction == "vote"){
						$loaderObj.children(".loading").css("left","0px");
					}
				}
			}});	
};

SiteLinks.GetReaction = function (referenceId,createdById,$loadingObject,SuccessCallback,ErrorCallback){
	if(!$loadingObject) $loadingObject = null;
	if(!createdById || !referenceId) {
		return;
	}
	var jsonData = { 
		referenceId : referenceId, 
		createdById : createdById
	};
	
	SiteCommon.GetUrlData(SiteCommon.base_url+"index.php/links/GetUserReaction", jsonData, //post or get your data here
			function (jsonResultData) { 
				jsonResultData = JSON.parse(jsonResultData);
				if(SuccessCallback){
					SuccessCallback(jsonResultData); 
				}
			},
			function (jsonResultData) { 
				jsonResultData = JSON.parse(jsonResultData);
				if(ErrorCallback){
					ErrorCallback(jsonResultData); 
				}
			},$loadingObject);
};
SiteLinks.UpdateReactions = function (referenceId,createdById,$loadingObject){

	SiteLinks.GetReaction(referenceId,createdById,$loadingObject,function (data){
					 //debugger;
					if(data.issuccess){
						SiteLinks.UpdateItem(null,data.reactionData);
					}
				});
};
//Save_Reaction
   