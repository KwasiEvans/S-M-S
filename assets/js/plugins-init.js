Dropzone.autoDiscover = false;
function initFormPlugins(){
	$('textarea.htmleditor').each(function(){
		var editor = $(this);
		var numRows = parseInt(editor.attr("rows")) || 4;
		var height = numRows * 25;
		editor.summernote({
		dialogsInBody: true,
			callbacks: {
				onImageUpload: function(files) {
					for(let i=0; i < files.length; i++) {
						ajaxUploadFile(files[i]);
					}
				}
			},
			height: height,
		});
		// upload file
		function ajaxUploadFile(file) {
			data = new FormData();
			data.append("file", file);
			data.append("fieldname", "summernote_img_upload");
			data.append("csrf_token", csrfToken);
			$(".ajax-progress-bar").fadeIn();
			$.ajax({
				data: data,
				type: 'POST',
				xhr: function () {
					var myXhr = $.ajaxSettings.xhr();
					if (myXhr.upload) myXhr.upload.addEventListener('progress', ajaxUploadingEventFunction, false);
					return myXhr;
				},
				url: siteAddr + "filehelper/uploadfile",
				cache: false,
				contentType: false,
				processData: false,
				success: function (url) {
					var image = $('<img>').attr('src', setPathLink(url));
					editor.summernote("insertNode", image[0]);
				}
			});
		}
		// update progress bar
		function ajaxUploadingEventFunction(e) {
			if (e.lengthComputable) {
				var percentComplete = (e.loaded / e.total) * 100;
				var progressBar = $(".ajax-progress-bar").find(".progress-bar")
				progressBar.css("width", percentComplete + "%")
				// reset progress on complete
				if (e.loaded == e.total) {
					progressBar.css("width", "0");
					$(".ajax-progress-bar").fadeOut();
				}
			}
		}
	});
	$('.datepicker').flatpickr({
		altInput: true, 
		allowInput:true,
		onReady: function(dateObj, dateStr, instance) {
			var $cal = $(instance.calendarContainer);
			if ($cal.find('.flatpickr-clear').length < 1) {
				$cal.append('<button class="btn btn-light my-2 flatpickr-clear">Clear</button>');
				$cal.find('.flatpickr-clear').on('click', function() {
					instance.clear();
					instance.close();
				});
			}
		},
		locale: {
			rangeSeparator: '-to-'
		}
	});
	Dropzone.autoDiscover = false;
	$('.dropzone').each(function(){
		let dropzoneControl = $(this)[0].dropzone;
		if (dropzoneControl) {
			dropzoneControl.destroy();
		}
		var uploadUrl = $(this).attr('path') || setPathLink('filehelper/uploadfile/');
		var multiple = $(this).data('multiple') || false;
		var limit = $(this).attr('maximum') || 1;
		var size = $(this).attr('filesize') || 10;
		var extensions = $(this).attr('extensions') || "";
		var resizewidth = $(this).attr('resizewidth') || null;
		var resizeheight = $(this).attr('resizeheight') || null;
		var resizequality = $(this).attr('resizequality') || null;
		var resizemethod = $(this).attr('resizemethod') || null;
		var resizemimetype = $(this).attr('resizemimetype') || null;
		var dropmsg = $(this).attr('dropmsg') || 'Choose files or drag and drop files to upload';
		var autoSubmit = $(this).attr('autosubmit') || true;
		var btntext = $(this).attr('btntext') || 'Choose file';
		var fieldname = $(this).attr('fieldname') || "";
		var input = $(this).attr('input');
		$(this).dropzone({
			url: uploadUrl ,
			maxFilesize:size,
			uploadMultiple: multiple,
			parallelUploads:1,
			paramName:'file',
			maxFiles:limit,
			resizeWidth: resizewidth,
			resizeHeight: resizeheight,
			resizeQuality: resizequality,
			resizeMethod: resizemethod,
			resizeMimeType: resizemimetype,
			acceptedFiles: extensions,
			addRemoveLinks:true,
			params:{
				csrf_token : csrfToken,
				fieldname : fieldname,
			},
			init: function() {
				this.on('addedfile', function(file) {
					//if allow multiple file upload is allowed, then validate maximum number of files
					var inputFiles = $(input).val();
					var inputFilesLen = 0;
					if(inputFiles){
						inputFilesLen = inputFiles.split(',').length;
					}
					var totalFiles = this.files.length + inputFilesLen;
					if ( totalFiles  > limit) {
						if(multiple){
							$(file.previewElement).closest('.dropzone').find('.dz-file-limit').text('Maximum upload limit reached');
							this.removeFile(file);
						}
						else if(limit == 1){
							if(!inputFiles){
								this.removeFile(this.files[0]);
							}
						}
					}
				});
				this.on("success", function(file, responseText) {
					if(responseText){
						if(limit == 1){
							$(input).val(responseText);
						}
						else{
							var files = $(input).val();
							files = files + ',' + responseText;
							files = files.trim().trimLeft(',')
							$(input).val(files);
						}
					}
				});
				this.on("removedfile", function(file) {
					if(file.xhr){
						var filename = file.xhr.responseText;
						var files = $(input).val();
						var arrFiles = files.split(',');
						while (arrFiles.indexOf(filename) !== -1) {
							arrFiles.splice(arrFiles.indexOf(filename), 1);
						}
						$(input).val(arrFiles.toString());
						var remUrl = setPathLink('filehelper/removefile/')
						$.ajax({
							type:'POST',
							url: remUrl,
							data : {filepath: filename, csrf_token: csrfToken},
							success : function (data) {
								console.log(data);
							}
						});
					}
					var inputFiles = $(input).val();
					if(inputFiles){
						var inputFilesLen = inputFiles.split(',').length;
						if (  limit > inputFilesLen){
							$(input).closest('.dropzone').find('.dz-file-limit').text('');
						}
					}
				});
				this.on("complete", function (file) {
					//do something all files uploaded
				});
			},
			dictDefaultMessage: dropmsg,
			/* dictRemoveFile:'' */
		});
	});
}
function loadPageData(ajaxPage, url){
	let pageType = ajaxPage.data('page-type');
	if(pageType == "list"){
		ajaxPage.find(".ajax-page-load-indicator").first().show();
		ajaxPage.find("table,.page-content").first().addClass("loading");
		ajaxPage.find("table tbody .page-data,.page-content .page-data").first().load(url, function(){
			ajaxPage.find("table,.page-content").first().removeClass("loading");
			ajaxPage.find(".ajax-page-load-indicator").first().hide();
		});
	}
	else{
		ajaxPage.find(".ajax-page-load-indicator").first().show();
		ajaxPage.find("table,.page-content").first().addClass("loading");
		ajaxPage.load(url);
	}
}
$(function() {
	initFormPlugins()
	$('.ajax-pagination').each(function(){
		var pager = $(this);
		var totalPage = parseInt(pager.data("total-page")) || 1;
		var range = parseInt(pager.data("range")) || 5;
		var page = pager.closest(".ajax-page");
		pager.twbsPagination({
			paginationClass: 'pagination pagination-sm',
			totalPages: totalPage,
			visiblePages: range,
			initiateStartPageClick: false,
			first: '<i class="material-icons">first_page</i>',
			prev: '<i class="material-icons">arrow_back</i>',
			next: '<i class="material-icons">arrow_forward</i>',
			last: '<i class="material-icons">last_page</i>',
			onPageClick: function (event, pageNum) {
				var pageUrl = page.data("page-url");
				var url = new Url(pageUrl);
				url.query.limit_start = pageNum; // adds or replaces the param
				var path = url.toString();
				loadPageData(page, path);
				page.data("page-url", path); //update page link
				pager.closest("form").find(".page-num").val(pageNum);
				var totalRecords = parseInt(pager.data("total-records"));
				var limitCount = parseInt(pager.data("limit-count"));
				var recordPosition = Math.min((pageNum * limitCount), totalRecords);
				pager.closest("form").find(".record-position").html(recordPosition);
			}
		}).on('page', function (event, pageNum) {
		});;
	});
	$('.has-tooltip').tooltip();
	$('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
	$(".switch-checkbox").bootstrapSwitch();
	$('input.password-strength').passwordStrength();
	/**
	 * Ajax load popover content
	 */
	$('.open-page-popover').popover({
		title : '<div class="clearfix"><a class="close" data-dismiss="alert">&times;</a></div>',
		template: '<div class="popover inline-page" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
		html: true,
		container: 'body',
		content: function(){
			var divID =  "tmp-id-" + $.now();
			var link = $(this).attr('href')
			$.ajax({
				url: link,
				success: function(response){
					$('#' + divID).html(response);
				}
			});
			return '<div class="reset-grids" id="'+ divID +'">' + pageLoadingIndicator + '</div>';// + footer;
		}
	});
	$.fn.editableform.buttons = '<button type="submit" class="btn btn-sm btn-primary editable-submit">&check;</button><button type="button" class="btn btn-sm btn-secondary editable-cancel">&times;</button>';
	$.fn.editable.defaults.ajaxOptions = {type: "post"};
	$.fn.editable.defaults.params = {csrf_token : csrfToken};
	$.fn.editable.defaults.emptytext = '...';
	$.fn.editable.defaults.textFieldName = 'label';
	$('.is-editable').editable();
	$(document).on('click', '.inline-edit-btn', function(e){
		e.stopPropagation();
		$(this).closest('td').find('.make-editable').editable('toggle');
	});
});
