function GetQueryStringParams() {
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++) {
		var sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] == "ct" && sParameterName[1] == "Governance") {
			$('ul#tabs-swipe-demo a[href="#elecpoll"]').trigger('click');
		}
		if (sParameterName[0] == "ct" && sParameterName[1] == "Money") {
			$('ul#tabs-swipe-demo a[href="#stockpoll"]').trigger('click');
		}
		if (sParameterName[0] == "ct" && sParameterName[1] == "Sports") {
			$('ul#tabs-swipe-demo a[href="#sportpoll"]').trigger('click');
		}
		if (sParameterName[0] == "ct" && sParameterName[1] == "Entertainment") {
			$('ul#tabs-swipe-demo a[href="#moviepoll"]').trigger('click');
		}
	}
}

$(function () {

    if (typeof sideNav != 'undefined' && $.isFunction(sideNav)) {
        $('.button-collapse').sideNav();
    }
    if (typeof parallax != 'undefined' && $.isFunction(parallax)) {
        $('.parallax').parallax();
    }
	
	//$('.modal').modal();
	$('.tooltipped').tooltip({
		delay: 50
	});
	$('.winners-list').marquee({
		//speed in milliseconds of the marquee
		duration: 8000,
		gap: 0
	});
	$(document).on('click', '.mobile-submenu-item', function () {
		$(this).closest('li').find('.mobile-submenu').slideToggle()
	});
	$(document).on('click', '.mobile-submenu-live-item', function () {
		$(this).closest('li').find('.mobile-submenu-live').slideToggle()
	});
	$(".your-ranking").on('click', function (e) {
		e.preventDefault();
		Materialize.Toast.removeAll();
		Materialize.toast('Ranking will be released after results are announced!', 4000);
	});
	$("html, body").animate({
		scrollTop: 0
	}, "slow");

    if (typeof material_select != 'undefined' && $.isFunction(material_select)) {
        $('select').material_select();
    }
	//initialize materilize select
	
	GetQueryStringParams();
	if (typeof $.fn.datepicker == 'function')
		$('[data-toggle="datepicker"]').datepicker({
			format: 'dd-mm-yyyy',
			autoHide: true,
			startDate: new Date(),
		});
    
    
	// $('#testimonial_slider').slick({
	// 	autoplay: true,
	// 	autoplaySpeed: 5000,
	// 	centerMode: true,
	// 	slidesToShow: 1,
	// 	slidesToScroll: 1,
	// 	dots: true,
	// 	customPaging: function (slider, i) {
	// 		return '<label for="slide_2_1"></label>';
	// 	},
	// 	centerMode: false,
	// 	prevArrow: false,
	// 	nextArrow: false,
	// 	responsive: [{
	// 			breakpoint: 768,
	// 			settings: {
	// 				arrows: true,
	// 				centerMode: true,
	// 				centerPadding: '40px',
	// 				slidesToShow: 1
	// 			}
	// 		}, {
	// 			breakpoint: 480,
	// 			settings: {
	// 				arrows: true,
	// 				centerMode: true,
	// 				centerPadding: '40px',
	// 				slidesToShow: 1
	// 			}
	// 		}, {
	// 			breakpoint: 1024,
	// 			settings: {
	// 				arrows: true,
	// 				centerMode: true,
	// 				centerPadding: '40PX',
	// 				slidesToShow: 1
	// 			}
	// 		}, {
	// 			breakpoint: 1366,
	// 			settings: {
	// 				arrows: true,
	// 				centerMode: true,
	// 				centerPadding: '40PX',
	// 				slidesToShow: 1
	// 			}
	// 		}

	// 	]
	// })

	//initialize slick slider
	// $('#slickslider').slick({
	// 	autoplay: true,
	// 	autoplaySpeed: 10000,
	// 	centerMode: true,
	// 	slidesToShow: 4,
	// 	slidesToScroll: 1,
	// 	responsive: [{
	// 			breakpoint: 768,
	// 			settings: {
	// 				arrows: true,
	// 				centerMode: true,
	// 				centerPadding: '40px',
	// 				slidesToShow: 1
	// 			}
	// 		}, {
	// 			breakpoint: 480,
	// 			settings: {
	// 				arrows: true,
	// 				centerMode: true,
	// 				centerPadding: '40px',
	// 				slidesToShow: 1
	// 			}
	// 		}, {
	// 			breakpoint: 1024,
	// 			settings: {
	// 				arrows: true,
	// 				centerMode: true,
	// 				centerPadding: '40PX',
	// 				slidesToShow: 2
	// 			}
	// 		}, {
	// 			breakpoint: 1366,
	// 			settings: {
	// 				arrows: true,
	// 				centerMode: true,
	// 				centerPadding: '40PX',
	// 				slidesToShow: 3
	// 			}
	// 		}

	// 	]
	// });
    if (typeof matchHeight != 'undefined' && $.isFunction(matchHeight)) {
        $('.equal-height').matchHeight();
        $('.equal-height-child').matchHeight();
    }

	$('.progressforumcir').each(function (event) {
		var forumid = $(this).attr('data-formid');
		var data_per = $(this).attr('data-per');
		var type = $(this).attr('data-btntype');
		var tabname = $(this).attr('data-tabname');
		var percent = data_per;
		if (type == "like") {
			color = '#27ce71';
		} else if (type == "neutral") {
			color = '#00b6ff';
		} else {
			color = '#ff5f4e';
		}
		var bar = new ProgressBar.Circle("#contain" + type + "" + forumid + "" + tabname, {
			strokeWidth: 6,
			easing: 'easeInOut',
			duration: 1400,
			color: color,
			trailColor: '#eee',
			trailWidth: 6,
			svgStyle: null,
			text: {
				value: '<b class="blueblack-txt">' + percent + '%</b><h6 class="fs9px m-0">' + type + '</h6>',
				color: color,
				className: 'progressbar__label',
				autoStyle: true
			}
		});
		bar.animate(data_per / 100);
	});
	//    function onReady(callback) {
	//        //$('#forumdetailpage').css('opacity','0.4');
	//        var intervalId = window.setInterval(function () {
	//            if (document.getElementsByTagName('body')[0] !== undefined) {
	//                window.clearInterval(intervalId);
	//                callback.call(this);
	//            }
	//        }, 1000);
	//    }

	//function setVisible(selector, visible) {
	//        if (selector == ".forumpages") {
	//            $('#forumdetailpage').css('opacity', '0.4');
	//        } else {
	//            $('#forumdetailpage').css('opacity', '1');
	//        }
	//
	//        if (visible)
	//            $(selector).css('display', 'block');
	//        else
	//            $(selector).css('display', 'none');
	//    }
	//
	//    onReady(function () {
	//        setVisible('.forumpages', true);
	//      //  setVisible('.loadersmall', false);
	//    });
	//    

	if (typeof Dropzone == 'function')
		Dropzone.options.postforum = {
			maxFiles: 1,
			addRemoveLinks: true,
			maxfilesexceeded: function (file) {
				this.removeAllFiles();
				this.addFile(file);

			},
			thumbnail: function (file, dataUrl) {
				var _this = this;
				$("#imgPrime").attr("src", dataUrl);
				$('#imgPrime').css('display', 'block');
				$('.dz-preview').remove();
				$('#removethumb').css('display', 'block');

				document.getElementById('removethumb').addEventListener('click', function () {
					_this.removeAllFiles();
					$("#imgPrime").attr("src", '');
					$('#imgPrime').css('display', 'none');
					$('#removethumb').css('display', 'none');
				});
			},
			accept: function (file, done) {
				var reader = new FileReader();
				reader.onload = handleReaderLoad;
				reader.readAsDataURL(file);

				function handleReaderLoad(e) {
					var filePayload = e.target.result;
					$('#cwimg').val(filePayload)
				}
				done();
			}
		};

});


//if ('serviceWorker' in navigator) {
//  navigator.serviceWorker.register('/sw.js',{scope: './'})
//  .then(function(registration) {
//    console.log('Registration successful, scope is:', registration.scope);
//  })
//  .catch(function(error) {
//    console.log('Service worker registration failed, error:', error);
//  });
//}
