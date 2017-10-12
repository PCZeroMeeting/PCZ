/////////////////////////////////////////////////////Here for Modals and page popups on related UI
// NOTE: DO NOT ERASE!!
// Here are the pattern of the modal functionality, this is used by all modals. But function names may vary.
// It is best to follow this pattern although you can customize but give at least a recognizable pattern
// so that programmers following this code don't have to memorize different patterns!
//https://github.com/kylefox/jquery-modal
//http://www.ericmmartin.com/projects/simplemodal/
//SiteUI.ModalPattern = function () {
//    var me = this;
//    this.YourURL = ResolveAPIPath("/Control/Action"); 
//    this.Validation = new SiteUI.Validation(); // validation object and you may not use this.
//    this.Validation.Properties = // your validation fields, if you want to add your own validation just add an onblur event in Show()
//          { "#SampeField2": { "required": true, "mask": "", "messageElement": "#RequiredFieldValidator1", "group": "" ,"CompoundValidationOnly" : true  } //CompoundValidationOnly if you want your validation happend only in this.Validate() but this can be ommitted
//          };
//    this.YourDataObservables = { // your fields with some observables
//        ViewJsonEvent : function (dataSource) { ViewJSON(dataSource)},
//        SampeField1: 0,
//        SampeField2: ko.observable("")
//    };
//    this.Invalid = function () { };
//    this.ClickEvent = function () { }; //user event
//    this.LogClickEvent = function (data, event) {
//        me.ClickEvent(data, event);
//    };
//    this.AddSuccessful = function () { };
//    this.AddError = function () { };
//    this.Reset = function () {
//    };
//    this.YourAjaxPosting = function (SuccessCallback, ErrorCallback,$loadingObject) { //Post ajax
//        if (this.Validate()) {
//            var jsonData = {
//                SampeField1: this.YourDataObservables.SampeField1,
//                SampeField2: this.YourDataObservables.SampeField2()
//            }
//            var dataJson = ko.toJSON(jsonData); //OR var dataJson = ko.toJSON(this.YourDataObservables); you can directly use YourDataObservables
//            PostToUrl(this.YourURL, dataJson, //post or get your data here
//                    function (jsonResultData) { SuccessCallback(jsonResultData); },
//                    function (jsonResultData) { ErrorCallback(jsonResultData); },$loadingObject);
//            GetUrlData(this.YourURL, dataJson, //post or get your data here
//                    function (jsonResultData) { SuccessCallback(jsonResultData); },
//                    function (jsonResultData) { ErrorCallback(jsonResultData); },$loadingObject);
//        }
//        else {
//            this.Invalid();
//        }
//    };
//    this.Close = function () {
//        SiteUI.closeModal();
//        delete me;
//    };
//    this.Show = function (criteria) {
//        //create modal here
//        var $object = $("#yourDivPopup");
//        me.Validation.InitializeValidation($object);
//        $object.modal(); // or SiteUI.CreateModalFromSource(
//        $object.draggable({ handle: '.modal-drag' });  
//        //observable binding happens here
//        KoApplyBinding(me.YourDataObservables, $object); // note that is uses javascript object not JQUERY object
//        //initialization of event here
//        $("#button").on("click",function (){this.YourAjaxPosting(function(){SiteUI.Alert("Success");},function(){SiteUI.Alert("Failed");});})
//        if (criteria && criteria.Click) {
//            me.ClickEvent = criteria.Click;
//        }
//
//        if (criteria && criteria.AddSuccessful) {
//            me.AddSuccessful = criteria.AddSuccessful;
//        }
//
//        if (criteria && criteria.AddError) {
//            me.AddError = criteria.AddError;
//        }
//    };
//    this.Validate = function () {
//
//        return this.Validation.Validate();
//    };
//};
///////////////////////////////////////////////////////
SiteUI.closeModal = function(){
   $('.modal').modal('hide');
};

SiteUI.AddLinksModal = function () {
    var me = this;
	/*	
    //this.YourURL = ResolveAPIPath("/Control/Action"); 
    this.Validation = new SiteUI.Validation();  //validation object and you may not use this.
    this.Validation.Properties = {// your validation fields, if you want to add your own validation just add an onblur event in Show()
          "#widgetTitle": { "required": true, "mask": "", "messageElement": "#widgetTitleValidation", "group": "" ,"CompoundValidationOnly" : false  } ,
		   "#widgetFilter": { "required": true, "mask": "", "messageElement": "#widgetFilterValidation", "group": "" ,"CompoundValidationOnly" : false  } ,
		   "#widgetGroup": { "required": true, "mask": "", "messageElement": "#widgetGroupValidation", "group": "" ,"CompoundValidationOnly" : false  } 
		   
          };
    this.YourDataObservables = { // your fields with some observables
        ViewJsonEvent : function (dataSource) { ViewJSON(dataSource)},
        SampeField1: 0
    };
    this.Invalid = function () { };
    this.ClickEvent = function () { }; //user event
    this.LogClickEvent = function (data, event) {
        me.ClickEvent(data, event);
    };
    this.AddSuccessful = function () { };
    this.AddError = function () { };
    this.Reset = function () {
    };
	this.AddWidgetURL = SiteCommon.base_url+"index.php/links/create_widget";
	this.EditWidgetURL = SiteCommon.base_url+"index.php/links/edit_widget";
	this.GetWidgetURL = SiteCommon.base_url+"index.php/links/get_widget";
	
	this.GetWidget = function (SuccessCallback, ErrorCallback,$loadingObject){

		if(!$loadingObject) $loadingObject = $("#createWidget");
		var jsonData = {
				id : $("#widgetId").val() 
            };
		SiteCommon.GetUrlData(this.GetWidgetURL, jsonData, //post or get your data here
				function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					SuccessCallback(jsonResultData); 
				},
				function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					ErrorCallback(jsonResultData); 
				},$loadingObject);			
	};
    this.PostAddWidget = function (SuccessCallback, ErrorCallback,$loadingObject) { //Post ajax
		if(!$loadingObject) $loadingObject = $("#createWidget");
        if (this.Validate()) {
            var jsonData = {
				title : $("#widgetTitle").val(),
				filter : $("#widgetFilter").val(),
				group :  $("#widgetGroup").val(),
				description : $("#widgetDescription").val(),
				votingtype :$('input[name=ddVoteType]').val(),
				votingordering : $('input[name=ddVotingOrdering]').val(),
				votingexpirydate : SiteCommon.DateTimeToDB($("#votingExpiryDate").val()),
				isActive : $("#widgetIsActive").val()
            };
 
            var dataJson = JSON.stringify(jsonData); //OR var dataJson = ko.toJSON(this.YourDataObservables); you can directly use YourDataObservables
			//debugger;
			SiteCommon.PostToUrl(this.AddWidgetURL, jsonData, //post or get your data here
                    function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					SuccessCallback(jsonResultData); 
					},
                    function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					ErrorCallback(jsonResultData); 
					},$loadingObject);
 
        }
        else {
            this.Invalid();
        }
    };
	
    this.PostEditWidget = function (SuccessCallback, ErrorCallback,$loadingObject) { //Post ajax
		if(!$loadingObject) $loadingObject = $("#createWidget");
        if (this.Validate()) {
			//debugger;
            var jsonData = {
				id : $("#widgetId").val(),
				title : $("#widgetTitle").val(),
				filter : $("#widgetFilter").val(),
				group :  $("#widgetGroup").val(),
				description : $("#widgetDescription").val(),
				votingtype : $('input[name=ddVoteType]:checked').val(),
				votingordering : $('input[name=ddVotingOrdering]:checked').val(),
				votingexpirydate : SiteCommon.DateTimeToDB($("#votingExpiryDate").val()),
				isActive : $("#widgetIsActive").val()
            };
 
            //var dataJson = JSON.stringify(jsonData); //OR var dataJson = ko.toJSON(this.YourDataObservables); you can directly use YourDataObservables
			
			SiteCommon.PostToUrl(this.EditWidgetURL, jsonData, //post or get your data here
                    function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					SuccessCallback(jsonResultData); 
					},
                    function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					ErrorCallback(jsonResultData); 
					},$loadingObject);
 
        }
        else {
            this.Invalid();
        }
    };	
    this.Close = function () {
        SiteUI.closeModal();
        delete me;
    };
	*/
	this.EditMode = false;
	this.ShowCreateModal = function($parent) {
		me.Show(0,$parent,false,$parent.attr('widgetid'),$parent.attr('filter'));
	};
	this.ShowEditModal = function($parent) {
		me.Show($parent.attr('link_id'),$parent,true,$parent.attr('widgetid'),$parent.attr('filter'));
	};
	this.DeleteModal = function ($parent){
		$("#deleteIframe").attr("src",SiteCommon.base_url+'index.php/links/deleterow?id='+$parent.attr('link_id')+'&widgetid='+$parent.attr('widgetid'));
		$('#deleteModal').modal('show');
	};
    this.Show = function (linkid,$parent,editmode,widgetid,filter) {
		
		me.EditMode = editmode;
		debugger;
		var id = linkid;
		if(!id) id = 0;	
		if(me.EditMode){
			$("#newWindowLink_edit").attr("href",SiteCommon.base_url+'index.php/links/edit?id='+ id+'&widgetid='+widgetid+'&fullscreenmode=1');
			$("#editIframe").attr("src",SiteCommon.base_url+'index.php/links/edit?id='+ id+'&widgetid='+widgetid);
			$('#editModal').modal('show');
		}
		else { 
			$("#newWindowLink_create").attr("href",SiteCommon.base_url+'index.php/links/create?filter='+filter+'&widgetid='+widgetid+'&fullscreenmode=1');
			$("#frmAddLink").attr("src",SiteCommon.base_url+'index.php/links/create?filter='+filter+'&widgetid='+widgetid);
			$('#createModal').modal('show');
		}
		/*
        var modalSelector = "createWidget";
		var $object = $("#"+modalSelector);
		var originalModal = $object.clone();
		originalModal.attr("id",modalSelector+"_temp");
		
		$object.on('hidden.bs.modal', function () {
			
			$object.after(originalModal);
			originalModal.attr("id",modalSelector);
			$object.remove();
			$object = originalModal;
			SiteUI.HideLoading($object);
			$object.css("position","fixed");
			//var myClone = originalModal.clone();
			//$('body').append(myClone);
		});

		$("#votingExpiryDate").datetimepicker();
        //create modal here
		me.EditMode = false;
		$(".widget-label").hide();
		$(".radio-label").show();
		
		if(id)
		{
			if(!isNaN(parseInt(id)) && id !== 0)
			{
				$("#widgetId").val(id);
				$(".widget-label").show();
				$("#widgetTitleDisplay").text("Edit Widget");
				$("#btnCreateWidget").text("Edit Widget");
				
				me.EditMode = true;
				me.GetWidget(function (jsonResultData){
					 
					if(jsonResultData.issuccess){
 
					//success
						//debugger;
						$("#widgetId").val(jsonResultData.data.id);
						$("#widgetTitle").val(jsonResultData.data.title);
						$("#widgetFilter").val(jsonResultData.data.filter_query);
						$("#widgetGroup").val(jsonResultData.data.group_name);
						$("#widgetDescription").val(jsonResultData.data.description);
						if(!jsonResultData.data.votingtype) jsonResultData.data.votingtype = Enums.VotingType.MultiVote;						
						$('input[name=ddVoteType]').val([jsonResultData.data.votingtype]);
						
						if(!jsonResultData.data.votingordering) jsonResultData.data.votingordering = Enums.VotingOrdering.WinnerFirst;
						$('input[name=ddVotingOrdering]').val([jsonResultData.data.votingordering]);
						
						$("#votingExpiryDate").val(SiteCommon.DateTimeToUI(jsonResultData.data.votingexpirydate));
						
						$("#widgetIsActive").val(jsonResultData.data.isActive);
					}
					else {
						SiteUI.Alert(jsonResultData.message);
					}				
				},function (jsonResultData){
					//error
					SiteUI.Alert(jsonResultData.message);
				});
				
			}
		}
		

        me.Validation.InitializeValidation($object); 
		$object.modal('show');
		$object.css("position","fixed");
        //initialization of event here
		$("#ddGroupName").on("change",function (event){
			var value = $(this).val();
			$("#widgetGroup").val(value);
		});
		
        $("#btnCreateWidget").on("click",function (event){
			event.preventDefault();
		 
			//this.YourAjaxPosting(function(){SiteUI.Alert("Success");},function(){SiteUI.Alert("Failed");});
			if(me.Validate()){
				if(me.EditMode === true){
					me.PostEditWidget(function (jsonResultData){
						//success
						if(jsonResultData.issuccess){
							me.Close();
 
							var url = window.location.href;    
 
							window.location.href = SiteCommon.UpdateUrlParameter(url,'widgetid',jsonResultData.widgetid);
						}
						else { SiteUI.Alert(jsonResultData.message);}
						
					},function (jsonResultData){
						SiteUI.Alert(jsonResultData.message);
					},$object.find(".modal-content"));					
				}
				else{
				 
					me.PostAddWidget(function (jsonResultData){
						if(jsonResultData.issuccess){
							me.Close();
 
							var url = window.location.href;    
 
							window.location.href = SiteCommon.UpdateUrlParameter(url,'widgetid',jsonResultData.widgetid);
						}
						else { SiteUI.Alert(jsonResultData.message);}
					},function (jsonResultData){
						SiteUI.Alert(jsonResultData.message);
					},$object.find(".modal-content"));
				}
			}
		});
		*/
    };
    this.Validate = function () {

        return this.Validation.Validate();
    };
};

///////////////////////////////////widget///////////////////////////////////////////
SiteUI.AddWidgetModal = function () {
    var me = this;
		
    //this.YourURL = ResolveAPIPath("/Control/Action"); 
    this.Validation = new SiteUI.Validation();  //validation object and you may not use this.
    this.Validation.Properties = {// your validation fields, if you want to add your own validation just add an onblur event in Show()
          "#widgetTitle": { "required": true, "mask": "", "messageElement": "#widgetTitleValidation", "group": "" ,"CompoundValidationOnly" : false  } ,
		   "#widgetFilter": { "required": true, "mask": "", "messageElement": "#widgetFilterValidation", "group": "" ,"CompoundValidationOnly" : false  } ,
		   "#widgetGroup": { "required": true, "mask": "", "messageElement": "#widgetGroupValidation", "group": "" ,"CompoundValidationOnly" : false  } 
		   
          };
    this.YourDataObservables = { // your fields with some observables
        ViewJsonEvent : function (dataSource) { ViewJSON(dataSource)},
        SampeField1: 0
    };
    this.Invalid = function () { };
    this.ClickEvent = function () { }; //user event
    this.LogClickEvent = function (data, event) {
        me.ClickEvent(data, event);
    };
    this.AddSuccessful = function () { };
    this.AddError = function () { };
    this.Reset = function () {
    };
	this.AddWidgetURL = SiteCommon.base_url+"index.php/links/create_widget";
	this.EditWidgetURL = SiteCommon.base_url+"index.php/links/edit_widget";
	this.GetWidgetURL = SiteCommon.base_url+"index.php/links/get_widget";
	
	this.GetWidget = function (SuccessCallback, ErrorCallback,$loadingObject){

		if(!$loadingObject) $loadingObject = $("#createWidget");
		var jsonData = {
				id : $("#widgetId").val() 
            };
		SiteCommon.GetUrlData(this.GetWidgetURL, jsonData, //post or get your data here
				function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					SuccessCallback(jsonResultData); 
				},
				function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					ErrorCallback(jsonResultData); 
				},$loadingObject);			
	};
    this.PostAddWidget = function (SuccessCallback, ErrorCallback,$loadingObject) { //Post ajax
		if(!$loadingObject) $loadingObject = $("#createWidget");
        if (this.Validate()) {
            var jsonData = {
				title : $("#widgetTitle").val(),
				filter : $("#widgetFilter").val(),
				group :  $("#widgetGroup").val(),
				description : $("#widgetDescription").val(),
				votingtype :$('input[name=ddVoteType]').val(),
				votingordering : $('input[name=ddVotingOrdering]').val(),
				votingexpirydate : SiteCommon.DateTimeToDB($("#votingExpiryDate").val()),
				isActive : $("#widgetIsActive").val()
            };
 
            var dataJson = JSON.stringify(jsonData); //OR var dataJson = ko.toJSON(this.YourDataObservables); you can directly use YourDataObservables
			//debugger;
			SiteCommon.PostToUrl(this.AddWidgetURL, jsonData, //post or get your data here
                    function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					SuccessCallback(jsonResultData); 
					},
                    function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					ErrorCallback(jsonResultData); 
					},$loadingObject);
			/*
            SiteCommon.GetUrlData(this.YourURL, dataJson, //post or get your data here
                    function (jsonResultData) { SuccessCallback(jsonResultData); },
                    function (jsonResultData) { ErrorCallback(jsonResultData); },$loadingObject);
					*/
        }
        else {
            this.Invalid();
        }
    };
	
    this.PostEditWidget = function (SuccessCallback, ErrorCallback,$loadingObject) { //Post ajax
		if(!$loadingObject) $loadingObject = $("#createWidget");
        if (this.Validate()) {
			//debugger;
            var jsonData = {
				id : $("#widgetId").val(),
				title : $("#widgetTitle").val(),
				filter : $("#widgetFilter").val(),
				group :  $("#widgetGroup").val(),
				description : $("#widgetDescription").val(),
				votingtype : $('input[name=ddVoteType]:checked').val(),
				votingordering : $('input[name=ddVotingOrdering]:checked').val(),
				votingexpirydate : SiteCommon.DateTimeToDB($("#votingExpiryDate").val()),
				isActive : $("#widgetIsActive").val()
            };
 
            //var dataJson = JSON.stringify(jsonData); //OR var dataJson = ko.toJSON(this.YourDataObservables); you can directly use YourDataObservables
			
			SiteCommon.PostToUrl(this.EditWidgetURL, jsonData, //post or get your data here
                    function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					SuccessCallback(jsonResultData); 
					},
                    function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					ErrorCallback(jsonResultData); 
					},$loadingObject);
			/*
            SiteCommon.GetUrlData(this.YourURL, dataJson, //post or get your data here
                    function (jsonResultData) { SuccessCallback(jsonResultData); },
                    function (jsonResultData) { ErrorCallback(jsonResultData); },$loadingObject);
					*/
        }
        else {
            this.Invalid();
        }
    };	
    this.Close = function () {
        SiteUI.closeModal();
        delete me;
    };
	this.EditMode = false;
    this.Show = function (id) {
		if(!id) id = 0;
        var modalSelector = "createWidget";
		var $object = $("#"+modalSelector);
		var originalModal = $object.clone();
		originalModal.attr("id",modalSelector+"_temp");
		
		$object.on('hidden.bs.modal', function () {
			
			$object.after(originalModal);
			originalModal.attr("id",modalSelector);
			$object.remove();
			$object = originalModal;
			SiteUI.HideLoading($object);
			$object.css("position","fixed");
			//var myClone = originalModal.clone();
			//$('body').append(myClone);
		});
		
		$("#votingExpiryDate").datetimepicker();
        //create modal here
		me.EditMode = false;
		$(".widget-label").hide();
		$(".radio-label").show();
		
		if(id)
		{
			if(!isNaN(parseInt(id)) && id !== 0)
			{
				$("#widgetId").val(id);
				$(".widget-label").show();
				$("#widgetTitleDisplay").text("Edit Widget");
				$("#btnCreateWidget").text("Edit Widget");
				
				me.EditMode = true;
				me.GetWidget(function (jsonResultData){
					 
					if(jsonResultData.issuccess){
				/*"{
						"issuccess":true,
						"message":"success",
						"data":{"id":"7",
						"title":"Test",
						"filter_query":"test",
						"description":"Test",
						"group_name":"test",
						"createdById":"1",
						"createdDate":"2017-05-20 19:55:41",
						"isActive":"1"}
						}"
					*/
					//success
						//debugger;
						$("#widgetId").val(jsonResultData.data.id);
						$("#widgetTitle").val(jsonResultData.data.title);
						$("#widgetFilter").val(jsonResultData.data.filter_query);
						$("#widgetGroup").val(jsonResultData.data.group_name);
						$("#widgetDescription").val(jsonResultData.data.description);
						if(!jsonResultData.data.votingtype) jsonResultData.data.votingtype = Enums.VotingType.MultiVote;						
						$('input[name=ddVoteType]').val([jsonResultData.data.votingtype]);
						
						if(!jsonResultData.data.votingordering) jsonResultData.data.votingordering = Enums.VotingOrdering.WinnerFirst;
						$('input[name=ddVotingOrdering]').val([jsonResultData.data.votingordering]);
						
						$("#votingExpiryDate").val(SiteCommon.DateTimeToUI(jsonResultData.data.votingexpirydate));
						
						$("#widgetIsActive").val(jsonResultData.data.isActive);
					}
					else {
						SiteUI.Alert(jsonResultData.message);
					}				
				},function (jsonResultData){
					//error
					SiteUI.Alert(jsonResultData.message);
				});
				
			}
		}
		

        me.Validation.InitializeValidation($object); 
		$object.modal('show');
		$object.css("position","fixed");
        //initialization of event here
		$("#ddGroupName").on("change",function (event){
			var value = $(this).val();
			$("#widgetGroup").val(value);
		});
		
        $("#btnCreateWidget").on("click",function (event){
			event.preventDefault();
		 
			//this.YourAjaxPosting(function(){SiteUI.Alert("Success");},function(){SiteUI.Alert("Failed");});
			if(me.Validate()){
				if(me.EditMode === true){
					me.PostEditWidget(function (jsonResultData){
						//success
						if(jsonResultData.issuccess){
							me.Close();
							
							//SiteLinks.ShowWidgets(20,"","#widget_bottom","#widget_content","",SiteUI.CreatedById,SiteUI.IsAdmin,function(){
								/*
								$(".widget-badge-edit-item").on("click",function (event){
									event.preventDefault();  
									WidgetModal.Show($(this).attr('link_id')); 
								});
 
								$(".widget-badge-delete-item").on("click",function (event){
									event.preventDefault();  
					 
									WidgetDeleteModal.Show($(this).attr('link_id'),$("#accordion_toggle_"+$(this).attr('link_id')).text()); 
								}); */
							//	location.reload();
							//});
							//location.reload(); 
							var url = window.location.href;    
 
							window.location.href = SiteCommon.UpdateUrlParameter(url,'widgetid',jsonResultData.widgetid);
						}
						else { SiteUI.Alert(jsonResultData.message);}
						
					},function (jsonResultData){
						SiteUI.Alert(jsonResultData.message);
					},$object.find(".modal-content"));					
				}
				else{
				 
					me.PostAddWidget(function (jsonResultData){
						if(jsonResultData.issuccess){
							me.Close();
							//SiteLinks.ShowWidgets(20,"","#widget_bottom","#widget_content","",SiteUI.CreatedById,SiteUI.IsAdmin,function(){
								/*
								$(".widget-badge-edit-item").on("click",function (event){
									event.preventDefault();  
									WidgetModal.Show($(this).attr('link_id')); 
								});

								$(".widget-badge-delete-item").on("click",function (event){
									event.preventDefault();  
									
								}); */
								//location.reload();
							//});
							var url = window.location.href;    
 
							window.location.href = SiteCommon.UpdateUrlParameter(url,'widgetid',jsonResultData.widgetid);
						}
						else { SiteUI.Alert(jsonResultData.message);}
					},function (jsonResultData){
						SiteUI.Alert(jsonResultData.message);
					},$object.find(".modal-content"));
				}
			}
		});
	 
    };
    this.Validate = function () {

        return this.Validation.Validate();
    };
};


SiteUI.DeleteWidgetModal = function () {
    var me = this;
 
    this.Invalid = function () { };
    this.ClickEvent = function () { }; //user event
    this.LogClickEvent = function (data, event) {
        me.ClickEvent(data, event);
    };
    this.AddSuccessful = function () { };
    this.AddError = function () { };
    this.Reset = function () {
    };
	this.DeleteWidgetURL = SiteCommon.base_url+"index.php/links/deleterow_widget"; 
    this.PostDeleteWidget = function (SuccessCallback, ErrorCallback,$loadingObject) { //Post ajax
		if(!$loadingObject) $loadingObject = $("#createWidget");
     
            var jsonData = {
				id : $("#widgetDeleteId").val()
            };
			//debugger;
            var dataJson = JSON.stringify(jsonData); //OR var dataJson = ko.toJSON(this.YourDataObservables); you can directly use YourDataObservables
			
			SiteCommon.PostToUrl(this.DeleteWidgetURL, jsonData, //post or get your data here
                    function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					SuccessCallback(jsonResultData); 
					},
                    function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					ErrorCallback(jsonResultData); 
					},$loadingObject);
 
 
    };
	
    this.Close = function () {
        SiteUI.closeModal();
        delete me;
    };
	this.EditMode = false;
    this.Show = function (id,widgetName) {
		if(!id) id = 0;
		
		$("#widgetDeleteId").val(id);
		$(".widget-name").text(widgetName);
		
        var modalSelector = "deleteWidget";
		var $object = $("#"+modalSelector);
		var originalModal = $object.clone();
		originalModal.attr("id",modalSelector+"_temp");
		
		$object.on('hidden.bs.modal', function () {
			
			$object.after(originalModal);
			originalModal.attr("id",modalSelector);
			$object.remove();
			$object = originalModal;
			SiteUI.HideLoading($object);
			$object.css("position","fixed");
			//var myClone = originalModal.clone();
			//$('body').append(myClone);
		});
			
        //create modal here
		me.EditMode = false;
		$(".widget-label").hide();
		if(id)
		{
			 
		}
		
 
		$object.modal('show');
		$object.css("position","fixed");
        //initialization of event here 
		
        $("#btnDeleteWidget").on("click",function (event){
			event.preventDefault();
		 
 
					me.PostDeleteWidget(function (jsonResultData){
						if(jsonResultData.issuccess){
							me.Close();
							SiteLinks.ShowWidgets(20,"","#widget_bottom","#widget_content","",SiteUI.CreatedById,SiteUI.IsAdmin,function(){
								/*
								$(".widget-badge-edit-item").on("click",function (event){
									event.preventDefault();  
									WidgetModal.Show($(this).attr('link_id')); 
								});

								$(".widget-badge-delete-item").on("click",function (event){
									event.preventDefault();  
									
								}); */
								location.reload();
							});							
						}
						else { SiteUI.Alert(jsonResultData.message);}
					},function (jsonResultData){
						SiteUI.Alert(jsonResultData.message);
					},$object.find(".modal-content"));
		});
	 
    }; 
};

SiteUI.DescriptionModal = function () {
    var me = this; 
	this.GetWeblinkURL = SiteCommon.base_url+"index.php/links/get_weblink"; 
    this.Invalid = function () { };
    this.ClickEvent = function () { }; //user event
    this.LogClickEvent = function (data, event) {
        me.ClickEvent(data, event);
    };
    this.AddSuccessful = function () { };
    this.AddError = function () { };
    this.Reset = function () {
    };
	 
    this.Close = function () {
        SiteUI.closeModal();
        delete me;
    };
	this.GetItem = function (weblinkId,SuccessCallback, ErrorCallback,$loadingObject){

		if(!$loadingObject) $loadingObject = $("#descriptionItem");
		var jsonData = {
				id : weblinkId
            };
		SiteCommon.GetUrlData(this.GetWeblinkURL, jsonData, //post or get your data here
				function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					SuccessCallback(jsonResultData); 
				},
				function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					ErrorCallback(jsonResultData); 
				},$loadingObject);			
	};	
	this.EditMode = false;
    this.Show = function (id) {
        var modalSelector = "descriptionItem";
		var $object = $("#"+modalSelector);
		
		
		if(!id) id = 0; 
		$object.find("#itemId").val(id);
		$object.find("#itemTitleDisplay").text("Description");
		me.GetItem(id,function (data){
		
			var item = data.data;
			$object.find("#itemTitleDisplay").text(item.title+" Description");
			$object.find("#descriptionData").text(item.description);
			
		},function (){},$object.find("#descItem"));

		var originalModal = $object.clone();
		originalModal.attr("id",modalSelector+"_temp");
		
		$object.on('hidden.bs.modal', function () {
			
			$object.after(originalModal);
			originalModal.attr("id",modalSelector);
			$object.remove();
			$object = originalModal;
			SiteUI.HideLoading($object);
			$object.css("position","fixed");
			//var myClone = originalModal.clone();
			//$('body').append(myClone);
		});
			
        //create modal here
		me.EditMode = false;
		$(".item-label").hide();
		if(id)
		{
			 
		}
		
 
		$object.modal({show : true,backdrop: true});
		$object.css("position","fixed");
        //initialization of event here 
		
        $("#btnDeleteWidget").on("click",function (event){
			event.preventDefault();
			me.Close();
		});
	 
    }; 
};

SiteUI.DropdownMenuItem = function () {
    var me = this; 
	this.GetWeblinkURL = SiteCommon.base_url+"index.php/links/get_weblink"; 
    this.Invalid = function () { };
    this.ClickEvent = function () { }; //user event
    this.LogClickEvent = function (data, event) {
        me.ClickEvent(data, event);
    };
    this.AddSuccessful = function () { };
    this.AddError = function () { };
    this.Reset = function () {
    };
	 
    this.Close = function () {
        SiteUI.closeModal();
        delete me;
    };
	this.GetItem = function (weblinkId,SuccessCallback, ErrorCallback,$loadingObject){

		if(!$loadingObject) $loadingObject = $("#DropdownMenuItem");
		var jsonData = {
				id : weblinkId
            };
		SiteCommon.GetUrlData(this.GetWeblinkURL, jsonData, //post or get your data here
				function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					SuccessCallback(jsonResultData); 
				},
				function (jsonResultData) { 
					jsonResultData = JSON.parse(jsonResultData);
					ErrorCallback(jsonResultData); 
				},$loadingObject);			
	};	
	this.EditMode = false;
    this.Show = function (id,userid,username,okEditDelete,hideBadges,parentDiv) {
 
        var modalSelector = "dropdownMenuItem";
		var $object = $("#"+modalSelector);
		

		
		if(!id) id = 0; 
		$object.find("#itemId").val(id);
		//$object.find("#itemTitleDisplay").text("Description");
		
		
		var menuString = '<ul class="" style="display:block;position:relative;">'+
			(!hideBadges && okEditDelete ?
				(
				'    <li ><a href="#" class="action-edit-item glyphicon glyphicon-edit" link_id="'+id+'">&nbsp;Edit</a></li>'+
				'    <li><a href="#" class="action-delete-item glyphicon glyphicon-remove" link_id="'+id+'">&nbsp;Delete</a></li>'
				) 
				: ''
			) +
			'    <li role="separator" class="divider"></li>'+			
			'    <li><a href="'+SiteCommon.base_url+'index.php/auth/user_profile?id='+(userid == null? '#' : userid)+'" class="glyphicon glyphicon-user" target="_blank">&nbsp;'+(username == null ? 'anonymous' : username)+'</a></li>'+
			'    <li><a href="#" class="glyphicon glyphicon-comment" onclick="DescriptionModal.Show('+id+');">&nbsp;Description</a></li>'+
			'  </ul>';
		

		/*
		me.GetItem(id,function (data){
		
			var item = data.data;
			$object.find("#itemTitleDisplay").text(item.title+" Description");
			$object.find("#descriptionData").text(item.description);
			
		},function (){},$object.find("#descItem"));
		*/
		var $dialog = $object.find(".modal-dialog");
		$dialog.find(".modal-dialog").css("height","100px");	 
		$dialog.css("width","300px");	
		var originalModal = $object.clone();
		originalModal.attr("id",modalSelector+"_temp");
		
		$object.on('hidden.bs.modal', function () {
			
			$object.after(originalModal);
			originalModal.attr("id",modalSelector);
			$object.remove();
			$object = originalModal;
			SiteUI.HideLoading($object);
			$object.css("position","fixed");
			//var myClone = originalModal.clone();
			//$('body').append(myClone);
		});
			
        //create modal here
		me.EditMode = false;
		$(".item-label").hide();
		if(id)
		{
			 
		}
		
 
		$object.modal({show : true,backdrop: false});
		$object.find("#menuData").html(menuString);
		//$object.css("position","fixed");
		
		$object.css("top",$(parentDiv).offset().top+"px");
		$object.css("left",$(parentDiv).offset().left+"px");
 
        //initialization of event here 
		
        $("#btnDeleteWidget").on("click",function (event){
			event.preventDefault();
			me.Close();
		});
	 
    }; 
};
