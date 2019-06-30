/*=========================================================
BOOTSTRAP SCRIPT
===========================================================*/

(function ($) {
	"use strict"

	// Fixed Nav
	var lastScrollTop = 0;
	$(window).on('scroll', function () {
		var wScroll = $(this).scrollTop();
		if (wScroll > $('#nav').height()) {
			if (wScroll < lastScrollTop) {
				$('#nav-fixed').removeClass('slide-up').addClass('slide-down');
			} else {
				$('#nav-fixed').removeClass('slide-down').addClass('slide-up');
			}
		}
		lastScrollTop = wScroll
	});

	// Search Nav
	$('.search-btn').on('click', function () {
		$('.search-form').addClass('active');
	});

	$('.search-close').on('click', function () {
		$('.search-form').removeClass('active');
	});

	// Aside Nav
	$(document).click(function (event) {
		if (!$(event.target).closest($('#nav-aside')).length) {
			if ($('#nav-aside').hasClass('active')) {
				$('#nav-aside').removeClass('active');
				$('#nav').removeClass('shadow-active');
			} else {
				if ($(event.target).closest('.aside-btn').length) {
					$('#nav-aside').addClass('active');
					$('#nav').addClass('shadow-active');
				}
			}
		}
	});

	$('.nav-aside-close').on('click', function () {
		$('#nav-aside').removeClass('active');
		$('#nav').removeClass('shadow-active');
	});

	// Sticky Shares
	var $shares = $('.sticky-container .sticky-shares'),
		$sharesHeight = $shares.height(),
		$sharesTop,
		$sharesCon = $('.sticky-container'),
		$sharesConTop,
		$sharesConleft,
		$sharesConHeight,
		$sharesConBottom,
		$offsetTop = 80;

	function setStickyPos() {
		if ($shares.length > 0) {
			$sharesTop = $shares.offset().top
			$sharesConTop = $sharesCon.offset().top;
			$sharesConleft = $sharesCon.offset().left;
			$sharesConHeight = $sharesCon.height();
			$sharesConBottom = $sharesConHeight + $sharesConTop;
		}
	}

	function stickyShares(wScroll) {
		if ($shares.length > 0) {
			if ($sharesConBottom - $sharesHeight - $offsetTop < wScroll) {
				$shares.css({
					position: 'absolute',
					top: $sharesConHeight - $sharesHeight,
					left: 0
				});
			} else if ($sharesTop < wScroll + $offsetTop) {
				$shares.css({
					position: 'fixed',
					top: $offsetTop,
					left: $sharesConleft
				});
			} else {
				$shares.css({
					position: 'absolute',
					top: 0,
					left: 0
				});
			}
		}
	}

	$(window).on('scroll', function () {
		stickyShares($(this).scrollTop());
	});

	$(window).resize(function () {
		setStickyPos();
		stickyShares($(this).scrollTop());
	});

	setStickyPos();

})(jQuery);



/*=========================================================
MY SCRIPTS
===========================================================*/

// ----- MISC ----- //
//TextCounter for comments / contact forms
function textCounter(field, field2, maxlimit) {
	let countfield = document.getElementById(field2);
	if (field.value.length > maxlimit) {
		field.value = field.value.substring(0, maxlimit);
		return false;
	} else {
		countfield.value = maxlimit - field.value.length;
	}
}


// Burger menu
$("#burgerMenu").on("click", function() {
	$("#burgerNav").toggle();
	$(".bar1, .bar2, .bar3").toggleClass("change");
});


// Close success messages modal box after 1.5s
function hideThanks() {
	$(".successModal").fadeOut();
}

let delayConfirmationMsg = setTimeout(hideThanks, 1500);


// ----- MANAGE COMMENTS PAGE ----- //
// Select / Deselect all checkboxes (for Reported comments)
$('#checkAllReported').change(function () {
	$('input[type=checkbox][id=commentID]').prop('checked', $(this).prop('checked'))
})

// Select / Deselect all checkboxes (for Reported comments)
$('#checkAllToPublish').change(function () {
	$('input[type=checkbox][id=commentPublishID]').prop('checked', $(this).prop('checked'))
})


// displays a message if no reported comments
if (!$.trim($('.reportedComments').html()).length) {
	$('.noReportedComments').css("display", "block");
} else {
	$('.noReportedComments').css("display", "none");
}


// displays a message if no new comments
if (!$.trim($('.acceptDenyComments').html()).length) {
	$('.noCommentsToManage').css("display", "block");
} else {
	$('.noCommentsToManage').css("display", "none");
}


//Reported / new comments anchors smooth Scroling
$(document).ready(function () {
	$(".js-scrollTo").on("click", function () {
		let section = $(this).attr("href");
		let speed = 750;
		$("html").animate({
			scrollTop: $(section).offset().top
		}, speed);
		return;
	});
});


// ----- USERS PAGE ----- //
// Select / Deselect all checkboxes
$('#checkAllUsers').change(function () {
	$('input[type=checkbox][id=userID]').prop('checked', $(this).prop('checked'))
})


// ----- SIGN IN FORM ----- //
// Enable submit button only if reCaptcha is valid
document.getElementById("signInBtn").disabled = true;

function enableBtn() {
	document.getElementById("signInBtn").disabled = false;
}