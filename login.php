<?php include('./include.php');?>
<!DOCTYPE html>
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

<html lang="en">
   <?php include('header.php')?>
   <style>
	   	.main_form .form_control
	   	{
	   		color:#495057; 
	   	}
   </style>
      <div class="container">
            <div class="row">
               <div class="col-md-12 ">
                  <div class="titlepage text_align_center">
                     <h2>金鼎膳 - 會員登入</h2>
                  </div>
               </div>
               <div class="col-md-12">
                  <form id="request" class="main_form">
                     <div class="row">
                     	<div class="col-md-6">
                           <input class="form_control text_boxshadow"   placeholder="帳號" type="text" id="account" name="account"> 
                        </div>
                        <div class="col-md-6">
                           <input class="form_control text_boxshadow"   placeholder="密碼" type="password" id="password" name="password"> 
                        </div>
                        <div class="col-md-6">
                        	<input type="text" minlength="6" id="captcha_code" name="captcha_code" class="form_control text_boxshadow" placeholder="圖形驗證碼" required>
                        </div>
                      
                        <div class="col-md-2">
                        	<img id="captcha" class="img-fluid mx-auto" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                        </div>
                        <div class="col-md-3">
                        	<a class="input-group-text" style="width: 20%;" href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false"><i class="fas fa-sync-alt fa-fw"></i></a>
                        </div>
                        <!-- 用於簡訊認證 -->
                        <!--  <div class="col-md-6">
                           <input class="form_control text_boxshadow" placeholder="確認簡訊" type="text" id="chkmumber" name="chkmumber">
                        </div>
                        <div class="col-md-3">
                            <input type="button" id="check" class="send_btn" style="background-color: #0088cc7a;margin:0 0 15px 0;"value='寄送確認簡訊'>          
                        </div> -->
                        <!-- 用於簡訊認證 -->
                        <div class="col-md-12">
                           <input type="button" class="send_btn" id="login" value="登入">
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      <?php include('footer.php') ?>
   </body>
   <script>
	$('#login').click(function(){
		var account = $('#account').val();
		var password = $('#password').val();
		var captcha_code = $('#captcha_code').val();
		var chknum = 0 ; 
		
		if(account == '' ){
			Swal.fire({
		        icon: 'error',
		        title: '帳號未填寫',
		    })
		    return false;
	    }
	    if(password == '' ){
			Swal.fire({
		        icon: 'error',
		        title: '密碼未填寫',
		    })
		    return false;
	    }
	    $.ajax({
	    	url:'chklogin.php',
	    	method:"post",
            data:{
            	captcha_code:captcha_code,
            	password:password,
            	account:account,
            },success: function (response) {
            	if(response !== 'OK'){
            		Swal.fire({
				        icon: 'error',
				        title: response,
				        })
            	}
            	if(response == 'OK')
            	{
            		Swal.fire({
                       title: '登入成功',
                       html: '系統重整，於<b></b>倒數至零後關閉',
                       timer: 1000,
                       timerProgressBar: true,
                       didOpen: () => {
                         Swal.showLoading()
                         const b = Swal.getHtmlContainer().querySelector('b')
                         timerInterval = setInterval(() => {
                           b.textContent = Swal.getTimerLeft()
                         }, 100)
                       },
                       willClose: () => {
                         window.location.href='index.php';
                       }
                     }).then((result) => {
                       /* Read more about handling dismissals below */
                       if (result.dismiss === Swal.DismissReason.timer) {
                         console.log('I was closed by the timer')
                       }
                     })
            	}


            }

	    });
	});
	
</script>
</html>
