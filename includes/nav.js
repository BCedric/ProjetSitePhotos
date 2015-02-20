
				function navMozilla(){
					animNav()
					$('.menuderoulant').on('mouseleave',function(e){
						setTimeout(function(){$('.menuderoulant #rectangle2').css({"top":0,"left":0});},500);
					});
				}
				
				
				function navChrome(){
					animNav();
					$('.menuderoulant').on('mouseleave',function(e){
						setTimeout(function(){$('.menuderoulant #rectangle2').css({"top":-6,"left":0});},500);
					});
					$('.menuderoulant #rectangle2').css("top","-6px");
					
				}
				
				function animNav(){
					$('#menu #rectangle').hide();
					$('#menu>li>a').on('mouseover',function(e){
						$('#menu #rectangle').fadeIn(100);
						var p=$(this).offset();
						
						$('#menu #rectangle').animate({top:p.top-558,left:0}, 300, 'easeOutElastic');
					});
					$('#menu').on('mouseleave',function(e){
						$('#menu #rectangle').fadeOut(100);
						setTimeout(function(){$('#menu #rectangle').css({"top":68,"left":0});},400);
					});
				
					$('.menuderoulant>li>a').on('mouseover',function(e){
						$('.menuderoulant #rectangle2').fadeIn(100);
						var p=$(this).offset();
						
						$('.menuderoulant #rectangle2').animate({top:p.top-646,left:0}, 300, 'easeOutElastic');
					});
					
					$('#albums>ul').hide();
					
					
					$('#albums,#albums>ul').mouseenter(function(e){
						$('.menuderoulant').fadeIn(500);
					});
					
					
					$('#albums ul, #albums').mouseleave(function(e){
						
						$('.menuderoulant').fadeOut(500);
					});
				}