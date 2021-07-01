String.prototype.trimLeft = function(charlist) {
  if (charlist === undefined)
	charlist = "\s";
  return this.replace(new RegExp("^[" + charlist + "]+"), "");
};
String.prototype.trimRight = function(charlist) {
  if (charlist === undefined)
	charlist = "\s";
  return this.replace(new RegExp("[" + charlist + "]+$"), "");
};
/**
 * return a form data as javascript object
 */
function getFormData(form){
    var out = {};
    var s_data = $(form).serializeArray();
    //transform into simple data/value object
    for(var i = 0; i<s_data.length; i++){
        var record = s_data[i];
        out[record.name] = record.value;
    }
    return out;
}
/**
 * convert simple string separated by comma into array
 */
function valToArray(val) {
	if(val){
		if(Array.isArray(val)){
			return val;
		}
		else{
			return val.split(",");
		}
	}
	else{
		return [];
	}
};
/**
 * simple debounce function for ajax loading on user typing
 */
function debounce(fn, delay) {
  var timer = null;
  return function () {
	var context = this, args = arguments;
	clearTimeout(timer);
	timer = setTimeout(function () {
	  fn.apply(context, args);
	}, delay);
  };
}
/**
 * merge two object
 */
function extend(obj, src) {
	for (var key in src) {
		if (src.hasOwnProperty(key)) obj[key] = src[key];
	}
	return obj;
}
/**
 * check if a string is a valid url
 */
function isURL(str) {
	return /^(?:\w+:)?\/\/([^\s\.]+\.\S{2}|localhost[\:?\d]*)\S*$/.test(str); 
}
//return the absolute url of a path with query string 
function setPathLink(path , queryObj){
	var queryStr = "";
	if(queryObj){
		var str = [];
		for(var k in queryObj){
			var v = queryObj[k]
			if (queryObj.hasOwnProperty(k) && v !== '') {
				str.push(encodeURIComponent(k) + "=" + encodeURIComponent(v));
			} 
		}
		var qs = str.join("&");
		if(path.indexOf('?') > 0){
			queryStr = '&' + qs;  
		}
		else{
			queryStr = '?' + qs;  
		}
	}
	if(!isURL(path)){
		return url = siteAddr + path + queryStr;
	}
	else{
		return url =  path + queryStr;
	}
}
function showToastSuccess(msg){
	var flashAlert = $('<div class="alert alert-success animated bounce fixed-alert bottom-left"><button type="button" class="close" data-dismiss="alert">&times;</button>' + msg + '</div>');
	$('body').append(flashAlert);
	window.setTimeout(function(){
		flashAlert.remove();
	},3000);
}
function showToastDanger(msg){
	var flashAlert = $('<div class="alert alert-danger animated bounce fixed-alert bottom-left"><button type="button" class="close" data-dismiss="alert">&times;</button>' + msg + '</div>');
	$('body').append(flashAlert);
	window.setTimeout(function(){
		flashAlert.remove();
	},3000);
}
/**
 * generate random hexadecimal color
 */
function randomColor() {
	var letters = '0123456789ABCDEF';
	var color = '#';
	for (var i = 0; i < 6; i++) {
		color += letters[Math.floor(Math.random() * 16)];
	}
	return color;
}
var pageLoadingIndicator = $('#page-loading-indicator').html(); //loding indicator used for ajax load content
var pageSavingIndicator = $('#page-saving-indicator').html(); //saving indicator used for ajax submit form
var inlineLoadingIndicator = $('#inline-loading-indicator').html(); //inline loading indicator
$(document).ready(function() {
	//hides page flash msg after page navigate.
	var elem=$('#flashmsgholder');
	if(elem.length>0){
		var duration=elem.attr("data-show-duration");
		if(duration>0){
			window.setTimeout(function(){
				elem.fadeOut();
			},duration)
		}
	}
});
/**
 * Table toggle select all records
 */
$(document).on('click', '.toggle-check-all', function(){
	var p = $(this).closest('table').find('.optioncheck');
	p.prop("checked",$(this).prop("checked"));
});
/**
 * Table select a record 
 */
$(document).on('click', '.optioncheck, .toggle-check-all', function(){
	var sel_ids =$(this).closest('.page').find("input.optioncheck:checkbox:checked").map(function(){
	  return $(this).val();
	}).get();
	if(sel_ids.length>0){
		 $(this).closest('.page-content').find('.btn-delete-selected').removeClass('d-none');
	}
	else{
		$(this).closest('.page-content').find('.btn-delete-selected').addClass('d-none');
	}
});
/**
 * Table delete selected record
 */
$(document).on('click', '.btn-delete-selected', function(e){
	var recordDeleteMsg = $(this).data("prompt-msg");
	var displayStyle = $(this).data("display-style");
	if(!recordDeleteMsg){
		recordDeleteMsg = "Are you sure you want to delete selected records?";
	}
	var sel_ids =$(this).closest('.page-content').find("input.optioncheck:checkbox:checked").map(function(){
	  return $(this).val();
	}).get();
	if(sel_ids.length>0){
		var url = $(this).data('url');
		url = url.replace("{sel_ids}",sel_ids);
		if(displayStyle == 'confirm'){
			if(confirm(recordDeleteMsg)){
				window.location = url;
			}
			else{
				e.preventDefault();
			}
		}
		else if(displayStyle == 'modal'){
			$('#delete-record-modal-msg').html(recordDeleteMsg);
			$('#delete-record-modal-confirm').modal('show');
			$('#delete-record-modal-btn').attr('href', url);
			var ajaxpage = $(this).closest(".ajax-page");
			$('#delete-record-modal-btn').data("ajax-page", ajaxpage);
			e.preventDefault();
		}
		else{
			window.location = url;
		}
	}
	else{
		alert('No Record Selected');
	}
});
/**
 * page delete record action button
 */
$(document).on('click', '.record-delete-btn', function(e){
	var recordDeleteMsg = $(this).data("prompt-msg");
	var displayStyle = $(this).data("display-style");
	if(!recordDeleteMsg){
		recordDeleteMsg="Are you sure you want to delete this record?";
	}
	if(displayStyle == 'confirm'){
		if(!confirm(recordDeleteMsg)){
			e.preventDefault();
		}
	}
	else if(displayStyle == 'modal'){
		$('#delete-record-modal-msg').html(recordDeleteMsg);
		$('#delete-record-modal-confirm').modal('show');
		$('#delete-record-modal-btn').attr('href', $(this).attr('href'));
		var ajaxpage = $(this).closest(".ajax-page");
		$('#delete-record-modal-btn').data("ajax-page", ajaxpage);
		e.preventDefault();
	}
});
/**
 * modal confirm delete action
 */
$(document).on( "click", "#delete-record-modal-btn", function(e) {
	var ajaxpage = $(this).data('ajax-page');
	//if ajaxpage is present then delete using ajax else continue with delete navigation
	if(ajaxpage.length){
		e.preventDefault();
		var deleteUrl = $(this).attr('href');
		$('#delete-record-modal-msg').html(inlineLoadingIndicator);
		$.ajax({
			url: deleteUrl,
			type: "get",
			success: function(msg) {
				showToastSuccess(msg);
				var pageUrl = ajaxpage.data("page-url");
				loadPageData(ajaxpage, pageUrl); //reload page data
				$('#delete-record-modal-confirm').modal('hide'); //close modal
			},
			error: function( xhr, err ) {
				showToastDanger(xhr.statusText);
			}
		});
	}
});
/**
 * remove uploaded file action on edit page
 */
$(document).on('click', '.removeEditUploadFile', function(e){
	 // hidden input that contains all the file
	var holder = $(this).closest(".uploaded-file-holder");
	var inputid = $(this).attr("data-input");
	var inputControl = $(inputid);
	var filepath = $(this).attr('data-file');
	var filenum = $(this).attr('data-file-num');
	var srcTxt = inputControl.val();
	if(srcTxt){
		var arrSrc = srcTxt.split(",");
		arrSrc.forEach(function(src,index){
			if(src == filepath){
				arrSrc.splice(index,1);
			}
		});
		holder.find("#file-holder-"+filenum).remove();
		var ty = arrSrc.join(",");
		inputControl.val(ty);
	}
});
/**
 * custom btn to close a popover view
 */
$(document).on("click", ".popover .close-btn, .popover .close" , function(){
	$(this).parents(".popover").popover('hide');
});
/**
 * Display a page in popover component
*/
$(document).on('click', '.open-page-popover', function(e){
	$('.open-page-popover').not(this).popover('hide'); // hide other popover
	e.preventDefault();
});
/**
 * toggle a new table row and open a page link in the view
 */
$(document).on('click', '.open-page-inline', function(e){
	e.preventDefault();
	var dataURL = $(this).attr('href');
	if($(this).closest('tr').length != 0){
		var tbRow = $(this).closest('tr');
		var loaded = tbRow.attr('loaded');
		var colspan = tbRow.children('td,th').length;
		if(!loaded){
			tbRow.attr('loaded', true);
			var newRow = $('<tr class="child-row"><td colspan="' + colspan + '"><div class="row justify-content-center"><div class="col-md-6"><div class="content reset-grids inline-page">' + pageLoadingIndicator + '</div></div></div></td></tr>');
			tbRow.after(newRow); 
			newRow.find('.content').load(dataURL, function(responseText, status, req){
				if(status == 'error'){
					tbRow.removeAttr('loaded');
				}
			});
		}
		else{
			tbRow.next().toggle();	
		}
	}
	else{
		var container = $(this).closest('.inline-page');
		var loaded = container.attr('loaded');
		var page = container.find('.page-content');
		if(!loaded){
			container.attr('loaded', true);
			page.html(pageLoadingIndicator).load(dataURL, function(responseText, status, req){
				if(status == 'error'){
					container.removeAttr('loaded');
				}
			});
		}
		page.toggleClass('d-none');
	}
});
$(document).on('change', '.custom-file-input', function(){
	var fileName = $(this).val().split('\\').pop();
	$(this).siblings('.custom-file-label').addClass('selected').html(fileName);
});
/**
 * Refresh captcha image
*/
$(document).on('click', '[data-captcha]', function(e){
	var url = $(this).data("captcha");
	var img = $(this).find("img");
	img.attr("src", url + "?" + new Date().getTime());
});
/**
 * remove table row in a multi-table form
 */
$(document).on('click', '.btn-remove-table-row', function(e){
	var tableBody = $(this).closest('table').find("tbody");
	var rowCount = tableBody.find('tr.input-row:last').index() + 1
	var minRow = $(this).closest('table').data("minrow");
	if(rowCount > minRow){
		$(this).closest("tr.input-row").remove();
	}
});
/**
 * add new table row in a multi-table form
 */
$(document).on('click', '.btn-add-table-row', function(e){
	var tableBody = $(this).closest('table').find("tbody");
	var rowCount = tableBody.find('tr.input-row:last').index() + 1
	var maxRow = $(this).closest('table').data("maxrow");
	if(rowCount < maxRow){
		var templateId = $(this).data("template");
		var trTemplate = $(templateId).html();
		var nextRow = parseInt(rowCount) + 1;
		trTemplate = trTemplate.replace(/row1/ig, "row" +  nextRow);
		var trNew = $(trTemplate);
		tableBody.append(trNew);
	}
	initFormPlugins(); //rebind form plugin to the new controls
});
/**
 * check if a form is valid and set set form controls validity status 
 */
$(document).on('submit', 'form.needs-validation, form.multi-form', function(event){
	if(!validateForm($(this))){
		event.preventDefault();
		event.stopPropagation();
	}
});
/**
 * validate password confirmation
 */
$(document).on('input', '.password-confirm', function(event){
	var inputElem =  $(this)
	var value = inputElem.val();
	var match = $(inputElem.data("match")).val();
	if(value !== match){
		inputElem.removeClass('is-valid').addClass('is-invalid');
		inputElem[0].setCustomValidity("Password do not match");
	}
	else{
		inputElem.removeClass('is-invalid').addClass('is-valid');
		inputElem[0].setCustomValidity("");
	}
});
/**
 * validate password confirmation
 */
$(document).on('input', 'input.password', function(event){
	var inputElem =  $(this)
	var value = inputElem.val();
	var confirmPassword = inputElem.closest("form").find(".password-confirm");
	if(confirmPassword.length){
		var match = confirmPassword.val();
		if(value !== match){
			confirmPassword.removeClass('is-valid').addClass('is-invalid');
			confirmPassword[0].setCustomValidity("Password do not match");
		}
		else{
			confirmPassword.removeClass('is-invalid').addClass('is-valid');
			confirmPassword[0].setCustomValidity("");
		}
	}
});
/**
 * validate form fields and display validation feedback 
 */
function validateForm(formElem){
	formElem.addClass('was-validated');
	formElem.find("input:required:invalid").parents('.dropzone').css("borderColor", "red");
	formElem.find("input:required:invalid").parents('.custom-file').find('.custom-file-label').css("borderColor", "red");
	formElem.find("textarea:required:invalid").parents('.form-group,.input-row').find('.note-editor').css("borderColor", "red");
	var confirmPasswordElem = formElem.find("input.password-confirm");
	if(confirmPasswordElem.length){
		var value = confirmPasswordElem.val();
		var match = $(confirmPasswordElem.data("match")).val();
		if(value !== match){
			confirmPasswordElem.removeClass('is-valid').addClass('is-invalid');
			confirmPasswordElem[0].setCustomValidity("Password do not match");
		}
		else{
			confirmPasswordElem.removeClass('is-invalid').addClass('is-valid');
			confirmPasswordElem[0].setCustomValidity("");
		}
	}
	var form = formElem[0];
	if(!form.checkValidity()){
		return false
	}
	return true;
}
/**
 * submit a form using ajax
 */
$(document).on('click', '.ajax-page a.export-link-btn', function(e){
	var page = $(this).closest('.ajax-page');
	var format = $(this).data("format");
	var pageUrl = page.data('page-url');
	var url = new Url(pageUrl);
	url.query.format = format;
	var link = url.toString();
	$(this).attr("href", link);
});
/**
 * submit a form using ajax
 */
$(document).on('submit', '.ajax-page form.page-form', function(e){
	var formElem = $(this);
	if(validateForm(formElem)){
		var savingIndicator  = formElem.find('.form-ajax-status');
		savingIndicator.html(pageSavingIndicator);
		savingIndicator.show();
		$.ajax({
			url: formElem.attr('action'),
			type: formElem.attr('method'),
			data: formElem.serialize(),
			success: function(msg) {
				savingIndicator.hide();
				showToastSuccess(msg);
				var ajaxpage = formElem.closest('.ajax-page');
				var pageUrl = ajaxpage.data("page-url");
				loadPageData(ajaxpage, pageUrl);
				formElem.closest('.modal').modal('toggle'); //close the modal
				formElem[0].reset();
				formElem.removeClass('was-validated');
			},
			error: function( xhr, err ) {
				savingIndicator.hide();
				showToastDanger( xhr.statusText );
			}
		});
	}
	e.preventDefault();
	e.stopPropagation();
});
/**
 * submit a form using ajax and refresh the ajax-page
 */
$(document).on('submit', '#main-page-modal form.page-form', function(e){
	var formElem = $(this);
	if(validateForm(formElem)){
		var savingIndicator  = formElem.find('.form-ajax-status');
		savingIndicator.html(pageSavingIndicator);
		savingIndicator.show();
		$.ajax({
			url: formElem.attr('action'),
			type: formElem.attr('method'),
			data: formElem.serialize(),
			success: function(msg) {
				savingIndicator.hide();
				showToastSuccess(msg);
				var ajaxpage = formElem.closest('.modal').data('ajax-page');
				if(ajaxpage.length){
					var pageUrl = ajaxpage.data("page-url");
					loadPageData(ajaxpage, pageUrl);
					$('#main-page-modal').modal('hide');
				}
			},
			error: function( xhr, err ) {
				savingIndicator.hide();
				showToastDanger(xhr.statusText);
			}
		}); 
	}
	e.preventDefault();
	e.stopPropagation();
});
/**
 * open content in a modal view
 */
$(document).on('click', '.open-page-modal', function(e){
	e.preventDefault();
	var dataURL = $(this).attr('href');
	var modal = $(this).next('.modal');
	modal.modal({show:true});
	modal.find('.modal-body').html(pageLoadingIndicator).load(dataURL);
});
/**
 * open page in modal view
 */
$(document).on('click', 'a.page-modal', function(e){
	e.preventDefault();
	var dataURL = $(this).attr('href');
	var ajaxpage = $(this).closest('.ajax-page');
	var modal = $('#main-page-modal');
	modal.data('ajax-page', ajaxpage);
	modal.modal({show:true});
	modal.find('.modal-body').html(pageLoadingIndicator).load(dataURL, function(responseText, status, req){
		if(status == 'error'){
			$(this).html(responseText);
		}
	});
});
/**
 * check if value already exit in a database table for validation
 */
$(document).on('blur', '.ctrl-check-duplicate', function(){
	var inputElem = $(this)
	var val = inputElem.val();
	var apiUrl = inputElem.data("url");
	var elemCheckStatus = inputElem.closest('.form-group').find('.check-status');
	var loadingMsg = inputElem.data('loading-msg');
	var availableMsg = inputElem.data('available-msg');
	var notAvailableMsg = inputElem.data('unavailable-msg');
	elemCheckStatus.html('<small class="text-muted">' + loadingMsg + '</small>');
	if(val){
		$.ajax({
			url : setPathLink(apiUrl + val),
			success : function(result) {
				if(result == true) {
					inputElem.addClass('is-invalid');
					inputElem[0].setCustomValidity(notAvailableMsg);
					elemCheckStatus.html('<small class="text-danger">' + notAvailableMsg + '</small>');
				}
				else{ 
					inputElem.removeClass('is-invalid').addClass('is-valid');
					inputElem[0].setCustomValidity('');
					elemCheckStatus.html('<small class="text-success">' + availableMsg + '</small>');
				}
			},
			error : function(err) {
				elemCheckStatus.html('');
				console.log(err);
			}
		});
	}
	else{
		elemCheckStatus.html('');
		inputElem.removeClass('is-valid').removeClass('is-valid');
	}
});
/**
 * populate another select control when a control value changes
 */
$(document).on('change', '[data-load-select-options]', function(e){
	var elem = $(this);
	var elementType =  elem.prop('tagName').toLowerCase();
	var selectedVal = "";
	if(elementType == 'input'){
		var arrSelectedVals = [];
		elem.closest('.form-group, .input-row').find("input:checked").each(function(){
			arrSelectedVals.push(elem.val());
		});
		selectedVal = arrSelectedVals.toString();
	}
	else{
		selectedVal = elem.val().toString();
	}
	var targetFields =  elem.data('load-select-options');
	var arrFields = targetFields.split(",");
	arrFields.forEach(function(field){
		//if placed in a multiple table row, populate only the field in the same row
		var targetElem;
		var tableRow = elem.closest(".input-row");
		if(tableRow.length){
			targetElem = tableRow.find("select[id*=ctrl-" + field + "], input[id*=ctrl-" + field + "]");
		}
		else{
			targetElem = $("#ctrl-" + field);
		}
		var path = targetElem.data('load-path') + '/' + encodeURIComponent(selectedVal);
		targetElem.html('<option value="">Loading...</option>');
		var placeholder = targetElem.attr('placeholder') || 'Select a value...';
		$.ajax({
			type: 'GET',
			url: path,
			dataType: 'json',
			success: function(data){
				if(targetElem.hasClass('selectize')){
					targetElem.each(function() {
						if (this.selectize) {
							this.selectize.clear();
							this.selectize.clearOptions();
							for (var i = 0; i < data.length; i++) {
								this.selectize.addOption({value:data[i].value, text: data[i].label });
							}
						}
					}); 
				}
				else{
					var options = '<option value="">' + placeholder +  '</option>';
					for (var i = 0; i < data.length; i++) {
						options += '<option value="' + data[i].value + '">' + data[i].label + '</option>';
					}
					targetElem.html(options);
				}
			},
			error: function(data) {
				var options = '<option value="">' + placeholder +  '</option>';
				targetElem.html(options);
			},
		});
	})
});
/**
 * populate another input check/radio control when a control value changes
 */
$(document).on('change', '[data-load-check-options]', function(e){
	var elem = $(this);
	var elementType = elem.prop('tagName').toLowerCase();
	var selectedVal = "";
	if(elementType == 'input'){
		var arrSelectedVals = [];
		elem.closest('.form-group').find("input:checked").each(function(){
			arrSelectedVals.push(elem.val());
		});
		selectedVal = arrSelectedVals.toString();
	}
	else{
		selectedVal = elem.val().toString();
	}
	var targetFields =  elem.data('load-check-options');
	var arrFields = targetFields.split(",");
	arrFields.forEach(function(field){
		var targetOptionsHolder;
		var templateHtml = $("#" + field + "-option-template").html();
		//if placed in a multiple table row, populate only the field in the same row
		var tableRow = elem.closest(".input-row");
		if(tableRow.length){
			targetOptionsHolder = tableRow.find("#" + field + "-options-holder");
			var rowIndex = tableRow.index() + 1;
			//update input name to the current table row
			templateHtml = templateHtml.replace(/row1/ig, "row" + rowIndex);
		}
		else{
			targetOptionsHolder = $("#" + field + "-options-holder");
		}
		var path = targetOptionsHolder.data('load-path') + '/' + encodeURIComponent(selectedVal);
		targetOptionsHolder.html(inlineLoadingIndicator);
		$.ajax({
			type: 'GET',
			url: path,
			dataType: 'json',
			success: function (data){
				targetOptionsHolder.html("");
				for (var i = 0; i < data.length; i++) {
					var option = $(templateHtml);
					option.find('input').val(data[i].value);
					option.find('.input-label-text').html(data[i].label);
					targetOptionsHolder.append(option);
				}
			},
			error: function (data) {
				targetOptionsHolder.html('...');
			},
		});
	})
});
/**
 * for multi checkbox, validate if a value is checked
 */
$('.form-group').on("click",'input:checkbox',function(){          
	var name = $(this).attr('name');
	var checkElem = $('input[name="'+name+'"]:checked');
    var min = 1 //minumum number of boxes to be checked for this form-group
    if(checkElem.length < min){
        $('input[name="'+name+'"]').prop('required',true);
    }
    else{
        $('input[name="'+name+'"]').prop('required',false);
    }
});
/**
 * close ajax drop down search
 */
$(document).on('click', '.close-search', function(e){
	var parent = $(this).closest('.search-input');
	parent.find('.holder').hide();
});
$(document).on('keyup', 'input.ajax-dropdown-search', debounce(function(){
	var searchText = $(this).val();
	searchText = searchText.trim();
	var parent = $(this).closest('.search-input');
	if(searchText){
		var pageUrl = $(this).data('page');
		var url = new Url(pageUrl);
		url.query.search = searchText;
		parent.find('.holder').show();
		parent.find('.search-result').html(inlineLoadingIndicator).load(url.toString());
	}
	else{
		parent.find('.holder').hide();
	}
},500));
$(document).on('keyup', 'input.ajax-page-search', debounce(function(){
	var searchText = $(this).val();
	searchText = searchText.trim();
	var pageID = $(this).data('page-id');
	var pageDataHolder = $('#page-data-' + pageID);
	var pageSearchResultHolder = $('#search-data-' + pageID);
	if(searchText){
		var pageUrl = $(this).data('page');
		var url = new Url(pageUrl);
		url.query.search = searchText;
		pageSearchResultHolder.show();
		pageSearchResultHolder.html(inlineLoadingIndicator).load(url.toString());
		pageDataHolder.hide();
	}
	else{
		pageDataHolder.show();
		pageSearchResultHolder.hide();
	}
},500));
/**
 * toggle password visibility
 */
$(document).on('click', '.btn-toggle-password', function(){
	var input = $(this).closest(".form-group").find("input");
	var inputType = input.attr("type");
	if(inputType == "password"){
		input.attr("type", "text");
	}
	else{
		input.attr("type", "password");
	}
});
/**
 * replace failed images with better looking image
 */
$(window).bind('load', function(){
	$('img').each(function() {
		if((typeof this.naturalWidth != "undefined" && this.naturalWidth == 0 ) || this.readyState == 'uninitialized' ) {
			var noImgSrc = setPathLink('assets/images/no-image-available.png');
			$(this).attr('src', noImgSrc);
		}
	}); 
	}
);
/**
 * ajax page navigation
 */
$(document).on('submit', 'form.ajax-pagination-form', function(event){
	var formdata = getFormData($(this));
	var currentPage =  parseInt(formdata.limit_start);
	var limitCount = parseInt(formdata.limit_count);
	if(currentPage && limitCount){
		var pager = $(this).find(".ajax-pagination");
		var totalRecords = parseInt(pager.data("total-records"));
		var recordPosition = Math.min((currentPage * limitCount), totalRecords);
		var newTotalPage = Math.ceil(totalRecords / limitCount);
		var page = $(this).closest(".ajax-page");
		var pageUrl = page.data("page-url");
		var url = new Url(pageUrl);
		url.query.limit_start = currentPage;
		url.query.limit_count = limitCount;
		var path = url.toString();
		page.data("page-url", path); //update page link
		pager.twbsPagination("changeTotalPages", newTotalPage, currentPage); //load page
		$(this).find(".record-position").html(recordPosition);
		$(this).find(".total-page").html(newTotalPage);
		var pageOptions = "";
		for(var i = 1; i <= newTotalPage; i++){
			pageOptions = pageOptions + '<option value="'+ i +'">' + i + '</option>';
		}
		$(this).find(".page-num").html(pageOptions);
		$(this).find(".page-num").val(currentPage);
	}
	event.preventDefault();
});
/**
 * ajax list page filter
 */
$(document).on('submit', '.ajax-page form.filter-form', function(event){
	var formdata = getFormData($(this));
	var page = $(this).closest(".ajax-page");
	var pageUrl = $(this).attr("action");
	var url = new Url(pageUrl);
	extend(url.query, formdata);
	var filterUrl = url.toString();
	loadPageData(page, filterUrl);
	page.data("page-url", filterUrl); //update page link
	event.preventDefault();
});
/**
 * ajax sort table header
 */
$(document).on('click', '.ajax-page .th-sort-link', function(event){
	var page = $(this).closest(".ajax-page");
	var pageUrl = page.data("page-url");
	var url = new Url(pageUrl);
	var orderby = $(this).data("orderby");
	var ordertype = (page.data("ordertype") || "").toLowerCase();
	ordertype = (ordertype == "asc" ? "desc" : "asc");
	url.query.orderby = orderby;
	url.query.ordertype = ordertype;
	url.query.limit_start = 1;
	page.data("ordertype", ordertype);
	page.find("a.th-sort-link").closest("th").removeClass("sortedby");
	$(this).closest("th").addClass("sortedby");
	if(ordertype === "desc"){
		$(this).parent().find(".sort-icon").addClass("inverse")
	}
	else{
		$(this).parent().find(".sort-icon").removeClass("inverse")
	}
	var path = url.toString();
	page.data("page-url", path); //update page link
	var pager = page.find(".ajax-pagination");
	pager.twbsPagination("show", 1); //load page
	event.preventDefault();
});
var scrollLoad = true;
/**
 * Infinite page load. Append to page list instead of replacing it.
 */
function appendPageData(ajaxPage){
	var pageUrl = ajaxPage.data("page-url");
	var loading;
	var url = new Url(pageUrl);
	var currentPage = parseInt(url.query.limit_start) || 1;
	url.query.limit_start = currentPage + 1;
	var pageUrl = url.toString();
	if(ajaxPage.data("display-type") == "table"){//if page type is tabular
		loading = $('<tr class=""><td class="text-center p-3" colspan="100">' + inlineLoadingIndicator + '</td></tr>');
	}
	else{
		loading = $('<div class="text-center p-3 col-12">' + inlineLoadingIndicator + '</div>');
	}
	var pageBody = ajaxPage.find("table tbody .page-data, .page-content .page-data").first()
	if(pageBody.find('.no-record-found').length === 0){	
		pageBody.append(loading);
		$.ajax({
			url: pageUrl,
			success : function(result) {
				scrollLoad = true;
				ajaxPage.data("load-completed", true);
				pageBody.append(result);
				loading.remove();
			},
			error : function(err) {
				scrollLoad = true;
				loading.remove();
			}
		});
		ajaxPage.data("page-url", pageUrl); //update page link
	}
	else{
		scrollLoad = true;
	}
}
/**
 * infinite load more button
 */
$(document).on('click', '.ajax-page .btn-load-more', function(event){
	var ajaxPage = $(this).closest(".ajax-page");
	appendPageData(ajaxPage)
});
/**
 * perform infinite page load records on window scroll
 */
$(window).scroll(function () { 
	if (scrollLoad && $(window).scrollTop() >= $(document).height() - $(window).height() - 100) {
		scrollLoad = false; //prevent multiple loads
		var ajaxPage = $('.ajax-page.infinite-scroll').first();
		appendPageData(ajaxPage);
	}
});
/**
 * perform infinite page load records on page scroll. 
 * Page must have height and overflow:auto|scroll css properties
 */
$('.ajax-page.infinite-scroll').bind('scroll', function(){
	if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
		scrollLoad = false;//prevent multiple load
		var ajaxPage = $(this);
		appendPageData(ajaxPage);
	}
});
$(document).ready(function () {
	var navTopHeight = $('#topbar').outerHeight();
	document.body.style.paddingTop = navTopHeight + 'px';
	$('#sidebar').css('top', navTopHeight);
	$('#sidebar').css('height', 'calc(100vh - ' +  navTopHeight + ')');
	var state = sessionStorage.getItem("sidebar");
	if (state) {
		$('#sidebar, #main-content').addClass('active');
	} else {      	
		$('#sidebar, #main-content').removeClass('active');
	}
	$('#sidebarCollapse').on('click', function () {
		$('#sidebar, #main-content').toggleClass('active');
		if($('#sidebar').hasClass("active")){
			sessionStorage.setItem("sidebar", state);
		}
		else{
			sessionStorage.removeItem("sidebar");
		}
	});
});
/*
* Custom Javascript | Jquery codes
*/
$(document).ready(function() {
});
