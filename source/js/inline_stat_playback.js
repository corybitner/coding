(function (window, $){
	"use strict"	

	if (!/loaded|interactive|complete/.test(document.readyState)) document.addEventListener("DOMContentLoaded",onLoad);
	else onLoad();  

    function onLoad() {    

		$(document).find('.hap-stat-wrap').each(function(){

			var lastActive, audio = document.createElement('audio');

			$(this).find(".hap-stat-item").each(function(){

				$(this).find(".hap-stat-item-title").on('click', function(e) { 
					e.preventDefault()

					if(!lastActive){

						lastActive = $(this).closest('.hap-stat-item').addClass("hap-stat-item-active").data('hap-is-active', '1')

						var url = lastActive.attr("data-url")
						url = b64DecodeUnicode(url.substr(6));
						audio.src = url;

						var promise = audio.play();
						if (promise !== undefined) {
							promise.then(function(){
						    }).catch(function(error){
						    });
						}

					}else{

						var parent = $(this).closest('.hap-stat-item')

						if(parent.data('hap-is-active')){

							if(audio.paused) {
							    var promise = audio.play();
								if (promise !== undefined) {
									promise.then(function(){
										lastActive.find('.hap-equaliser-container').removeClass('hap-equaliser-paused')
								    }).catch(function(error){
								    });
								}
						    }else{
							    audio.pause();
							    lastActive.find('.hap-equaliser-container').addClass('hap-equaliser-paused')
						    }


						}else{

							lastActive.removeClass("hap-stat-item-active").data('hap-is-active', null)
							lastActive = parent.addClass("hap-stat-item-active").data('hap-is-active', '1')

							var url = lastActive.attr("data-url")
							url = b64DecodeUnicode(url.substr(6));
							audio.src = url;

							var promise = audio.play();
							if (promise !== undefined) {
								promise.then(function(){
									lastActive.find('.hap-equaliser-container').removeClass('hap-equaliser-paused')
							    }).catch(function(error){
							    });
							}

						}

					}

			    
			    })

			})

		})

		function b64DecodeUnicode(str) {
		    // Going backwards: from bytestream, to percent-encoding, to original string.
		    return decodeURIComponent(atob(str).split('').map(function(c) {
		        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
		    }).join(''));
		};


	};	

}(window,jQuery));
