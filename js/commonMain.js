window.onload = function() {
	$(".sidebar-ul-tit-li2").click(function() {
		$(this).toggleClass("on").parent().siblings(".sidebar").toggle()
	})
};
$(window).scroll(function() {
	300 < $(window).scrollTop() ? $(".sidebar-ul-tit .top").css({
		display: "block"
	}) : $(".sidebar-ul-tit .top").css({
		display: "none"
	});
	$(".top").click(function() {
		$("html,body").stop().animate({
			scrollTop: "0"
		}, 300)
	})
});

function commomMain() {
	$(".header-nav ul li").mouseover(function() {
		$(".header-nav .web-nav li").each(function() {
			var a = $(this).width();
			$(this).css({
				"float": "none",
				width: a + "px",
				margin: "0 auto"
			})
		});
		var b = $(this).attr("class");
		$(".header-nav ol li").each(function() {
			if ($(this).attr("class").split(" ")[0] == b) {
				$(".header-nav .web-nav").show();
				$(".header-nav ol").find("." + b).stop().slideDown(800).siblings().hide();
				var a = $(this).find(".dls").innerHeight();
				console.log(a);
				$(this).find("dl").css({
					height: a + "px"
				});
				return !1
			}
			$(".header-nav .web-nav").hide()
		})
	});
	$(".header-nav .web-nav").mouseover(function() {
		$(this).show()
	});
	$(".header-nav ul li").mouseout(function() {
		$(".header-nav .web-nav").hide()
	});
	$(".header-nav .web-nav").mouseout(function() {
		$(this).hide()
	})
};
