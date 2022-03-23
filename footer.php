      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class="col-md-7">
                     <div class="row">
                        <div class="col-lg-6 col-md-12">
                           <div class="hedingh3 text_align_left">
                              <h3>金鼎膳：</h3>
                              <div class="font_footer">有別於一般市售雞精，我們為了要和市場有所區隔，使用大型鬥雞，於好山好水的南投縣，以放牧方式飼養，儘管成本較高，我們也有責任提供廣大消費者最優良的品質。</div>
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                           <div class="hedingh3 text_align_left">
                              <h3>滴雞精益處：</h3>
                              <div class="font_footer">平時忙於工作的您，定期飲用滴雞精有助增強體力、提升免疫力，更能一次補充多種營養素！<br>
                                 還能調節身體的生理機能，對於身體較虛弱的長者或病患，定期飲用滴雞精能提振精神、促進食慾！</div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-5">
                     <div class="row">
                        <div class="col-lg-6 col-md-12">
                           <div class="hedingh3 text_align_left">
                              <h3>追蹤我們</h3>
                              <ul class="menu_footer">
                                 <li><a href="index.html">Facebook</a></li>
                                 <li><a href="about.html">Instagram</a></li>
                                 <li><a href="about.html">Line</a></li>
                              </ul>
                           </div>
                        </div>
                      <!--   <div class="col-lg-6 col-md-12">
                           <div class="hedingh3  text_align_left">
                              <h3>電子報</h3>
                              <form id="colof" class="form_subscri">
                                 <input class="newsl" placeholder="Email" type="text" name="Email">
                                 <button class="subsci_btn">Subscribe</button>
                              </form>
                              <ul class="top_infomation">
                                 <li><i class="fa fa-phone" aria-hidden="true"></i>
                                    電話
                                 </li>
                                 <li><i class="fa fa-envelope" aria-hidden="true"></i>
                                    <a href="Javascript:void(0)">email</a>
                                 </li>
                              </ul>
                           </div>
                        </div> -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
        <div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">購物車</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table class="show-cart table">

                </table>
              </div>
              <div class="modal-footer">
                <button class="clear-cart btn btn-danger">清空購物車</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                <button type="button" class="btn btn-primary" id="GoShopList">下單去</button>
              </div>
            </div>
          </div>
        </div> 
      </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/owl.carousel.min.js"></script>
      <script src="js/bootstrap-datepicker.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/cart.js"></script>
      <script src="js/st/dist/sweetalert2.js"></script>
      <script>
         $('#Login').click(function(){
            var FormData = $('#LoignForm').serialize()
            $.ajax({
               url: "./login.php",
               method:"post",
               data:FormData,
               success: function (response) {
                  if(response == '{"err_msg":"OK"}')
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
                         window.location.reload();
                       }
                     }).then((result) => {
                       /* Read more about handling dismissals below */
                       if (result.dismiss === Swal.DismissReason.timer) {
                         console.log('I was closed by the timer')
                       }
                     })
                  }else{
                    Swal.fire({
                      icon: 'error',
                      title: '帳號或密碼不正確',
                      footer: '<a href="">找回密碼</a>'
                    })
                  }
                },
                error: function (thrownError) {
                  console.log(thrownError);
                }
            });
         });
         $('#Logout').click(function(){
            $.ajax({
               url: "./logout.php",
               method:"post",
               data:FormData,
               success: function (response) {
                  if(response == '{"err_msg":"OK"}')
                  {
                     Swal.fire({
                       title: '登出成功',
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
                         window.location.reload();
                       }
                     }).then((result) => {
                       /* Read more about handling dismissals below */
                       if (result.dismiss === Swal.DismissReason.timer) {
                         console.log('I was closed by the timer')
                       }
                     })
                  }
                },
                error: function (thrownError) {
                  console.log(thrownError);
                }
            });
         });
         $('.removeCart').on("click", function(event) {
            var name = $(this).data('name')
            var price = $(this).data('price')
            shoppingCart.removeItemFromCartAll(name);
            displayCart();
            $.ajax({
                url:"./getproduct.php?action=del",
                method:"post",
                data:{
                price:price,
                name:name
                },success: function (response) {
                location.reload();
                }
            });
        })
      </script>