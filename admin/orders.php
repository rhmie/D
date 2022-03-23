<?php session_start(); ?>
<?php

	if (!isset($_SESSION['bee_admin'])){
	   echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	}

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	include('./ssl_encrypt.php');
	$db = new MysqliDb($mysqli);

	$count = $db->getValue ('orders', 'count(*)');
	$m_total_pages = ceil($count / 8);
	if ($m_total_pages == 0) $m_total_pages = 1;

	$f2     =   encrypt_decrypt('encrypt', 'orders').'_orders.sql';

	$db->rawQuery('UPDATE system SET new_ocount = 0');

?>

<style>
	.odate {
	    position: absolute;
	    right: 20px;
	    top: 10px;
	}

	#orders {
		font-size: .9rem;
	}

	#orders p {
		font-size: .9rem;
		margin-bottom: .4rem !important;
	}

	.adds {
		background: oldlace;
	}

</style>

<section class="section" id="orders">

	<div class="row">

	 	<div class="col-12 mt-2 px-0">

	 		<!-- Nav tabs -->
	 		<ul class="nav nav-tabs md-tabs nav-justified primary-color" role="tablist">
	 		  <li class="nav-item">
	 		    <a class="nav-link active" data-toggle="tab" href="#orders_tab" role="tab">
	 		      訂單管理
	 		  	</a>
	 		  </li>
	 		  <li class="nav-item">
	 		    <a class="nav-link" data-toggle="tab" href="#profit_tab" role="tab">
	 		      獲利統計
	 		  	</a>
	 		  </li>
	 		</ul>
	 		<!-- Nav tabs -->

	 		<!-- Tab panels -->
	 		<div class="tab-content">

	 		  <!-- Panel 1 -->
	 		  <div class="tab-pane fade in show active px-3" id="orders_tab" role="tabpanel">

	 		  	<div class="row my-3">
		 		  	<div class="col-md-4 my-auto">
		 		  		<span style="color: #64b5f6">◼︎</span><span class="mr-2">已出貨</span>
		 		  		<span style="color: #f06292">◼︎</span><span class="mr-2">未出貨</span>
		 		  		<span style="color: #9e9e9e">◼︎</span><span class="mr-2">金流未完成</span>
		 		  	</div>
		 		  	<div class="col-md-8">
		 		  		<form id="excform" method="POST" action="excel_export.php">
		 		  			<input name="table" type="hidden" value="orders">
		 		  			<input name="range1" type="hidden">
		 		  			<input name="range2" type="hidden">
		 		  		</form>
		 		  		<div class="btn-group btn-block">
		 		  			<a type="button" data-sid="0" class="btn blue text-white lighten-2 btn-sm sorder">顯示全部</a>
		 		  			<a type="button" data-sid="1" class="btn pink text-white lighten-2 btn-sm sorder">僅顯示未出貨</a>
		 		  			<a type="button" href="./<?=$f2?>" class="btn btn-blue-grey text-white lighten-2 btn-sm" download>下載SQL檔</a>
		 		  			<button type="button" id="btn_export" class="btn btn-purple text-white lighten-2 btn-sm">下載excel檔</button>
		 		  		</div>
		 		  	</div>
		 		 </div>

		 		  	<div class="row my-3 p-3" style="border: solid 1px gainsboro; border-radius: 12px;">

			 		  	<div class="col-3">
			 		  		<div class="custom-control custom-checkbox mt-3 text-left">
			 		  		  <input type="checkbox" class="custom-control-input" id="date_range">
			 		  		  <label class="custom-control-label" for="date_range">以日期範圍搜尋</label>
			 		  		</div>
			 		  	</div>

			 		  	<div class="col-3">
			 		  		<div class="md-form mb-2 mt-0">
			 		  		    <i class="far fa-calendar-alt prefix"></i>
			 		  		    <input placeholder="開始日期" type="text" id="range1" class="form-control datepicker rpicker" disabled>
			 		  		</div>
			 		  	</div>

			 		  	<div class="col-3">
			 		  		<div class="md-form mb-2 mt-0">
			 		  		    <i class="far fa-calendar-alt prefix"></i>
			 		  		    <input placeholder="結束日期" type="text" id="range2" class="form-control datepicker rpicker" disabled>
			 		  		</div>
			 		  	</div>

			 		  	<div class="col-3">
			 		  		<div class="btn-group btn-block btn-group-sm">
			 		  			<button id="search_btn" class="btn btn-blue-grey" disabled><i class="fas fa-search"></i> 搜尋</button>
			 		  			<button id="print_btn" class="btn btn-blue-grey" disabled><i class="fas fa-print"></i> 列印</button>
			 		  		</div>
			 		  	</div>

			 		 </div>

		 		

	 		  	<!--Accordion wrapper-->
	 		  	<div class="accordion md-accordion accordion-1" id="order_accordion" role="tablist">
	 		  	  
	 		  	</div>
	 		  	<!--Accordion wrapper-->


	 		  	<div id="pagerow" class="row justify-content-center mt-5">
	 		  		<nav class="text-center my-4" aria-label="Page navigation">
	 		  		    <ul class="pagination" id="m_pagination"></ul>
	 		  		</nav>
	 		  	</div>
	 		   

	 		  </div>
	 		  <!-- Panel 1 -->

	 		  <!-- Panel 2 -->
	 		  <div class="tab-pane fade px-3" id="profit_tab" role="tabpanel">

	 		  	<canvas id="lineChart" class="mt-3"></canvas>

	 		  	
	 		  		<form id="calform" class="form-row mt-4">
	 		  			<div class="col-12 mb-4">
	 		  			    <p class="note note-primary">
	 		  			        尚未出貨或是金流未完成的訂單將不被計算 / 訪客數量僅保留最後三個月資訊
	 		  			    </p>
	 		  			</div>

		 		  		<div class="col-md-4">
		 		  			<div class="md-form mb-2 mt-0">
		 		  			    <i class="far fa-calendar-alt prefix"></i>
		 		  			    <input placeholder="開始日期" type="text" id="sdate" name="sdate" class="form-control datepicker dpicker" required>
		 		  			</div>
		 		  		</div>

		 		  		<div class="col-md-4">
		 		  			<div class="md-form mb-2 mt-0">
		 		  			    <i class="far fa-calendar-alt prefix"></i>
		 		  			    <input placeholder="結束日期" type="text" id="edate" name="edate" class="form-control datepicker dpicker" required>
		 		  			</div>
		 		  		</div>

		 		  		<div class="col-md-4 text-center">
		 		  			<button type="submit" class="btn btn-blue-grey btn-block"><i class="fas fa-calculator fa-lg mr-2"></i>開始計算</button>
		 		  		</div>
		 		  	</form>


		 		  	<div class="row mt-4">
		 		  		<div id="cal_result" class="col-12">

		 		  		</div>
		 		  	</div>
	 		  	

	 		  </div>
	 		  <!-- Panel 2 -->

	 		</div>
	 		<!-- Tab panels -->

	 	</div>
	</div>
	<form id="printform" method="POST" action="./print_orders.php" target="_blank">
		<input type="hidden" name="print_data">
	</form>
</section>

	<script>

		var m_page = 1;

		$('.dpicker').pickadate({
		    monthsShort: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
		    weekdaysShort: ['日', '一', '二', '三', '四', '五', '六'],
		    format: 'yyyy-mm-dd',
		    today: '今日',
		    clear: '清除',
		    close: '關閉',
		    formatSubmit: 'yyyy-mm-dd',
		    showMonthsShort: true,
		    firstDay: 1,
		    max: 0
		    }
		);

		$('.rpicker').pickadate({
		    monthsShort: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
		    weekdaysShort: ['日', '一', '二', '三', '四', '五', '六'],
		    format: 'yyyy-mm-dd',
		    today: '今日',
		    clear: '清除',
		    close: '關閉',
		    formatSubmit: 'yyyy-mm-dd',
		    showMonthsShort: true,
		    firstDay: 1,
		    max: 0
		    }
		);

		$('#calform').on('submit', (function (e) {
			e.preventDefault();

			var sdate	=	$('#sdate').val();
			var edate	=	$('#edate').val();

			if ($.trim(sdate) === '' || $.trim(edate) === ''){
				toastr.error('請選擇日期~!');
				return;
			}

			$.ajax({
				url: 'cal_orders.php',
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(data){
					var result = JSON.parse(data);

					if (result.err_msg === '-1'){
						alert('登入逾時，請重新登入~!');
						window.location = 'login.php';
					}

					if (result.err_msg !== 'OK'){
					    toastr.error(result.err_msg);
					    return false;
					}

					$('#cal_result').html(result.cal_result);
					put_chart(result.date, result.visitors, result.orders);

				}
			});

		}));

		window.pagObj = $('#m_pagination').twbsPagination({
		            totalPages: <?php echo $m_total_pages ?>,
		            visiblePages: 10,
		            onPageClick: function (event, page) {

		            }
		        }).on('page', function (event, page) {
		        	//console.log(page);
		            m_page = page;
		            get_orders(0);
		});


		function get_orders(sid){
			var icount = (parseInt(m_page) - 1) * 8;
			var range1 = $('#range1').val();
			var range2 = $('#range2').val();
			var date_range = 0;
			if ($('#date_range').is(':checked')) date_range = 1;

			$.post('get_orders.php',{icount: icount, sid: sid, range1: range1, range2: range2, date_range: date_range}, function(data){
				
				var result = JSON.parse(data);

				if (result['err_msg'] === '-1'){
					alert('登入逾時，請重新登入~!');
					window.location = 'login.php';
				}

				if (result.oitems === ''){
					toastr.error('沒有資料');
					$('#print_btn').prop('disabled', true);
					return;
				}

				$('#order_accordion').html(result.oitems);

				if (date_range > 0){
					$('input[name=print_data]').val(result.pdata);
					$('#print_btn').prop('disabled', false);
				}

			                                
			});
		}

		$('.sorder').on('click', function(){
			var sid 	=	$(this).data('sid');
			$('#date_range').prop('checked', false);
			$('#range1, #range2, #search_btn, #print_btn').val('').prop('disabled', true);

			if (sid === 1){
				$('#pagerow').hide();
			} else {
				m_page = 1;
				$('#m_pagination').twbsPagination('destroy');
				$('#m_pagination').twbsPagination({
					totalPages: <?php echo $m_total_pages ?>,
					visiblePages: 10,
					startPage: 1
				}).on('page', function (event, page) {
		        	//console.log(page);
		            m_page = page;
		            get_orders(0);
				});

				$('#pagerow').show();
			}
			get_orders(sid);
		});



		$('#order_accordion').on('click', '.do_order', function(){
			var msg = "確定要標示為已出貨？"; 
			if (confirm(msg)==true){ 
				var oid 	=	$(this).data('oid');
				var btn 	=	$(this);
				var card 	=	$(this).closest('.card');
				$.post('order_done.php', {oid: oid}, function(data){
					var result = JSON.parse(data);

					if (result['err_msg'] === '-1'){
						alert('登入逾時，請重新登入~!');
						window.location = 'login.php';
					}

					if (result['err_msg'] !== 'OK'){
						toastr.error(result.err_msg);
						return;
					}

					$('.card-header', card).removeClass('pink grey').addClass('blue light-3');
					$(btn).remove();

				});
			}

		});


		$('#order_accordion').on('click', '.del_order', function(){
			var msg = "確定要刪除此訂單？"; 
			if (confirm(msg)==true){ 
				var oid 	=	$(this).data('oid');
				var card 	=	$(this).closest('.card');
				$.post('del_order.php', {oid: oid}, function(data){
					var result = JSON.parse(data);

					if (result['err_msg'] === '-1'){
						alert('登入逾時，請重新登入~!');
						window.location = 'login.php';
					}

					if (result['err_msg'] !== 'OK'){
						toastr.error(result.err_msg);
						return;
					}

					$(card).remove();

				});
			}

		});

		get_orders(0);

		$('#date_range').on('click', function(){
			$('#range1, #range2, #search_btn').val('').prop('disabled', true);
			if ($(this).is(':checked')){
				$('#range1, #range2, #search_btn').prop('disabled', false);
			}
		})

		$('#search_btn').on('click', function(){
			var range1 = $('#range1').val();
			var range2 = $('#range2').val();

			if ($.trim(range1) === '' || $.trim(range2) === ''){
				toastr.error('請選擇日期~!');
				return;
			}

		    get_orders(2);

		    $('#pagerow').hide();
		});


		$('#btn_export').on('click', function(){

			$('#excform')[0].reset();

			if ($('#date_range').is(':checked')){

				var range1 = $('#range1').val();
				var range2 = $('#range2').val();

				if ($.trim(range1) === '' || $.trim(range2) === ''){
					toastr.error('請選擇日期~!');
					return;
				}

				$('input[name=range1]').val(range1);
				$('input[name=range2]').val(range2);
				
			}

			$('#excform').submit();

		});

		function get_chart(){
			$.post('get_chart.php', function(data){
				var result = JSON.parse(data);
				// console.log(result.date);
				// console.log(result.visitors);
				// console.log(result.orders);
				put_chart(result.date, result.visitors, result.orders);
			})
		}


		function put_chart(date, visitors, orders){

			var ctxL = document.getElementById("lineChart").getContext('2d');
			var myLineChart = new Chart(ctxL, {
				type: 'line',
					data: {
						labels: date,
						datasets: [{
							label: "訪客數量",
							data: visitors,
							backgroundColor: ['rgba(105, 0, 132, .2)',],
							borderColor: ['rgba(200, 99, 132, .7)',],
							borderWidth: 2
						},{
							label: "訂單數量",
							data: orders,
							backgroundColor: ['rgba(0, 137, 132, .2)',],
							borderColor: ['rgba(0, 10, 130, .7)',],
							borderWidth: 2
						}]
					},
					options: {
					responsive: true
				}
			});
			

		}
		
		get_chart();

		$('#ocount').text('0');

		$('#print_btn').on('click', function(){
			$('#printform').submit();
		})
	</script>