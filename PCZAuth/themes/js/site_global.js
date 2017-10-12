//$.fn.showOld = $.fn.show;
//$.fn.hideOld = $.fn.hide;

//$.fn.show = function() {
//	$.fn.showOld().removeClass("hide").css("display","block");
//};

//$.fn.hide = function() {
//	$.fn.hideOld().removeClass("show").css("display","none");
//};
String.prototype.endsWith = function(suffix) {
    return this.indexOf(suffix, this.length - suffix.length) !== -1;
};

String.prototype.startsWith = function (str) {
    return this.indexOf(str) == 0;
};

String.prototype.reverse = function () {
    return this.split("").reverse().join("");
}; 

function ucwords (str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}

jQuery.fn.extend({
	Show: function() { 
		$(this).show();
		$(this).removeClass("hide");
	},
	Hide: function() { 
		$(this).hide();
		$(this).removeClass("show");
	}
});
 

$.fn.is_on_screen = function () {

    var win = $(window);

    var viewport = {
        top: win.scrollTop(),
        left: win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();

    var bounds = this.offset();
    if (bounds == null) {
        return false;
    }

    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();

    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

};

/*
new Date('Sun May 11,2014').format('yyyy-MM-dd');
"2014-05-11
*/
Date.prototype.format = function (format){
    var o = {
        "M+": this.getMonth() + 1, //month
        "d+": this.getDate(),    //day
        "h+": this.getHours(),   //hour
        "m+": this.getMinutes(), //minute
        "s+": this.getSeconds(), //second
        "q+": Math.floor((this.getMonth() + 3) / 3),  //quarter
        "S": this.getMilliseconds() //millisecond
    }

    if (/(y+)/.test(format)) format = format.replace(RegExp.$1,
    (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o){
		if (new RegExp("(" + k + ")").test(format)){
			format = format.replace(RegExp.$1,RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
		}
	}
    return format;
};

/*
new Date('Sun May 11,2014').format('yyyy-MM-dd');
"2014-05-11
*/
Date.prototype.Dateformat = function (y) {
	var x = this;
	
    var z = {
        M: x.getMonth() + 1,
        d: x.getDate(),
        h: x.getHours(),
        m: x.getMinutes(),
        s: x.getSeconds()
    };
    y = y.replace(/(M+|d+|h+|m+|s+)/g, function(v) {
        return ((v.length > 1 ? "0" : "") + eval('z.' + v.slice(-1))).slice(-2)
    });

    return y.replace(/(y+)/g, function(v) {
        return x.getFullYear().toString().slice(-v.length)
    });
}

/*
"22/03/2016 14:03:01".toDate("dd/mm/yyyy hh:ii:ss");
"2016-03-29 18:30:00".toDate("yyyy-mm-dd hh:ii:ss");
*/
String.prototype.toDate = function(format)
{
  var normalized      = this.replace(/[^a-zA-Z0-9]/g, '-');
  var normalizedFormat= format.toLowerCase().replace(/[^a-zA-Z0-9]/g, '-');
  var formatItems     = normalizedFormat.split('-');
  var dateItems       = normalized.split('-');

  var monthIndex  = formatItems.indexOf("mm");
  var dayIndex    = formatItems.indexOf("dd");
  var yearIndex   = formatItems.indexOf("yyyy");
  var hourIndex     = formatItems.indexOf("hh");
  var minutesIndex  = formatItems.indexOf("ii");
  var secondsIndex  = formatItems.indexOf("ss");
  
  var today = new Date();
  var len = dateItems.length;
  
  var year  = yearIndex < len && yearIndex !== undefined && yearIndex>-1  ? dateItems[yearIndex]    : today.getFullYear();
  var month = monthIndex < len && monthIndex !== undefined && monthIndex>-1 ? dateItems[monthIndex]-1 : today.getMonth()-1;
  var day   = dayIndex < len && dayIndex !== undefined && dayIndex>-1   ? dateItems[dayIndex]     : today.getDate();

  var hour    = hourIndex < len && hourIndex !== undefined && hourIndex>-1      ? dateItems[hourIndex]    : "00";
  var minute  = minutesIndex < len && minutesIndex !== undefined && minutesIndex>-1   ? dateItems[minutesIndex] : "00";
  var second  = secondsIndex < len && secondsIndex !== undefined && secondsIndex>-1   ? dateItems[secondsIndex] : "00";

  return new Date(year,month,day,hour,minute,second);
};

Enums = {};
Enums.Reaction = {
	"Up" : "up",
	"Down" : "down"
};
Enums.VotingType = {
	"OneVote" : "onevote",
	"MultiVote" : "multivote"
};
Enums.VotingOrdering = {
	"LoserFirst" : "loserfirst",
	"WinnerFirst" : "winnerfirst",
	"Newest": "newest",
	"Oldest" : "oldest",
	"Priority" : "priority"
};

function Site(properties){
	$(".latest-uploaded .latest-auction img").hover(function(e){
			
			if($(this).attr("src") != "")
			{
				$(".latest-uploaded #large").show();
				$(".latest-uploaded #large").css("top",(e.clientY-1)+"px")
                    .css("left",(e.clientX-400)+"px")                  
                    .html("<img src="+ $(this).attr("src") +" alt='Large Image' style='width:120px;height:120px;z-index:2000;'/>")
                    .fadeIn("slow");
			}
        }, function(){
            $(".latest-uploaded #large").fadeOut("fast");
        });  
				
}

SiteCommon = {};
SiteCommon.base_url = "";
SiteCommon.AppId = '1674582052769506';
SiteCommon.GetParameterByName = function (name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
};
SiteCommon.UpdateUrlParameter = function (uri, key, value) {
    // remove the hash part before operating on the uri
    var i = uri.indexOf('#');
    var hash = i === -1 ? ''  : uri.substr(i);
         uri = i === -1 ? uri : uri.substr(0, i);

    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        uri = uri.replace(re, '$1' + key + "=" + value + '$2');
    } else {
        uri = uri + separator + key + "=" + value;
    }
    return uri + hash;  // finally append the hash as well
}


SiteCommon.DateTimeToUI = function (datetimeString){
	if(datetimeString != null && datetimeString.includes("0000-00-00")){
		datetimeString = null;
	}
	if(datetimeString == "") datetimeString = null;
	
	if(datetimeString != null){
		var datetime1 = datetimeString.toDate("yyyy-mm-dd hh:ii:ss").format("MM/dd/yyyy hh:mm");
		return datetime1;
	}
	return "";
};
SiteCommon.DateTimeToDB = function (datetimeString){
	if(datetimeString != null && datetimeString.includes("0000-00-00")){
		datetimeString = null;
	}
	if(datetimeString == "") datetimeString = null;
	
	if(datetimeString != null){
		var datetime1 = datetimeString.toDate("mm/dd/yyyy hh:ii:ss");
		var datestring = datetime1.format("yyyy-MM-dd hh:mm");
		return datestring;
	}
	return "";
};
SiteCommon.IsTestSite = function (){
	if(window.location.href.indexOf("mywebbid")){
		return true;
	}
	return false;
};
SiteCommon.ConvertDateFormat = function (fromDateFormat,toDateFormat,dateInString){
	
};
SiteCommon.Protocol = function () {
    if ("https:" == document.location.protocol) {
        /* secure */
        return "https:"
    } else {
        /* unsecure */
        return "http:"
    }
};
 
SiteCommon.LoadUrl = function ($divOwner, url, completedCallBack, $loadingDiv) {
    if ($loadingDiv) {
        SiteUI.ShowLoading($loadingDiv);
    }

    $divOwner.load(url, function (response, status, xhr) {
        if ($loadingDiv) {
            SiteUI.HideLoading($loadingDiv);
        }
        completedCallBack();
    });
}

SiteCommon.LoadUrlWithCache = function ($divOwner, url, completedCallBack, $loadingDiv,htmlCache) {
    if (!$.trim($divOwner.html()).length && htmlCache == null) {
        if ($loadingDiv) {
            SiteUI.ShowLoading($loadingDiv);
        }

        $divOwner.load(url, function () {
            if ($loadingDiv) {
                SiteUI.HideLoading($loadingDiv);
            }
            
            completedCallBack();
        });
    }
    else {
        $divOwner.html("");
        $divOwner.html(htmlCache);
        
        completedCallBack();
    }
}

// you can use loadingCriteria {Div1: $("#div"),Div2: $("#div")} OR $("#div")
SiteCommon.PostToUrl = function (url, data, successCallBack, errorCallBack, loadingCriteria, completeCallback, doNotHideOnSuccess) {
    var NOLOADINGINDICATOR = 0;
    var USE_DIVLOADING = 1;
    var USE_UPDATINGBOX = 2;

    var hideLoading = true;
    var loadingIndicatorType = NOLOADINGINDICATOR;
    var $loadingDiv = null;
    var $loadingDiv2 = null;
 
    if (doNotHideOnSuccess != undefined && doNotHideOnSuccess === true) {
        hideLoading = false;
    }

    var message = "";
    if (loadingCriteria instanceof jQuery) {
        loadingIndicatorType = USE_DIVLOADING;
        $loadingDiv = loadingCriteria;
    }
    else {
        if (!loadingCriteria) {
            loadingIndicatorType = NOLOADINGINDICATOR;
        }
        else {
            loadingIndicatorType = USE_DIVLOADING;			
            if (loadingCriteria && (loadingCriteria.Message || loadingCriteria.Message==="")) {
                loadingIndicatorType = USE_UPDATINGBOX;
                message = loadingCriteria.Message;
            }
            if (loadingCriteria && (loadingCriteria.Div1 || loadingCriteria.Div2)) {
                $loadingDiv = loadingCriteria.Div1;
                $loadingDiv2 = loadingCriteria.Div2;
            }
            else {
            }
        }
    }

    if (loadingIndicatorType == USE_UPDATINGBOX) {
		SiteUI.ShowLoadingBox(message,$loadingDiv, $loadingDiv2);
		if(loadingCriteria.hasOwnProperty("CallBack")){
			loadingCriteria.CallBack($loadingDiv,$loadingDiv2);
		}		
    }
    else if (loadingIndicatorType == USE_DIVLOADING) {
        SiteUI.ShowLoading($loadingDiv, $loadingDiv2);
		if(loadingCriteria.hasOwnProperty("CallBack")){
			loadingCriteria.CallBack($loadingDiv,$loadingDiv2);
		}
    }

    $.ajax({
        type: "POST",
        url: url,
        data: data,
		//contentType : 'application/json',
		//dataType: 'json',
    })
    .done(function (data, textStatus, jqXHR) {
        if (hideLoading) {
            if (loadingIndicatorType == USE_UPDATINGBOX) {
                SiteUI.HideLoadingBox();
            }
            else if (loadingIndicatorType == USE_DIVLOADING) {
                SiteUI.HideLoading($loadingDiv, $loadingDiv2);
            }
        }
        successCallBack(data, textStatus, jqXHR);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {

        if (loadingIndicatorType == USE_UPDATINGBOX) {
            SiteUI.HideLoadingBox();
        }
        else if (loadingIndicatorType == USE_DIVLOADING) {
            SiteUI.HideLoading($loadingDiv, $loadingDiv2);
        }
        
        errorCallBack(jqXHR, textStatus, errorThrown);
    })
    .always(function (data_jqXHR, textStatus, jqXHR_errorThrown) {
        if (hideLoading)
        {
            if (loadingIndicatorType == USE_UPDATINGBOX) {
                SiteUI.HideLoadingBox();
            }
            else if (loadingIndicatorType == USE_DIVLOADING) {
                if (SiteUI.IsLoading($loadingDiv)) {
                    SiteUI.HideLoading($loadingDiv, $loadingDiv2);
                }
            }
        }
        if (completeCallback) {
            completeCallback(data_jqXHR, textStatus, jqXHR_errorThrown);
        }
    });
}
// you can use loadingCriteria {Div1: $("#div"),Div2: $("#div")} OR $("#div")
SiteCommon.GetUrlData = function (url, data, successCallBack, errorCallBack, loadingCriteria, completeCallback, doNotHideOnSuccess) {
    var NOLOADINGINDICATOR = 0;
    var USE_DIVLOADING = 1;
    var USE_UPDATINGBOX = 2;

    var hideLoading = true;
    var loadingIndicatorType = NOLOADINGINDICATOR;
    var $loadingDiv = null;
    var $loadingDiv2 = null;

    if (doNotHideOnSuccess != undefined && doNotHideOnSuccess === true) {
        hideLoading = false;
    }

    var message = "";
    if (loadingCriteria instanceof jQuery) {
        loadingIndicatorType = USE_DIVLOADING;
        $loadingDiv = loadingCriteria;
    }
    else {
        if (!loadingCriteria) {
            loadingIndicatorType = NOLOADINGINDICATOR;
        }
        else {
            if (loadingCriteria && loadingCriteria.Message) {
                loadingIndicatorType = USE_UPDATINGBOX;
                message = loadingCriteria.Message;
            }
            else if (loadingCriteria && loadingCriteria.Div1 && loadingCriteria.Div2) {
                loadingIndicatorType = USE_DIVLOADING;
                $loadingDiv = loadingCriteria.Div1;
                $loadingDiv2 = loadingCriteria.Div2;
            }
            else {
                loadingIndicatorType = USE_UPDATINGBOX;
            }
        }
    }

    if (loadingIndicatorType == USE_UPDATINGBOX) {
        SiteUI.ShowLoadingBox(message,$loadingDiv, $loadingDiv2);
		//SiteUI.ShowLoading($loadingDiv, $loadingDiv2);
    }
    else if (loadingIndicatorType == USE_DIVLOADING) {
        SiteUI.ShowLoading($loadingDiv, $loadingDiv2);
    }

    $.ajax({
        type: "GET",
        url: url,
        data: data,
        contentType: "application/json; charset=utf-8"
    })
    .done(function (data, textStatus, jqXHR) {
        if (hideLoading) {
            if (loadingIndicatorType == USE_UPDATINGBOX) {
                SiteUI.HideLoadingBox();
            }
            else if (loadingIndicatorType == USE_DIVLOADING) {
                SiteUI.HideLoading($loadingDiv, $loadingDiv2);
            }
        }
        successCallBack(data, textStatus, jqXHR);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        errorCallBack(jqXHR, textStatus, errorThrown);
        if (hideLoading) {
            if (loadingIndicatorType == USE_UPDATINGBOX) {
                SiteUI.HideLoadingBox();
            }
            else if (loadingIndicatorType == USE_DIVLOADING) {
                SiteUI.HideLoading($loadingDiv, $loadingDiv2);
            }
        }
    })
    .always(function (data_jqXHR, textStatus, jqXHR_errorThrown) {
        if (hideLoading) {
            if (loadingIndicatorType == USE_UPDATINGBOX) {
                SiteUI.HideLoadingBox();
            }
            else if (loadingIndicatorType == USE_DIVLOADING) {
                if (SiteUI.IsLoading($loadingDiv)) {
                    SiteUI.HideLoading($loadingDiv, $loadingDiv2);
                }
            }
        }
        if (completeCallback) {
            completeCallback(data_jqXHR, textStatus, jqXHR_errorThrown);
        }
    });
}

SiteCommon.Protocol = function () {
    if ("https:" == document.location.protocol) {
        /* secure */
        return "https:"
    } else {
        /* unsecure */
        return "http:"
    }
}

SiteCommon.ResolveAPIPath = function (path) {
    var host = window.location.host;
    var finalPath = "/Api/" + path;
    if (path.startsWith("/")) {
        finalPath = "/Api" + path;
    }
    return SiteCommon.Protocol() + "//" + window.location.host + finalPath;
    // forcing http for now due to how prod is setup
    //return "http:" + "//" + window.location.host + finalPath;
}

SiteCommon.ResolvePath = function (path) {
    var host = window.location.host;
    var finalPath = "/" + path;
    if (path.startsWith("/")) {
        finalPath = "" + path;
    }
    return SiteCommon.Protocol() + "//" + window.location.host + finalPath;
}
SiteCommon.ArrayFindItem = function (arrayObject, compareCallBack, defaultData) {
    if (arrayObject != null) {
        for (var i = 0; i < arrayObject.length; i++) {
            var okay = compareCallBack(arrayObject[i])
            if (okay) {
                return arrayObject[i];
            }
        }
    }

    if (!defaultData) {
        return null;
    }
    else {
        return defaultData;
    }
};
SiteCommon.ArrayRemoveItem = function (arrayObject, compareCallBack, doDeleteObject,eventAfterDeleteCallBack) {

    if (doDeleteObject == undefined) {
        doDeleteObject = false;
    }

    if (arrayObject != null) {
        for (var i = 0; i < GetPropertyValue(arrayObject).length; i++) {
            var objectToDelete = GetPropertyValue(arrayObject)[i];
            if (compareCallBack(objectToDelete)) {
                arrayObject.splice(i, 1);
                //return arrayObject[i];
                if (doDeleteObject) {
                    delete objectToDelete;
                }

                if (eventAfterDeleteCallBack) {
                    eventAfterDeleteCallBack();
                }
            }
        }
    }
};

SiteCommon.InIframe = function () {
    try {
        return window.self !== window.top;
    } catch (e) {
        return true;
    }
};

SiteCommon.HasValue = function (obj) {
    if(obj == null) return false; 
	if(obj == undefined) return false;
	
	if(!obj){
		if(obj !== 0 && obj !== false){
			if ((typeof myVar === 'string' || myVar instanceof String) && $.trim(obj).length == 0){
				return false;
			}
		}
	}
	
	return true;
};

SiteCommon.GetValueOrDefault = function (variableValue, valueDefault) {

    if (!SiteCommon.HasValue(variableValue)) {
        if (!SiteCommon.HasValue(valueDefault)) {
			if (typeof variableValue === 'string' || variableValue instanceof String){
				return "";	
			}
			else if (typeof variableValue === 'number'){
				return 0;
			}
			else if (typeof variableValue === 'boolean'){
				return false;
			}
			else{
				return "";	
			}
        }
        return valueDefault;
    }

    return variableValue;
};