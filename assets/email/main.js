$(function() {
	
	
	$("#promail").sortable({
		revert: "true",
		axis: "y"
	});
	
	$( ".collapse-menu" ).accordion({ active: false, collapsible : true });
	
	$(".sidebar").mCustomScrollbar({
		setWidth: 230,
		autoHideScrollbar: true,
		mouseWheelPixels: 100
	});


	$(".color-btn").click(function(e) {
		e.preventDefault();
		$(".second").animate({
			"left": "0"
		}, 400);
	});
	
	$(".layout-btn").click(function(e) {
		e.preventDefault();
		$(".third").animate({
			"left": "0"
		}, 400);
	});
	
	$(".back-btn").click(function(e) {
		e.preventDefault();
		$(".second").animate({
			"left": "-240"
		}, 300);
		$(".third").animate({
			"left": "-240"
		}, 300);
	});
	
	$(".iphone-device").on("click", function(e) {
		e.preventDefault();
		$(".email-body").animate({
			"width": "320px"
		}, 400);
		setTimeout(function() {
			resizeIframe();
		}, 500);
	});
	
	$(".ipad-device").on("click", function(e) {
		e.preventDefault();
		$(".email-body").animate({
			"width": "480px",
			marginLeft: "auto",
			marginLeft: "auto"
		}, 400);
		setTimeout(function() {
			resizeIframe();
		}, 500);
	});
	
	$(".screen-device").on("click", function(e) {
		e.preventDefault();
		$(".email-body").animate({
			"width": "800px"
		}, 400);
		setTimeout(function() {
			resizeIframe();
		}, 500);
	});
	
	$(".reset-change").on("click", function(e) {
		e.preventDefault();
		location.reload();
	});
	
	$("#emailframe").load(function() {
		
		resizeIframe();
		
		var current_image;
		
		$('.loading').fadeOut();
		
		$($("#emailframe").contents().find('.action-btn')).hide();
		
		/*
		$($("#emailframe").contents().find('#promail li')).on({
			mouseenter: function() {
				$(this).find('.action-btn').fadeIn();
			},
			mouseleave: function() {
				$(this).find('.action-btn').fadeOut();
			}
		});
		*/
		
		
		$($("#emailframe").contents().find('body')).on("mouseover", '#promail li', function(e) {
			$(this).find('.action-btn').fadeIn();
		});
		
		$($("#emailframe").contents().find('body')).on("mouseleave", '#promail li', function(e) {
			$(this).find('.action-btn').fadeOut();
		});
		
		$($("#emailframe").contents().find('body')).on("click", '.add-section', function(e) {
			e.preventDefault();
			$($("#emailframe").contents().find('.action-btn')).hide();
			$(this).parent().parent().after("<li>" + $(this).parent().parent().html() + "</li>");
			setTimeout(function() {
				resizeIframe();
			}, 500);
		});
		
		$($("#emailframe").contents().find('body')).on("click", '.remove-section', function(e) {
			e.preventDefault();
			$(this).parent().parent().remove();
			setTimeout(function() {
				resizeIframe();
			}, 500);
		});
		
		/*
		$($("#emailframe").contents().find('#promail .editable_text')).on({
			mouseenter: function() {
				$(this).wrap("<div class='test'></div>");
				$("#emailframe").contents().find('.test .editable_text').append("<a class='icon' href='#text-edit' rel='modal:open'><img src='../img/image-edit.png' /></a>");
			},
			mouseleave: function() {
				$("#emailframe").contents().find('.icon').remove();
				$(this).unwrap(".test");
			}
		});
		*/
		
		/* ---  text edit mouseover --- */
		$($("#emailframe").contents().find('body')).on("mouseenter", '#promail .editable_text', function(e) {
		
			$(this).wrap("<div class='test'></div>");
			
			$("#emailframe").contents().find('.test .editable_text').append("<a class='icon' href='#text-edit' rel='modal:open'><img src='../demo/img/image-edit.png' /></a>");
				
		}).on("mouseleave", '#promail .editable_text', function(e) {
			
			$(this).find('.icon').remove();
			
			$(this).unwrap(".test");
			
		});
		
		/*
		$($("#emailframe").contents().find('#promail .editable_img')).on({
			mouseenter: function() {
				$(this).wrap("<div class='test'></div>");
				$("#emailframe").contents().find('.test .editable_img').append("<a class='icon' href='#image-edit' rel='modal:open'><img src='../img/image-edit.png' /></a>");
			},
			mouseleave: function() {
				$("#emailframe").contents().find('.icon').remove();
				$(this).unwrap(".test");
			}
		});
		*/
		
		
		/* ---  image edit mouseover --- */
		$($("#emailframe").contents().find('body')).on("mouseenter", '#promail .editable_img', function(e) {
			
			$(this).wrap("<div class='test'></div>");
			
			$("#emailframe").contents().find('.test .editable_img').append("<a class='icon' href='#image-edit' rel='modal:open'><img src='../demo/img/image-edit.png' /></a>");
				
		}).on("mouseleave", '#promail .editable_img', function(e) {
			
			$("#emailframe").contents().find('.icon').remove();
			$(this).unwrap(".test");
				
		});
		
		/* --- */
		
		
		/* ---  image edit popup --- */
		$($("#emailframe").contents().find('body')).on("click", 'a[href="#image-edit"]', function(e) {
			e.preventDefault();
			$(this).parent().parent().find('img:first').addClass("current_image");
			$(".img_size").text($(this).parent().parent().find('img:first').width() + "px x " + " Any height");
			$("#image_src").val($(this).parent().parent().find('img:first').attr("src"));
			$(this).modal({
				fadeDuration: 250,
				clickClose: false,
				showClose: false,
				clickClose: true
			});
		});
		
		/* ---  text edit popup --- */
		$($("#emailframe").contents().find('body')).on("click", 'a[href="#text-edit"]', function(e) {
			e.preventDefault();
			$(this).parent().addClass("current_text");
			html = $(this).parent().find('.text_container').html();
			$("#texteditor").val(html);
			$(this).modal({
				fadeDuration: 250,
				clickClose: false,
				showClose: false,
				clickClose: true
			});
		});
		
		$($("#emailframe").contents().find('body')).on("click", 'a', function(e) {
			e.preventDefault();
		});	
		
	});
	
	$('#image-edit').on($.modal.CLOSE, function(event, modal) {
		$("#emailframe").contents().find('.current_image').removeClass("current_image");
	});
	
	$('#text-edit').on($.modal.CLOSE, function(event, modal) {
		$("#emailframe").contents().find('.current_text').removeClass("current_text");
	});
	
	function resizeIframe() {
		var iframe_content = $("#emailframe").contents().find('body');
		$("#emailframe").css({
			height: iframe_content.outerHeight(true)
		});
		iframe_content.resize(function() {
			var elem = $(this);
			$("#emailframe").css({
				height: elem.outerHeight(true)
			});
		});
	}
	
	$("#image_src").on("keyup", function() {
		$("#img_preview").attr("src", $("#image_src").val());
	});
	
	$(".save_img").on("click", function(e) {
		e.preventDefault();
		$("#emailframe").contents().find('.current_image').attr("src", $("#image_src").val());
		$("#emailframe").contents().find('.current_image').parent().attr("href", $("#image_link").val());
		$("#emailframe").contents().find('.current_image').removeClass("current_image");
		$.modal.close();
	});
	
	$(".save_text").on("click", function(e) {
		e.preventDefault();
		$("#emailframe").contents().find('.current_text .text_container').html($("#texteditor").val());
		$("#emailframe").contents().find('.current_text').removeClass("current_text");
		$.modal.close();
	});
	
	$("#colorpicker").spectrum({
		color: "#18c197",
		showInput: true,
		cancelText: "cancel",
		chooseText: "select",
		move: function(color) {
			updateMainColor(color);
		},
		change: function(color) {
			updateMainColor(color);
		}
	});
	
	function updateMainColor(color) {
		$($("#emailframe").contents().find('.main_color')).css("background-color", color.toHexString());
		$($("#emailframe").contents().find('.link_color')).css("color", color.toHexString());
	}
	
	$("#colorpicker2").spectrum({
		color: "#102b36",
		showInput: true,
		cancelText: "cancel",
		chooseText: "select",
		move: function(color) {
			updateTitleColor(color);
		},
		change: function(color) {
			updateTitleColor(color);
		}
	});
	
	function updateTitleColor(color) {
		$($("#emailframe").contents().find('.title_color')).css("color", color.toHexString());
	}
	
	$("#colorpicker3").spectrum({
		color: "#8b8b8b",
		showInput: true,
		cancelText: "cancel",
		chooseText: "select",
		move: function(color) {
			updateTextColor(color);
		},
		change: function(color) {
			updateTextColor(color);
		}
	});
	function updateTextColor(color) {
		$($("#emailframe").contents().find('.text_color')).css("color", color.toHexString());
	}
		
	$("#colorpicker6").spectrum({
		color: "#ffffff",
		showInput: true,
		cancelText: "cancel",
		chooseText: "select",
		move: function(color) {
			updateText2Color(color);
		},
		change: function(color) {
			updateText2Color(color);
		}
	});
	function updateText2Color(color) {
		$($("#emailframe").contents().find('.text2_color')).css("color", color.toHexString());
	}
	
	$("#colorpicker5").spectrum({
		color: "#ffffff",
		showInput: true,
		cancelText: "cancel",
		chooseText: "select",
		move: function(color) {
			updateBgColor(color);
		},
		change: function(color) {
			updateBgColor(color);
		}
	});
	function updateBgColor(color) {
		$($("#emailframe").contents().find('.bg_color')).css("background-color", color.toHexString());
	}
	
	$("#colorpicker4").spectrum({
		color: "#12b28a",
		showInput: true,
		cancelText: "cancel",
		chooseText: "select",
		move: function(color) {
			updateBg2Color(color);
		},
		change: function(color) {
			updateBg2Color(color);
		}
	});
	function updateBg2Color(color) {
		$($("#emailframe").contents().find('.bg2_color')).css("background-color", color.toHexString());
	}
		
	$(".get_bg").on("keyup", function() {
		changeBg($(this));
	});
	function changeBg(current) {
		var bg = current.val();
		if (bg != "") {
			$.browser.chrome = /chrom(e|ium)/.test(navigator.userAgent.toLowerCase());
			var is_chrome = navigator.userAgent.indexOf('Chrome') > -1;
			var is_explorer = navigator.userAgent.indexOf('MSIE') > -1;
			var is_firefox = navigator.userAgent.indexOf('Firefox') > -1;
			var is_safari = navigator.userAgent.indexOf("Safari") > -1;
			var is_Opera = navigator.userAgent.indexOf("Presto") > -1;
			if ((is_chrome) && (is_safari)) {
				is_safari = false;
			}
			if (is_firefox) {
				$($("#emailframe").contents().find("." + current.attr("name") + "")).css("background-image", ("url(" + bg + ")").replace(/("|')?\)$/, ""));
			} else {
				$($("#emailframe").contents().find("." + current.attr("name") + "")).css("background-image", "url(" + bg + ")");
			}
		}
	}
	
	$('#texteditor').ckeditor({
		toolbar: [
			['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
			['-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
			['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
			['UIColor'],
			['Styles', 'Format', 'Font', 'FontSize', '-', 'TextColor', 'BGColor'],
			['Source']
		],
		uiColor: '#FAFAFA',
		enterMode: CKEDITOR.ENTER_BR,
		shiftEnterMode: CKEDITOR.ENTER_P
	});
});