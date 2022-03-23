	
	var cart	=	{};
	cart.prods 	=	[];
	cart.adds 	=	[];
	cart.totalprice	=	0;

	var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);


	$( document ).ready(function() {
		var mobileOptions = {
		  mask: '{\\0\\9}00000000'
		}

		if ($('#phone').length > 0)
			new IMask($('#phone')[0], mobileOptions);

		if ($('#account').length > 0)
			new IMask($('#account')[0], mobileOptions);

		if ($('#mphone').length > 0)
			new IMask($('#mphone')[0], mobileOptions);

		if ($('#ophone').length > 0)
			new IMask($('#ophone')[0], mobileOptions);

		 var usrname = localStorage.getItem('usrname');
		 var usrpass = localStorage.getItem('usrpass');

		 if (usrname === null){
		  $('#remember').prop('checked', false);
		} else {
		  $('#remember').prop('checked', true);
		  $('#phone').val(usrname);
		  $('#password').val(usrpass);
		}

		if (localStorage.getItem('cart') !== null){
			cart	=	JSON.parse(localStorage.getItem('cart'));
			$('.cart_count').text(cart.prods.length + cart.adds.length);
		}

		recount_list();
		put_views();

		new WOW().init();

	});

	$(function () {
		$('#mdb-lightbox-ui').load('mdb-addons/mdb-lightbox-ui.html');
	});
	

	$('.carousel.carousel-multi-item.v-2 .carousel-item').each(function(){
	  var next = $(this).next();
	  if (!next.length) {
	    next = $(this).siblings(':first');
	  }
	  next.children(':first-child').clone(true).appendTo($(this));

	  for (var i=0;i<4;i++) {
	    next=next.next();
	    if (!next.length) {
	      next=$(this).siblings(':first');
	    }
	    next.children(':first-child').clone(true).appendTo($(this));
	  }
	});
	

	$('#showlink').on('click', function(){
		$('html, body').scrollTop(0);
	    $('#plinks').toggle('slow');
	});

	// $(window).on('resize', function(){
	//     var win = $(this);
	//     if (win.width() >= 1149){
	//         if ($('#plinks').is(':visible')){
	//             $('#plinks').hide('slow');
	//         }
	//      }
	// });


	function get_product(id, img){

		$.post('get_product.php', {pid: id}, function(data){

			var result = JSON.parse(data);
			//console.log(result);

			if (result.err_msg !== 'OK'){
			    toastr.error(result.err_msg);
			    $('#loading').slideUp('slow', function(){
			    	del_history(id);
			    	$('#pmodal').modal('hide');
			    });
			    return false;
			}

			// jss.set('body::-webkit-scrollbar', {
			//     'width': '0px',
			//     'background': 'transparent',
			//     'scrollbar-width': 'none'
			// });

			$('#loading').slideUp('slow', function(){
				$('#pmodal').html(result.html);

				initPhotoSwipeFromDOM('.mdb-lightbox');
				save_history(id, img);
			});

		});
	}

	function del_history(pid){
		var views = localStorage.getItem('views');
		if (views === null) return;

		views = JSON.parse(views);
		
		var result = $.map(views, function(item, index) {
		  return item.pid;
		}).indexOf(pid);

		views.splice(result,1);

		localStorage.setItem('views', JSON.stringify(views));
		put_views();
	}


	function save_history(pid, img){
		var views = localStorage.getItem('views');

		if (views === null){
			views	=	[];
			views.push({'pid': pid, 'img': img});
		} else {
			views = JSON.parse(views);

			var result = $.map(views, function(item, index) {
			  return item.pid;
			}).indexOf(pid);

			if (result >= 0){
				return;
			}
			views.push({'pid': pid, 'img': img});
			if (views.length > 4) views.shift();
		}

		localStorage.setItem('views', JSON.stringify(views));
		put_views();
	}

	function put_views(){
		var views = localStorage.getItem('views');
		if (views === null){
			$('#view_history').addClass('d-none');
		 	return;
		}

		views = JSON.parse(views);

		var items = '';
		$.each(views, function(key, item){
			items += '<img class="get_product mr-1" data-pid="'+item.pid+'" src="'+item.img+'" alt="">';
		});

		$('#views').html(items);
		$('#view_history').removeClass('d-none');
	}


	$('#pmodal').on('click', '#more', function(){
		var cnt = parseInt($('#count').val());
		var max = parseInt($(this).data('max'));

		if (cnt >= max){
		    toastr.error(lan101);
		    return;
		}
		$("#count").val(cnt + 1);
	});
	

	$('#pmodal').on('click', '#less', function(){
		var count = parseInt($('#count').val());
		if (count === 1) return;
		$('#count').val(count - 1);
	});

	$('#pmodal').on('input', '#count', function(){
		var cnt = parseInt($(this).val());
		var max = parseInt($(this).data('max'));
		if (cnt <= 0 || isNaN(cnt) || $.trim(cnt) === '' || $.trim(cnt) > max){
			$(this).val('1');
		}
	});

	$('#pmodal').on('click', '#gotop', function(){
		$('#pmodal').animate({
		    scrollTop: $('body').offset().top
		}, 800);
	});


	$('#reglink').on('click', function(){
		if ($.trim($('#annmodal .modal-body').text()) !== ''){
			$('#loginmodal').on('hidden.bs.modal', function(){
			   $('#annmodal').modal();
			   $('#loginmodal').off('hidden');
			});
		} else {
			$('#loginmodal').on('hidden.bs.modal', function(){
			   $('#regmodal').modal();
			   $('#loginmodal').off('hidden');
			});
		}

		$('input[name=fb_id]').val('0');
		$('input[name=line_id]').val('0');
		$('input[name=regpassword]').prop('required', true);

		$('#passgroup').show();
		$('#loginmodal').modal('hide');
	});

	$('#agree').on('click', function(){
		$('#annmodal').on('hidden.bs.modal', function(){
		   $('#regmodal').modal();
		   $('#annmodal').off('hidden');
		});

		// if ($('input[name=fb_id]').val() !== '0'){
		// 	$('#passgroup').hide();
		// } else {
		// 	$('#passgroup').show();
		// }

		$('#annmodal').modal('hide');
	})


	$('#passlink').on('click', function(){
		$('#loginmodal').on('hidden.bs.modal', function(){
		   $('#passmodal').modal();
		   $('#loginmodal').off('hidden');
		});

		$('#loginmodal').modal('hide');
	});


	$('#forgotform').on('submit', (function (e) {
		e.preventDefault();

		$.ajax({
			url: 'reset_pass.php',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){

				var result = JSON.parse(data);

				$('#passmodal').modal('hide');

				if (result.err_msg !== 'OK'){
				    toastr.error(result.err_msg);
				    return;
				}

				

				toastr.success(lan110);
			}
		});

	}));




	$('#regform').on('submit', (function (e) {
		e.preventDefault();

		var url	=	'register.php';
		var reg_mode = $('input[name=reg_mode]').val();
		var fb_id = $('input[name=fb_id]').val();

		var next =	$('#welcomemodal');

		if (reg_mode === '1'){
		 	url = 'setcode.php';
		 	next = $('#codemodal');
		}

		$('#reg_submit').html(lan111+'<i class="fas fa-circle-notch fa-spin fa-lg ml-2"></i>').parent().addClass('disabled');

		$.ajax({
			url: url,
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				var result = JSON.parse(data);

				$('#reg_submit').html('<i class="fas fa-sign-in-alt fa-lg mr-2"></i>'+lan14).parent().removeClass('disabled');

				if (result.err_msg !== 'OK'){
				    toastr.error(result.err_msg);
				    return;
				}

				$('#regmodal').on('hidden.bs.modal', function(){
				   $(next).modal();
				   $('#regmodal').off('hidden');
				});

				$('#regmodal').modal('hide');
			}
		});

	}));


	$('#code_btn').on('click', function(){
		var vcode 	=	$.trim($('input[name=vcode]').val());

		if (vcode === ''){
			toastr.error(lan112);
			return;
		}

		var username	=	$.trim($('input[name=username]').val());
		var account		=	$.trim($('input[name=account]').val());
		var regpassword	=	$.trim($('input[name=regpassword]').val());
		var fb_id 		=	0;

		$('#code_btn').html('傳送中<i class="fas fa-circle-notch fa-spin fa-lg ml-2"></i>').addClass('disabled');

		$.post('register.php', {vcode: vcode, username: username, account: account, regpassword: regpassword, fb_id: fb_id}, function(data){
			var result = JSON.parse(data);
			$('#code_btn').html('<i class="fas fa-sign-in-alt fa-lg mr-2"></i>提交').removeClass('disabled');

			if (result.err_msg !== 'OK'){
			    toastr.error(result.err_msg);
			    return;
			}

			$('#codemodal').on('hidden.bs.modal', function(){
			   $('#welcomemodal').modal();
			   $('#codemodal').off('hidden');
			});

			$('#codemodal').modal('hide');

		});

	});

	$("#welcomemodal").on('shown.bs.modal', function(){
	   setTimeout(function(){
	       window.location = window.origin;
	   }, 3000);
	});


	$('#fblogin').on('click', function(){
	    FB.login(function(response) {
	        if (response.authResponse) {
	         //console.log('Welcome!  Fetching your information.... ');
	         FB.api('/me', {fields: 'id, name'}, function(response) {
	            //console.log(response);
	            fb_login(response);
	         });
	        } else {
	         //console.log('User cancelled login or did not fully authorize.');
	        }
	    });
	});


	//fb登入
	function fb_login(response){
	    var fb_id   =   response.id;
	    var fb_name =   response.name;

	    //console.log(fb_id);

	    $.post('fb_login.php', {fb_id: fb_id}, function(data){
	        //console.log(data);
	        var result = JSON.parse(data);

	        if (result['err_msg'] === 'NO'){

	            $('input[name=fb_id]').val(fb_id);
	            $('input[name=username]').val(fb_name);

	            $('input[name=regpassword]').prop('required', false);
	            $('#passgroup').hide();

	            $('#loginmodal').on('hidden.bs.modal', function(){
	               $('#loginmodal').off('hidden');

	               if ($.trim($('#annmodal .modal-body').text()) !== ''){
	               		$('#annmodal').modal();
	               } else {
	               		$('#regmodal').modal();
	               }

	            });

	            $('#loginmodal').modal('hide');

	            return;
	        }

	        if (result['err_msg'] !== 'OK'){
	            toastr.error(result.err_msg);
	            return;
	        }
	        
	        location.reload();
	    })
	}

	//一般登入
	$('#loginform').on('submit', (function (e) {
		e.preventDefault();

		$('#login_submit').html(lan111+'<i class="fas fa-circle-notch fa-spin fa-lg ml-2"></i>').parent().addClass('disabled');

		$.ajax({
			url: 'login.php',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				var result = JSON.parse(data);

				$('#login_submit').html('<i class="fas fa-sign-in-alt fa-lg mr-2"></i>'+lan13).parent().removeClass('disabled');

				if (result.err_msg !== 'OK'){
				    toastr.error(result.err_msg);
				    return;
				}

				if ($('#remember').is(':checked')){
				  var usrname = $('#phone').val();
				  var usrpass = $('#password').val();
				  localStorage.setItem('usrname',usrname);
				  localStorage.setItem('usrpass',usrpass);
				} else {
				  localStorage.removeItem('usrname');
				  localStorage.removeItem('usrpass');
				}

				location.reload();
			}
		});

	}));



	//到貨通知
	$('#pmodal').on('click', '.alert_me', function(){
		var pid = $(this).data('pid');

		$.post('products_alert.php', {pid: pid}, function(data){
			var result = JSON.parse(data);

			if (result.err_msg === '-1'){
				alert(lan106);
				window.location = 'login.php';
			}

			if (result.err_msg !== 'OK'){
			    toastr.error(result.err_msg);
			    return;
			}

			toastr.success(lan71);
		});
	});

	

	$('body').on('click', '.add2_cart', function(){
		var pid = $(this).data('pid');
		var img = $(this).data('img');
		var pname = $(this).data('pname');

		// var result = $.map(cart.prods, function(item, index) {
		//   return item.pid;
		// }).indexOf(pid);

		// if (result >= 0){
		// 	toastr.warning(lan72);
		// 	return;
		// }

		var cnt = $('#pmodal #count').val();
		var opts = [];
		$('#pmodal .opts').each(function(){
			opts.push($(this).val());
		});
		cart.prods.push({'pid': pid, 'opts': opts, 'cnt': cnt, 'img': img, 'pname': pname});
		$('.cart_count').text(cart.prods.length + cart.adds.length);
		localStorage.setItem('cart', JSON.stringify(cart));
		toastr.success(lan73);

		recount_list();
	});


	//單品加購
	$('body').on('click', '.add3_cart', function(){
		var mid = $(this).data('mid');
		var img = $(this).data('img');
		var pname = $(this).data('pname');

		var result = $.map(cart.prods, function(item, index) {
		  return item.pid;
		}).indexOf(mid);

		if (result < 0){
			toastr.warning(lan74);
			return;
		}

		var pid = $(this).data('pid');

		// var result = $.map(cart.adds, function(item, index) {
		//   return item.pid;
		// }).indexOf(pid);

		// if (result >= 0){
		// 	toastr.warning(lan72);
		// 	return;
		// }

		var price = $(this).data('price');
		var cnt_max = $(this).data('cnt_max');

		cart.adds.push({'mid': mid, 'pid': pid, 'price': price, 'opts': '', 'cnt': 1,'cnt_max': cnt_max, 'img': img, 'pname': pname});
		$('.cart_count').text(cart.prods.length + cart.adds.length);
		localStorage.setItem('cart', JSON.stringify(cart));
		toastr.success(lan73);

		recount_list();

	});


	$('body').on('click', '.mycart', function(){
		if (cart.prods.length === 0){
			toastr.warning(lan75);
			return;
		}

		$('#cart').val(JSON.stringify(cart));
		$('#cartform').submit();
	});


	$('#pmodal').on('click', '.get_related', function(){
		//console.log('get_related pmodal');
		var pid = $(this).data('pid');
		var img = $(this).data('img');

		$('#pmodal').html('<div id="loading" class="grey-text mt-5 text-center"><i class="fas fa-circle-notch fa-spin fa-5x"></i></div>');
		get_product(pid, img);
	});

	$('#blogbox').on('click', '.get_related', function(e){
		if ($(e.target).parent().hasClass('add1_cart')) return;
		var pid = $(this).data('pid');
		var img = $(this).data('img');
		$('#pmodal').modal();
		get_product(pid, img);
	});


	$('body').on('click', '.add1_cart', function(e){

		e.stopImmediatePropagation();
		var pid = $(this).data('pid');
		var img = $(this).data('img');
		var pname = $(this).data('pname');

		// var result = $.map(cart.prods, function(item, index) {
		//   return item.pid;
		// }).indexOf(pid);

		// if (result >= 0){
		// 	toastr.warning(lan72);
		// 	return;
		// }

		cart.prods.push({'pid': pid, 'opts': '', 'cnt': 1, 'img': img, 'pname': pname});
		$('.cart_count').text(cart.prods.length + cart.adds.length);

		localStorage.setItem('cart', JSON.stringify(cart));
		toastr.success(lan73);

		recount_list();

	});


	var lastScrollTop = 0;
	// $(window).scroll(function(e) {
	// 	if (!isMobile) return;
	//     var scroll = $(window).scrollTop();
	//     if (scroll > lastScrollTop) {
	//         $('.navbar').addClass("navbar-hide");
	//     } else {
	//         $('.navbar').removeClass("navbar-hide");
	//     }

	//     lastScrollTop = scroll;

	// });

	window.location.hash = 'main';
	
	window.addEventListener('hashchange', function(e) {
	   	
	   	if (e.oldURL.includes('products&gid')){
	   	 	return;
	   	}

	   	$('#close').trigger('click');

	});

	$('body').on('click', '.get_product', function(){

		var pid = $(this).data('pid');
		var img = $(this).data('img');

		if (product_mode === 1){
			save_history(pid, img);
			window.location = './product.php?pid='+pid;
			return;
		}

		$('#pmodal').modal();
		window.location.hash = 'products';
		// var detail	=	$(this).data('detail');
		// console.log(detail);
		// console.log(detail.images[0]);
		get_product(pid, img);
	});


	$('#pmodal').on('hidden.bs.modal', function(){
	  $('#pmodal').html('<div id="loading" class="grey-text mt-5 text-center"><i class="fas fa-circle-notch fa-spin fa-5x"></i></div>');
	  window.location.hash = 'main';

	  if ($('.color_btn').length > 0) return;
	  jss.remove();
	});

	$('#pmodal').on('show.bs.modal', function(){

		if ($('.color_btn').length > 0) return;

		jss.set('body::-webkit-scrollbar', {
		    'width': '0px',
		    'height': '0px',
		    'background': 'transparent'
		});

		jss.set('body', {
		    'overflow-y': 'scroll',
		    'scrollbar-width': 'none',
		    '-ms-overflow-style': 'none'
		});

	});

	//購物車下拉清單計算
	function recount_list(){

		if (cart.prods.length === 0){
			$('.d-cart .dropdown-menu').html('').css('visibility', 'hidden');
			return;
		}

		var media = '';
		$.each(cart.prods, function(key, item){

			media += `<div class="media py-3">
                              <img height="80" class="d-flex mr-3 z-depth-1-half get_product" data-pid="`+item.pid+`" data-img="`+item.img+`" src="`+item.img+`" alt="`+item.pname+`">
                              <div class="media-body align-self-center">
                                  <p class="mt-0 mb-1 font-weight-bold prodname">`+item.pname+`</p>
                                  <a class="dribbble-ic mr-3" data-pid="`+item.pid+`" role="button"><i class="fas fa-trash-alt fa-lg"></i></a>
                              </div>

                              <hr>
                          </div>`;

		});

		$.each(cart.adds, function(key, item){

			media += `<div class="media py-3">
                              <img height="80" class="d-flex mr-3 z-depth-1-half get_product" data-pid="`+item.pid+`" data-img="`+item.img+`" src="`+item.img+`" alt="`+item.pname+`">
                              <div class="media-body align-self-center">
                                  <p class="mt-0 mb-1 font-weight-bold prodname">`+item.pname+`</p>
                                  <a class="dribbble-ic mr-3" data-pid="`+item.pid+`" role="button"><i class="fas fa-trash-alt fa-lg"></i></a>
                              </div>

                              <hr>
                          </div>`;

		});

		media += '<button class="btn btn-blue-grey waves-effect waves-light btn-block btn-sm mycart mt-3"><i class="fas fa-dollar-sign fa-lg mr-1"></i>'+lan100+'</button>';

		$('.d-cart .dropdown-menu').css('visibility', 'visible').html(media);

	}
	

	$('body').on('click', '.dribbble-ic', function(){
		var pid = $(this).data('pid');
		cart.prods = remove_cart_item(pid);
		cart.adds = remove_adds_item(pid);
		cart.adds = remove_links_item(pid);
		$(this).parent().parent().remove();

		localStorage.setItem('cart', JSON.stringify(cart));

		$('.cart_count').text(cart.prods.length + cart.adds.length);

		recount_list();

	});

	//移除商品
	function remove_cart_item(id) {
	    return cart.prods.filter(function(emp) {
	        if (emp.pid == id) {
	            return false;
	        }
	        return true;
	    });
	}

	//移除加購商品
	function remove_adds_item(id) {
	    return cart.adds.filter(function(emp) {
	        if (emp.pid == id) {
	            return false;
	        }
	        return true;
	    });
	}

	//連帶移除加購商品
	function remove_links_item(id) {
	    return cart.adds.filter(function(emp) {
	        if (emp.mid == id) {
	            return false;
	        }
	        return true;
	    });
	}


	$('.color_btn').on('click', function(){
		$('#color_panel').toggle('fast');
	});


	$('#colorform').on('submit', (function (e) {
		e.preventDefault();

		// toastr.error('DEMO不能做儲存~!');
		// return false;

		$.ajax({
			url: 'colors.php',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){

				var result = JSON.parse(data);

				if (result.err_msg !== 'OK'){
				    toastr.error(result.err_msg);
				    return;
				}

				toastr.success('更新完成，請清除瀏覽器暫存並重新載入~!');
			}
		});

	}));

	$('#rollback').on('click', function(){

			// toastr.error('DEMO不能做重設~!');
			// return;

			var msg = "確定要恢復到系統預設值？您所做的修改將會遺失~!";
			if (confirm(msg)==true){

				$.post('colors_back.php', function(data){
					var result = JSON.parse(data);

					if (result.err_msg !== 'OK'){
					    toastr.error(result.err_msg);
					    return;
					}

					toastr.success('更新完成，請清除瀏覽器暫存並重新載入~!');
				})

			}
	});

	$('#pmodal').on('change', '.fopts', function(){
		var v = $(this).val();
		if ($('#k'+v).length === 0) return;

		$('#pmodal .carousel-item').removeClass('active');
		$('#k'+v).addClass('active');
	});

