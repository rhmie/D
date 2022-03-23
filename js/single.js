	$(function () {
	   $('#mdb-lightbox-ui').load('./mdb-addons/mdb-lightbox-ui.html');
	});

	var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

	if (isMobile) {
	  $('input[name=Device]').val('1');
	} else {
	  $('input[name=Device]').val('0');
	}


	$('#more').on('click', function(){
		var count = parseInt($('#count').val());
		var max =	parseInt($(this).data('max'));
		if (count >= max){
			toastr.error(lan101);
			return;
		}

		$('#count').val(count + 1);
		count_price();

	});




	$('#less').on('click', function(){
		var count = parseInt($('#count').val());
		if (count === 1) return;

		$('#count').val(count - 1);
		count_price();
	});




	$('#count').on('input', function(){
		var cnt = parseInt($(this).val());
		var max = parseInt($(this).data('max'));
		if (cnt <= 0 || isNaN(cnt) || $.trim(cnt) === '' || $.trim(cnt) > max){
			$(this).val('1');
		}
		count_price();
	});



	function count_price(){
		var count = parseInt($('#count').val());
		var free_ship = parseInt($('#free_ship').val());

		var price = parseInt($('#price').val());
		var ship  = parseInt($('#ship').val());

		var total = price * count;
		$('#free_ship_label').remove();

		if ((total) < free_ship){
			var diff = free_ship - (price * count);
			$('#totalprice').text(total + ship);
			if (ship > 0){
				$('#pricebox').prepend('<span id="free_ship_label" class="font-weight-bold pink-text">🚚 '+lan102+'$'+diff+lan103+'</span>');
			}
		} else {
			$('#totalprice').text(total);
			$('#free_ship_label').remove();
		}

	}

	count_price();


	$.post('get_paymode.php', function(data){
		var result = JSON.parse(data);

		$('#paymode').html(result.paymode);
		$('#store').html(result.store);

		$('#paymode').trigger('change');

	});


	$('#modal_area').load('order_modals.php', function(){
		$('#twzipcode').twzipcode();

		var mobileOptions = {
		  mask: '{\\0\\9}00000000'
		}

		new IMask($('input[name=mphone]')[0], mobileOptions);
	});


	$('#buy_btn').on('click', function(){
		var paymode = $('#paymode').val();
		$('input[name=pay_method]').val(paymode);
		var pid = $('#pid').val();
		var pname = $.trim($('title').text());
		var totalprice = $('#totalprice').text();
		var cnt = parseInt($('#count').val());
		var price = parseInt($('#price').val());
		var cnt_price = price * cnt;


		var ship = parseInt($('#ship').val());
		var free_ship = parseInt($('#free_ship').val());

		var cart	=	{};
		cart.totalprice	=	cnt_price;
		if (cnt_price < free_ship) cart.totalprice = cnt_price + ship;

		var opts = [];

		$('.opts').each(function(){
			opts.push($(this).val());
		});

		cart.prods = [{'pid': pid, 'pname': pname, 'opts': opts, 'cnt': cnt, 'cnt_price': cnt_price}];
		
		if (paymode === '1' || paymode === '2'){
			$('input[name=pay_method]').val(paymode);
			$('input[name=prod_id]').val(pid);
			$('input[name=pname]').val(pname);
			$('input[name=total]').val(totalprice);
			$('input[name=cart]').val(JSON.stringify(cart));

			if (paymode === '1'){
				$('#oform').prop('action', 'single_order_directory.php');
			} else {
				$('#oform').prop('action', 'single_order.php');
			}

			$('#ordermodal').modal();
			
		} else {
			localStorage.setItem('single_cart', JSON.stringify(cart));

			if (paymode === '3' || paymode === '4'){
				$('input[name=ExtraData]').val(paymode);
				$('#ECPayForm').submit();
			}
		}
		
	});


	function get_discount(){
		var pid = $('#pid').val();
		$.post('get_discount.php', {pid: pid}, function(data){
			var result = JSON.parse(data);

			if (result['err_msg'] !== 'OK'){
			    toastr.error('發生錯誤，請稍後再試~!');
			    return false;
			}

			if (result.stock === 0){
				toastr.error(result.stock_alert);
				$('#buy_btn').addClass('disabled').html('<i class="far fa-tired fa-lg mr-1"></i>'+result.stock_alert);
			}

			if (result.status === 1){
				window.location = './maintenance.php';
				// toastr.error('很抱歉目前網站維護中，請稍後再試~!');
				// $('#buy_btn').addClass('disabled').html('<i class="fas fa-wrench fa-lg mr-1"></i>網站維護中');
			}

			$('#more').data('max', result.max);

			$('.price').html(result.price);
			$('.discount').html(result.discount);

		})
	}

	get_discount();

	$('#gotop').on('click', function(){
		$('html').animate({
		    scrollTop: $("#title").offset().top
		}, 800);
	});


	// $('body').on('submit', '#oform', (function (e) {
	// 	e.preventDefault();

	// 	$('#submit_btn').html('傳送中<i class="fas fa-circle-notch fa-spin fa-lg ml-2"></i>').parent().addClass('disabled');

	// 	$.ajax({
	// 		url: 'single_order_directory.php',
	// 		type: "POST",
	// 		data:  new FormData(this),
	// 		contentType: false,
	// 		cache: false,
	// 		processData:false,
	// 		success: function(data){
	// 			var result = JSON.parse(data);

	// 			$('#submit_btn').html('送出 <i class="fas fa-paper-plane fa-lg"></i>').parent().removeClass('disabled');

	// 			if (result.err_msg !== 'OK'){
	// 			    toastr.error(result.err_msg);
	// 			    return false;
	// 			}

	// 			$('#ordermodal').modal('hide');
	// 			toastr.success('訂購完成，感謝您的購買~!');
	// 		}
	// 	});

	// }));


	$('#paymode').on('change', function(){
	    var pm =    $(this).val();
	    if (pm === '3' || pm === '4'){
	        $('#stbox').removeClass('d-none');

	        if (pm === '3') $('input[name=IsCollection]').val('N');
	        if (pm === '4') $('input[name=IsCollection]').val('Y');
	        $('#store').trigger('change');
	    } else {
	        $('#stbox').addClass('d-none');
	    }
	});

	$('#store').on('change', function(){
	    var sname = $(this).val();
	    $('input[name=LogisticsSubType]').val(sname);
	});


	$('body').on('change', '.fopts', function(){
		var v = $(this).val();
		if ($('#k'+v).length === 0) return;
		
		$('.carousel-item').removeClass('active');
		$('#k'+v).addClass('active');
	});
	
