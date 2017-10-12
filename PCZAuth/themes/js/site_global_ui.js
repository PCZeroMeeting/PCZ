SiteUI = {};

SiteUI.CapitaliseFirstLetter= function (string){
    return string.charAt(0).toUpperCase() + string.slice(1);
}

SiteUI.show = function ($obj){
	$obj.show();
	$obj.removeClass("hide");
};

SiteUI.hide = function ($obj){
	$obj.hide();
	$obj.removeClass("show");
};

SiteUI.QueryString = function (Key) {
    var url = window.location.href;
    var KeysValues = url.split(/[\?&]+/);
    for (i = 0; i < KeysValues.length; i++) {
        KeyValue = KeysValues[i].split("=");
        if (KeyValue[0] == Key) {
            return KeyValue[1];
        }
    }
};

SiteUI.QueryStringExist = function (Key) {
    var url = window.location.href;
    var KeysValues = url.split(/[\?&]+/);
    for (i = 0; i < KeysValues.length; i++) {
        KeyValue = KeysValues[i].split("=");
        if (KeyValue[0] == Key) {
            return true;
        }
    }
	
	return false;
};

SiteUI.Alert = function (message, title, type, yesCallback, noCallback, alertCallback) {
	//http://bootstrap-notify.remabledesigns.com/
    //$(".loading").hide();
    switch (type) {
        case "modalyesno":
		{
            if ($('#modalAlertGlobal').length > 0) {
                if (title) {
                    $('#modalAlertGlobal #modalAlertGlobalTitle').text(title);
                }
                if (message) {
                    $('#modalAlertGlobal #modalAlertGlobalMsg').html("<span>" + message + "</span>");
                }
                var $thisAlert = $('#modalAlertGlobal');
                $thisAlert.modal();
                $thisAlert.draggable({ handle: '.modal-drag' });
                $thisAlert.find('#modalAlertGlobalButtonDiv').show();
                $thisAlert.find("#modalAlertGlobalYesButton").on("click", function (event) {
                    event.preventDefault();
                    yesCallback(event);
					$thisAlert.modal('hide');
                });
                $thisAlert.find("#modalAlertGlobalNoButton").on("click", function (event) {
                    event.preventDefault();
                    noCallback(event);
                    $thisAlert.modal('hide');
                });

                if (alertCallback) {
                    alertCallback($thisAlert);
                }
				
				SiteUI.show($('#modalAlertGlobal'));
            }
            break;
		}
        case "modalalert":
		{
            if ($('#modalAlertGlobal').length > 0) {
                if (title) {
                    $('#modalAlertGlobal #modalAlertGlobalTitle').text(title);
                }
                if (message) {
                    $('#modalAlertGlobal #modalAlertGlobalMsg').html("<span>" + message + "</span>");
                }
                $('#modalAlertGlobal').modal();
                $('#modalAlertGlobal').draggable({ handle: '.modal-drag' });
                $('#modalAlertGlobal #modalAlertGlobalButtonDiv').hide();
            }
            break;
		} 
		case "success":
		case "error":
        case "warning": 
		{
			if(type == "error") type = "danger";
			
			$.notify({title: title,message:''+message+''}, { 
				allow_dismiss: true ,
				showProgressbar: true,
				type: type,
				mouse_over : "pause",
				placement: {
					from: "top",
					align: "right"
				},				
				animate: {
					enter: 'animated fadeInDown',
					exit: 'animated fadeOutUp'
				},			
			});	
            break;
		}		
        default: 
		{ 
			$.notify({title: title,message:''+message+''}, { 
				allow_dismiss: true ,
				showProgressbar: true,
				placement: {
					from: "top",
					align: "right"
				},				
				mouse_over : "pause",
				type:"info",
				animate: {
					enter: 'animated fadeInDown',
					exit: 'animated fadeOutUp'
				},			
			});			
		}
    }
};

SiteUI.ShowErrorModal = function (title, msg) {
    if ($('#modalAlertGlobal').length > 0) {
        $('#spanClientErrorTitle').text(title);
        $('#spanClientErrorMsg').text(msg);
        $('#modalAlertGlobal').modal();
        $('#modalAlertGlobal').draggable({ handle: '.modal-drag' });
    }
};


SiteUI.ShowLoading = function ($el, $el2, ENABLE_LOADING_SHOW_TIMEOUT, LOADING_SHOW_TIMEOUT,isLoadingBox,loadingboxMessage) {
    var $load = {};
	if(!isLoadingBox) isLoadingBox = false;
	if(!loadingboxMessage) loadingboxMessage = "";
	
    $el.css("position", "relative");
    if (!ENABLE_LOADING_SHOW_TIMEOUT) {
        ENABLE_LOADING_SHOW_TIMEOUT = true;
    }

    if (!LOADING_SHOW_TIMEOUT) {
        LOADING_SHOW_TIMEOUT = 100000;
    }

    if ($el.children(".loading").length <= 0) {
		if(!isLoadingBox){
			$load = $('<span class="loading"></span>')
		}
		else {
			$load = $('<span class="loading loading-box">'+loadingboxMessage+'</span>')
		}
        $el.append($load);
    }
    else {
        $load = $el.children(".loading");
    }

    $load.fadeIn();

    if ($el2) {
        var $load2 = {};
        $el2.css("position", "relative");
        if ($el2.children(".loading").length <= 0) {
			if(!isLoadingBox){
				$load2 = $('<span class="loading"></span>');
			}
			else {
				$load2 = $('<span class="loading loading-box">'+loadingboxMessage+'</span>');
			}
            $el2.append($load2);
        }
        else {
            $load2 = $el2.children(".loading");
        }

        $load2.fadeIn();
    }

    if (ENABLE_LOADING_SHOW_TIMEOUT) {
        window.setTimeout(function () {
            if (SiteUI.IsLoading($el)) {
                $.jGrowl("Timeout occured in loading..", { position: 'managementBar', life: 3000 });
                if ($el2) {
                    SiteUI.HideLoading($el, $el2);
                }
                else {
                    SiteUI.HideLoading($el);
                }
            }
        }, LOADING_SHOW_TIMEOUT);
    }
};

SiteUI.HideLoading = function ($el, $el2) {
    $el.children(".loading").fadeOut().hide();
    if ($el2) {
        $el2.children(".loading").fadeOut().hide();
    }
};

SiteUI.ShowLoadingBox = function (message,$el, $el2){
	//if($el)
	SiteUI.ShowLoading($el, $el2, null, null,true,message);	
	if($el && $el.length > 0){
		$el.css("position","absolute");	
	}
	if($el2 && $el2.length > 0){
		$el2.css("position","absolute");	
	}
};
SiteUI.HideLoadingBox = function (message){
	//SiteUI.HideLoading($el, $el2);
	$(".loading").fadeOut().hide();
};

SiteUI.IsLoading = function ($el) {
    if ($el.children(".loading").is(':visible')) {
        return true;
    }
    return false;
};

SiteUI.GenerateCategoriesCheckBox = function (categories){
	var col = 6;
	var htmlCheckboxes = "";
	var itemHtml = '';
	var i = 0;
	while(i< categories.length){		
		itemHtml = '';
		itemHtml += '<tr>';		
		var colctr =0;
		while(colctr < col && i< categories.length){		
			itemHtml +='<td><div class="checkbox"><label><input class="input-checkbox" id="chk'+categories[i]+'" type="checkbox" value="'+categories[i]+'">'+ucwords(categories[i].replace(/_/g,' '))+'</label></div></td>';
			colctr++;
			i++;
		}		
		itemHtml += '</tr>';
		
		htmlCheckboxes += itemHtml;
		 
 	}
	var tableHtml = '<table>'+htmlCheckboxes+'</table>';
	
	return tableHtml;
};

SiteUI.RegisterGenerateTagOptions = function (tagsOptionsSelectorStr){
	
	var tableHtml = SiteUI.GenerateCategoriesCheckBox(SiteData.Categories);
	
	$(tagsOptionsSelectorStr).html(tableHtml);
	
	$(tagsOptionsSelectorStr+" .input-checkbox").on("change",function (event){
		event.preventDefault();
		if(this.checked){
			var tagdata = $("#tags").val();
			var data = $(this).val();
			if(tagdata.indexOf(data) < 0){
				if(tagdata == ""){ tagdata = data;}
				else{tagdata = tagdata +' '+ data;}				
				tagdata = tagdata.replace(/  /g,' ');
				$("#tags").val(tagdata);				
			}
		}
		else {
			var tagdata = $("#tags").val();
			var data = $(this).val();
			tagdata = tagdata.replace(data, "");
			tagdata = tagdata.replace(/  /g,' ');
			$("#tags").val(tagdata);
		}
	});
	
	if($("#tags").val().length > 0){
		var tagsArr = $("#tags").val().split(" ");
		for(var i=0;i < tagsArr.length;i++){
			$('#chk'+tagsArr[i]).prop("checked",true);
		}
	}	

	$("#title").on("blur",function (event){
		event.preventDefault();
		if($("#description").val().length == 0){
			$("#description").val($(this).val());
		}
	});	
};
SiteHelper = {};

//update data using http://country.io/currency.json
SiteHelper.GetCurrency = function (countryCode2,callBack){
	var jsonCurrencies = {"BD": "BDT", "BE": "EUR", "BF": "XOF", "BG": "BGN", "BA": "BAM", "BB": "BBD", "WF": "XPF", "BL": "EUR", "BM": "BMD", "BN": "BND", "BO": "BOB", "BH": "BHD", "BI": "BIF", "BJ": "XOF", "BT": "BTN", "JM": "JMD", "BV": "NOK", "BW": "BWP", "WS": "WST", "BQ": "USD", "BR": "BRL", "BS": "BSD", "JE": "GBP", "BY": "BYR", "BZ": "BZD", "RU": "RUB", "RW": "RWF", "RS": "RSD", "TL": "USD", "RE": "EUR", "TM": "TMT", "TJ": "TJS", "RO": "RON", "TK": "NZD", "GW": "XOF", "GU": "USD", "GT": "GTQ", "GS": "GBP", "GR": "EUR", "GQ": "XAF", "GP": "EUR", "JP": "JPY", "GY": "GYD", "GG": "GBP", "GF": "EUR", "GE": "GEL", "GD": "XCD", "GB": "GBP", "GA": "XAF", "SV": "USD", "GN": "GNF", "GM": "GMD", "GL": "DKK", "GI": "GIP", "GH": "GHS", "OM": "OMR", "TN": "TND", "JO": "JOD", "HR": "HRK", "HT": "HTG", "HU": "HUF", "HK": "HKD", "HN": "HNL", "HM": "AUD", "VE": "VEF", "PR": "USD", "PS": "ILS", "PW": "USD", "PT": "EUR", "SJ": "NOK", "PY": "PYG", "IQ": "IQD", "PA": "PAB", "PF": "XPF", "PG": "PGK", "PE": "PEN", "PK": "PKR", "PH": "PHP", "PN": "NZD", "PL": "PLN", "PM": "EUR", "ZM": "ZMK", "EH": "MAD", "EE": "EUR", "EG": "EGP", "ZA": "ZAR", "EC": "USD", "IT": "EUR", "VN": "VND", "SB": "SBD", "ET": "ETB", "SO": "SOS", "ZW": "ZWL", "SA": "SAR", "ES": "EUR", "ER": "ERN", "ME": "EUR", "MD": "MDL", "MG": "MGA", "MF": "EUR", "MA": "MAD", "MC": "EUR", "UZ": "UZS", "MM": "MMK", "ML": "XOF", "MO": "MOP", "MN": "MNT", "MH": "USD", "MK": "MKD", "MU": "MUR", "MT": "EUR", "MW": "MWK", "MV": "MVR", "MQ": "EUR", "MP": "USD", "MS": "XCD", "MR": "MRO", "IM": "GBP", "UG": "UGX", "TZ": "TZS", "MY": "MYR", "MX": "MXN", "IL": "ILS", "FR": "EUR", "IO": "USD", "SH": "SHP", "FI": "EUR", "FJ": "FJD", "FK": "FKP", "FM": "USD", "FO": "DKK", "NI": "NIO", "NL": "EUR", "NO": "NOK", "NA": "NAD", "VU": "VUV", "NC": "XPF", "NE": "XOF", "NF": "AUD", "NG": "NGN", "NZ": "NZD", "NP": "NPR", "NR": "AUD", "NU": "NZD", "CK": "NZD", "XK": "EUR", "CI": "XOF", "CH": "CHF", "CO": "COP", "CN": "CNY", "CM": "XAF", "CL": "CLP", "CC": "AUD", "CA": "CAD", "CG": "XAF", "CF": "XAF", "CD": "CDF", "CZ": "CZK", "CY": "EUR", "CX": "AUD", "CR": "CRC", "CW": "ANG", "CV": "CVE", "CU": "CUP", "SZ": "SZL", "SY": "SYP", "SX": "ANG", "KG": "KGS", "KE": "KES", "SS": "SSP", "SR": "SRD", "KI": "AUD", "KH": "KHR", "KN": "XCD", "KM": "KMF", "ST": "STD", "SK": "EUR", "KR": "KRW", "SI": "EUR", "KP": "KPW", "KW": "KWD", "SN": "XOF", "SM": "EUR", "SL": "SLL", "SC": "SCR", "KZ": "KZT", "KY": "KYD", "SG": "SGD", "SE": "SEK", "SD": "SDG", "DO": "DOP", "DM": "XCD", "DJ": "DJF", "DK": "DKK", "VG": "USD", "DE": "EUR", "YE": "YER", "DZ": "DZD", "US": "USD", "UY": "UYU", "YT": "EUR", "UM": "USD", "LB": "LBP", "LC": "XCD", "LA": "LAK", "TV": "AUD", "TW": "TWD", "TT": "TTD", "TR": "TRY", "LK": "LKR", "LI": "CHF", "LV": "EUR", "TO": "TOP", "LT": "LTL", "LU": "EUR", "LR": "LRD", "LS": "LSL", "TH": "THB", "TF": "EUR", "TG": "XOF", "TD": "XAF", "TC": "USD", "LY": "LYD", "VA": "EUR", "VC": "XCD", "AE": "AED", "AD": "EUR", "AG": "XCD", "AF": "AFN", "AI": "XCD", "VI": "USD", "IS": "ISK", "IR": "IRR", "AM": "AMD", "AL": "ALL", "AO": "AOA", "AQ": "", "AS": "USD", "AR": "ARS", "AU": "AUD", "AT": "EUR", "AW": "AWG", "IN": "INR", "AX": "EUR", "AZ": "AZN", "IE": "EUR", "ID": "IDR", "UA": "UAH", "QA": "QAR", "MZ": "MZN"};
	var found = false;
	$.each(jsonCurrencies,function(key,value){
		if(key == countryCode2){
			if(callBack){
				callBack(key,value);				
			}
			found = true;
			return false;
		}
	});	
	
	if(!found){
		callBack(countryCode2,"");
	}	
};

SiteHelper.GetLocation = function (callBack){
 
		$.get("http://ipinfo.io", function (response) {
			callBack(response,false);
		}, "jsonp");			
 
    //enter code here
};

/*
To use:
1) You need to replace Validation.Properties with what you have in your div/from/etc
2) You need to initialize Validation.InitializeValidation this will register the events add the filter, filter can be a string or jquery object.
3) Validation.Validate will trigger all the validation, much like form validation

NOTE: 
- mask properties can be 
    integer 
    float 
    maxLength=50
    9999999
- validation check for empty values, so if you create a other validation just empty the value
- this requires you to add your message element/span and hide it.    
*/
//////////////////
SiteUI.Validation = function (properties) {
    var me = this;
    this.EnableValidation = true;
    this.$Filter = "";
    this.RemoveNonMaskKeys = function (maskKey) {
        var maskKeyRet = maskKey.replace(/integer/g, "").replace(/float/g, "");

        var end = maskKeyRet.indexOf("maxlength");
        if (end != -1) {
            maskKeyRet = maskKeyRet.slice(0, end);
        }

        end = maskKeyRet.indexOf("minlength");
        if (end != -1) {
            maskKeyRet = maskKeyRet.slice(0, end);
        }

        return maskKeyRet.replace(/ /g, "");
    };
    this.GetKeyObject = function (key) {
        var $currentElement = {};

        if (me.$Filter instanceof jQuery) {
            $currentElement = me.$Filter.find(key);
        }
        else
        { $currentElement = $(me.$Filter + " " + key); }

        return $currentElement;
    };
    this.Properties =
          { "#SampleStreetTextBox": { "required": true, "mask": "", "messageElement": "#rfvBillingStreetTextBox", "group": "", "CompoundValidationOnly": true, "Condition": function ($obj) { return true; } },
              "#SampleCityTextBox": { "required": true, "mask": "", "messageElement": "#rfvBillingCityTextBox", "group": "" },
              "#SampleStateDropDown": { "required": true, "mask": "integer float maxLength=50", "messageElement": "", "group": "" },
              "#SamplePostalCodeTextBox": { "required": true, "mask": "99999", "messageElement": "#rfvBillingPostalCodeTextBox", "group": "zip" },
              "#SamplePostalCodeExtendedTextBox": { "required": true, "mask": "9999", "messageElement": "", "group": "zip" }
          };
    this.GetMessageObj = function ($me, key, value) {
        var messageElement = value["messageElement"];
        if (me.Properties[key] != null && me.Properties[key] != undefined) {
            if (me.Properties[key]["messageElement"] != null && me.Properties[key]["messageElement"] != undefined) { messageElement = me.Properties[key]["messageElement"];}
        }
        var $msgElement = me.GetKeyObject(messageElement);

        if ($msgElement.length <= 0) {
            $msgElement = me.GetKeyObject("#" + $me.attr("id") + "_validation");

            if ($msgElement.length <= 0) {
                $msgElement = $("<span id='" + $me.attr("id") + "_validation' style='color: Red; visibility: visible;'>&nbsp;Required</span>");
                $me.after($msgElement);
            }
        }

        return $msgElement;
    };
    //private dont call this
    this.CheckValue = function ($me, key, value) {

        var exemptions = ["___ - ___", "_____", "___-___"];

        var valueData = $.trim($me.val());
        //Hack: this is when .mask was declared after this validation (SiteUI.Validation.InitializeValidation) the event priority changes and the placeholder will not be erased at this point.
        for (var ix = 0; ix < exemptions.length; ix++) {
            if (valueData == exemptions[ix]) {
                valueData = "";
            }
        }

        if (
                (
                    value["required"] && !valueData ||
                    (
                        value["Condition"] && !value["Condition"]($me)
                    )
                ) &&
                (
                    !($me.is(":visible") == false || $me.css('visibility') == "hidden")
                )
           ) {
            $messageElement = me.GetMessageObj($me, key, value);
            $messageElement.show();

            if ($messageElement.css('visibility') !== undefined) {
                $messageElement.css('visibility', 'visible');
                $messageElement.removeClass('visibility');
            }
            return false;
        }
        else {
            $messageElement = me.GetMessageObj($me, key, value);

            if (value["group"] == "") {
                $messageElement.hide();
                if ($messageElement.css('visibility') !== undefined) {
                    $messageElement.css('visibility', 'hidden');
                }
                return true;
            }
            else {
                if ((!$.trim($me.val()) || (value["Condition"] && !value["Condition"]($me))) && ($me.is(":visible") || $me.css('visibility') == "visible")) {
                    $messageElement.show();
                    if ($messageElement.css('visibility') !== undefined) {
                        $messageElement.css('visibility', 'visible');
                    }

                    return false;
                }
                else {
                    $messageElement.hide();
                    if ($messageElement.css('visibility') !== undefined) {
                        $messageElement.css('visibility', 'hidden');
                    }

                    return true;
                }
            }
        }
    };

    this.Validate = function () {
        var ok = true;
        $.each(me.Properties, function (key, value) {
            var isStateRequired = true;
            if ($('#hfIsFreeForm').val() === "1") {
                if (key === "#txtReqBillingStateTextBox" || key === "#txtReqShippingStateTextBox") {
                    isStateRequired = false;
                }
            }

            if (isStateRequired) {
                var $currentElement = me.GetKeyObject(key);

                if (!me.CheckValue($currentElement, key, value)) {
                    ok = false;
                }
            }
        });


        return ok;
    };
    this.BoolValue = function (val) {
        if (val != undefined && val) {
            return true;
        }
        return false;
    }
    this.InitializeValidation = function ($filter) {
        //add validation in pop-up
        this.$Filter = $filter;
        $.each(me.Properties, function (key, value) {
            var ctr = 0;
            $.each(value, function (key1, value1) {
                var $currentElement = null;

                $currentElement = me.GetKeyObject(key);

                if (key1.toLowerCase() == "mask" && value != "" && value != null) {
                    var commandArray = value1.split(" ");
                    $.each(commandArray, function (index, commands) {
                        if (commands.toLowerCase() == "float" || commands.toLowerCase() == "decimal") {
                            $currentElement.keyup(function (e) {
                                if ($.isNumeric(this.value) || this.value == "" || this.value == "-") {
                                    // Filter non-digits from input value.
                                    $currentElement.attr("oldValue", this.value);
                                }
                                else {
                                    if (this.value != "") {
                                        var oldValue = $currentElement.attr("oldValue");
                                        if (oldValue == undefined) {
                                            oldValue = "";
                                        }

                                        this.value = oldValue;
                                    }
                                }
                            })
                        }
                        if (commands.toLowerCase() == "integer") {
                            $currentElement.keyup(function (e) {
                                if (($.isNumeric(this.value) || this.value == "" || this.value == "-") && this.value.indexOf(".") == -1) {
                                    // Filter non-digits from input value.
                                    $currentElement.attr("oldValue", this.value);
                                }
                                else {
                                    if (this.value != "") {
                                        var oldValue = $currentElement.attr("oldValue");
                                        if (oldValue == undefined) {
                                            oldValue = "";
                                        }

                                        this.value = oldValue;
                                    }
                                }
                            });
                        }
                        if (commands.toLowerCase().substr(0, 9) == "maxlength") {
                            var subcomm = commands.toLowerCase().split("=");
                            $currentElement.attr("maxlength", subcomm[1]);
                        }
                        if (commands.toLowerCase().substr(0, 9) == "minlength") {
                            var subcomm = commands.toLowerCase().split("=");
                            $currentElement.attr("minlength", subcomm[1]);
                        }
                    });
                }

                if (ctr == 0) {
                    $currentElement.on("blur", function () {
                        var isStateRequired = true;
                        if (typeof $(this) !== "undefined" && $('#hfIsFreeForm').val() === "1")
                            if ($(this).attr("id") === "txtReqBillingStateTextBox" || $(this).attr("id") === "txtReqShippingStateTextBox")
                                isStateRequired = false;

                        if (isStateRequired) {
                            var $me1 = $(this);
                            if (key1.toLowerCase() == "required" && value1 == true && me.EnableValidation && !me.BoolValue(value["CompoundValidationOnly"])) {
                                me.CheckValue($me1, key, value);
                            }
                        }
                    });
                }
                if (key1.toLowerCase() == "mask" && value1 != "" && me.RemoveNonMaskKeys(value1) != "" && me.EnableValidation && !me.BoolValue(value["CompoundValidationOnly"])) {
                    $currentElement.mask(me.RemoveNonMaskKeys(value1));
                    $currentElement.on("blur", function () {
                        me.CheckValue($currentElement, key, value);
                    });
                }
                ctr++;
            });

        });
    };
};


SiteUI.ForceWinBid = function (biddername,bid,atDatetime,urlAction){
	SiteUI.Alert('Are you sure to make '+biddername+ ' with '+bid+' at '+atDatetime+' win?','Winning Bid','modalyesno',
	function (){
		window.location.href = urlAction;
	},
	function (){});
};
/*
NOTES: To use this shit you need to add this motherfucking html, if you know wattai mean. 
<div id="demo4_top"></div>
<div id="content"></div>
<div id="demo4_bottom"></div>
*/
//SiteLinks.ShowLinkList(10,"#demo4_top","#demo4_bottom","#content");
SiteUI.ToggleChevron = function (e) {
	$(e.target)
		.prev('.panel-heading')
		.find("i.indicator")
		.toggleClass('glyphicon-chevron-down glyphicon-chevron-up'); 
};
