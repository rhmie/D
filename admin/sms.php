<?php session_start(); ?>
<?php

	if (!isset($_SESSION['bee_admin'])){
	    echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	    exit();
	}

?>

<style>

	.box {
		border: 1px solid gray;
		border-radius: 8px;
	}

</style>

<section class="section text-center" id="sms">


	<div class="row">

		    <div class="col-4">

		    	<div class="p-3 box">
			    	<!-- Default inline 1-->
			    	<div class="custom-control custom-radio custom-control-inline">
			    	  <input type="radio" class="custom-control-input" value="1" id="target1" name="target" checked>
			    	  <label class="custom-control-label" for="target1">全部</label>
			    	</div>

			    	<div class="custom-control custom-radio custom-control-inline">
			    	  <input type="radio" class="custom-control-input" value="4" id="target4" name="target">
			    	  <label class="custom-control-label" for="target4">單獨</label>
			    	</div>

		   		 </div>

		    </div>

	        <div class="col-4 my-auto">

	        		<div id="residence_box" class="input-group">
	        		  <div class="input-group-prepend">
	        		    <label class="input-group-text" for="residence">居住地</label>
	        		  </div>
	        		  <select class="browser-default custom-select finput" id="residence" name="residence">
	        		  	<option value="0" selected>
	        		  		不限地區
	        		  	</option>
	        		    <option value="1">
	        		        基隆市
	        		    </option>
	        		    <option value="2">
	        		        臺北市
	        		    </option>
	        		    <option value="3">
	        		        新北市
	        		    </option>
	        		    <option value="4">
	        		        桃園市
	        		    </option>
	        		    <option value="5">
	        		        新竹市
	        		    </option>
	        		    <option value="6">
	        		        新竹縣
	        		    </option>
	        		    <option value="7">
	        		        苗栗縣
	        		    </option>
	        		    <option value="8">
	        		        臺中市
	        		    </option>
	        		    <option value="9">
	        		        彰化縣
	        		    </option>
	        		    <option value="10">
	        		        南投縣
	        		    </option>
	        		    <option value="11">
	        		        雲林縣
	        		    </option>
	        		    <option value="12">
	        		        嘉義市
	        		    </option>
	        		    <option value="13">
	        		        嘉義縣
	        		    </option>
	        		    <option value="14">
	        		        臺南市
	        		    </option>
	        		    <option value="15">
	        		        高雄市
	        		    </option>
	        		    <option value="16">
	        		        屏東縣
	        		    </option>
	        		    <option value="17">
	        		        臺東縣
	        		    </option>
	        		    <option value="18">
	        		        花蓮縣
	        		    </option>
	        		    <option value="19">
	        		        宜蘭縣
	        		    </option>
	        		  </select>
	        		</div>

	        </div>

	        <div class="col-4 my-auto">
	        	<div id="single" class="d-none">
		        	<div class="input-group flex-center">
		        	  <div class="input-group-prepend">
		        	    <span class="input-group-text">電話</span>
		        	  </div>
		        	  <input type="text" class="form-control" aria-label="phone" id="mobile" name="mobile" aria-describedby="phone">
		        	</div>
	        	</div>
	        </div>


	        <div class="col-12">

	        	<hr>

	        	<div class="md-form">
	        	<p class="mb-0 w-100 text-left">
	        	   <span class="float-right pink-text wcount">0</span><i class="far fa-edit pink-text fa-lg mr-2"></i>內容(70中字內為短訊息)
	        	</p>
	        	    <textarea class="md-textarea pt-3 form-control" id="sms_content" name="sms_content" rows="8" style="font-size: .9rem"></textarea>
	        	</div>

	        	<button id="send_sms" class="btn btn-pink float-right mt-3">送出</button>


	        </div>


	</div>

</section>

<script>


	$('#sms_content').on('input', function(){
	    var md = $(this).closest('.md-form');
	    $('.wcount', md).text($(this).val().length);
	});



	$('#send_sms').on('click', function(){
		var content = $('#sms_content').val();
		var target = $('input[name=target]:checked').val();
		var phone = $('#mobile').val();
		var residence = $('#residence').val();

		$.post('send_sms.php', {content: content, target: target, phone: phone, residence: residence}, function(data){
			var result = JSON.parse(data);

			console.log(result);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result['err_msg'] !== 'OK'){
			    toastr.error(result['err_msg']);
			    return false;
			}

			toastr.success('發送完成~!');

		})
	});


	$('input[name=target]').on('change', function(e){

		$('#single').addClass('d-none');

		if ($('input[name=target]:checked').val() === '4'){
			$('#single').removeClass('d-none');
			$('#residence').val('0');
			$('#residence_box').addClass('d-none');
		} else {
			$('#residence_box').removeClass('d-none');
		}
	});

</script>

