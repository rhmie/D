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
                     <h2>金鼎膳 - 會員註冊</h2>
                  </div>
               </div>
               <div class="col-md-12">
                  <form id="request" class="main_form">
                     <div class="row">
                     	<div class="col-md-6">
                           <input class="form_control text_boxshadow"  minlength="2" placeholder="姓名" type="text" id="name" name="name"> 
                        </div>
                        <div class="col-md-6">
                           <input class="form_control text_boxshadow"  minlength="4" placeholder="請輸入超過四碼帳號" type="text" id="account" name="account"> 
                        </div>
                        <div class="col-md-6">
                           <input class="form_control text_boxshadow"  minlength="6" placeholder="請輸入六碼密碼" type="password" id="password" name="password"> 
                        </div>
                        <div class="col-md-6">
                           <input class="form_control text_boxshadow"  minlength="10" placeholder="手機號碼" type="text" id="phone" name="phone">                          
                        </div>
                        <div class="col-md-12">
                           <input class="form_control text_boxshadow" placeholder="E-mail" type="text" id="email" name="email">                          
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
                           <input type="button" class="send_btn" id="check" value="註冊">
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      <?php include('footer.php') ?>
   </body>
   <script>
	$('#check').click(function(){
		var name = $('#name').val();
		var account = $('#account').val();
		var password = $('#password').val();
		var phone = $('#phone').val();
		var email = $('#email').val();
		// var chkmumber = $('#chkmumber').val();
		var captcha_code = $('#captcha_code').val();
		var phonecheck = /^[0-9]{10}$/g;
		var emailcheck = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var chknum = 0 ; 
		if(name == '' ){
			Swal.fire({
		        icon: 'error',
		        title: '姓名未填寫',
		    })
		    return false;
	    }
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
	    if(phone == '' || phonecheck.test(phone) == false){
			Swal.fire({
		        icon: 'error',
		        title: '手機未填寫 或 填寫不正確',
		    })
		    return false;
	    }
	    if(email == '' || emailcheck.test(email) == false){
			Swal.fire({
		        icon: 'error',
		        title: 'Email未填寫 或 填寫不正確',
		    })
		    return false;
	    }
	  //   if(chkmumber == ''){
			// Swal.fire({
		 //        icon: 'error',
		 //        title: '驗證碼未填寫',
		 //    })
		 //    return false;
	  //   }
	    $.ajax({
	    	url:'chksecurimage.php',
	    	method:"post",
            data:{
            	name:name,
            	captcha_code:captcha_code,
            	email:email,
            	password:password,
            	phone:phone,
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
                       title: '註冊成功',
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
                         window.location.href='login.php';
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
