<?php 
    include('./include.php');
    $TotalPrice = 0 ;
    $ship = $db->where('id' , '1')->getOne("system");
    $AllProductMoney = 0 ;
    if(isset($_SESSION['bee_name'])){ $bee_name   = $_SESSION['bee_name']  ; }else{ $bee_name   = '';  }  
    if(isset($_SESSION['bee_email'])){ $bee_email  = $_SESSION['bee_email'];  }else{ $bee_email  = '';  }  
    if(isset($_SESSION['bee_phone'])){ $bee_phone  = $_SESSION['bee_phone'] ; }else{ $bee_phone  = '';  }  
    
?>
<!DOCTYPE html>
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<html lang="en">
<?php include('header.php')?>
<link href="css/shoplist.css" rel="stylesheet">
<style>
    .main_form .form_control
    {
        color:#495057; 
    }
.cart-img{width:50px;height:50px}

</style>
<div class="container">
    <div class="row">
        <div style="width:100%">
    <section class="container my-5">
      <div class="h2 text-secondary text-center">上田園農產 結帳流程</div>
      <div class="row mt-3">
        <div class="col-lg-4">
          <div
            class="
              alert alert-secondary
              d-flex
              flex-column
              align-items-center
              alert-rounded
            "
          >
            <small>STEP 1.</small>
            <i class="fas fa-shopping-cart mb-1"></i>
            <p class="h5">確認購物清單</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div
            class="
              alert alert-primary
              d-flex
              flex-column
              align-items-center
              alert-rounded
            "
          >
          
            <small>STEP 2.</small>
            <i class="fas fa-info mb-1"></i>
            <p class="h5">選擇付款方式</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div
            class="
              alert alert-light
              d-flex
              flex-column
              align-items-center
              alert-rounded
            "
          >
            <small>STEP 3.</small>
            <i class="fas fa-check-circle mb-1"></i>
            <p class="h5">完成購買</p>
          </div>
        </div>
      </div>
      <div class="mt-3">
        <div class="card mb-3">
          <div class="card-header" id="cartDetail">
            <div class="d-flex justify-content-around align-items-center">
              <a
                class="btn btn-link btn-block text-left"
                href="#"
                type="button"
                data-toggle="collapse"
                data-target="#collapseCart"
              >
                購物車明細
              </a>
            </div>
          </div>
        </div>
        <div id="collapseCart" class="collapse show" data-parent="#cartDetail">
          <div class="table-responsive my-3">
            <table class="table">
              <thead>
                <th>刪除</th>
                <th colspan="2">品名</th>
                <th>數量</th>
                <th>單位</th>
                <th class="text-right">單價</th>
                <th class="text-right">小計</th>
              </thead>
              <?php foreach($_SESSION['product_item'] as $key => $row ){ ?>
              <?php $price = $row['price'] ; $count = $row['count'] ; $total[$key] = $price * $count ;?>
              <tr v-for="item in cartApi.carts" :key="item.id">
                <td>
                  <a
                    href="#"
                    class="far fa-trash-alt text-danger removeCart" data-price="<?=$row['price']?>" data-name="<?=$row['pname']?>"
                  ></a>
                </td>
                <td class="cart-title"><?=$row['pname']?></td>
                <td>
                  <img
                    src="<?=$row['images']?>"
                    alt="<?=$row['pname']?>"
                    class="cart-img"
                  />
                </td>
                <td>
                  <?=$row['count']?>
                </td>
                <td><?=$row['opts']?></td>
                <td class="text-right"><?=$row['price']?></td>
                <td class="text-right">NT$<?=$total[$key]?></td>
              </tr>
              <?php $AllProductMoney += $total[$key]; ?>
              <?php } ?>
              <?php if($ship['free_ship'] < $AllProductMoney){ $ship = 0 ; }else{ $ship = $ship['ship'] ; } ?>
              <tr>
                <td class="text-right" colspan="6">運費</td>
                <td class="text-right"><?=$ship?></td>
              </tr>

              <tr>
                <td class="text-right" colspan="6">總計</td>
                <td class="text-right pricetotal" >
                  <?=$AllProductMoney + $ship?>
                </td>
              </tr>
              <tr>
                <td class="text-right text-success" colspan="6" >折扣價</td>
                <td class="text-right text-success discheck"><?=$AllProductMoney + $ship?></td>
              </tr>
            </table>
            <div class="input-group">
                <input type="text" class="form-control conup" id="couponCode" v-model="couponCode" />
              <div class="input-group-append">
                <a href="#" class="btn btn-outline-success useCoupon" >套用優惠券
                  <i class="fas fa-circle-notch fa-spin"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
        <div class="h3 bg-light text-center text-secondary py-3">
          選擇付款方式
        </div>
                <div class="text-center mt-3" v-if="!order.is_paid">
          <div class="h5 pb-2">選擇付款方式</div>
          <form @submit.prevent="payOrder">
            <div class="form-check form-check-inline">
              <input
                class="form-check-input"
                type="radio"
                name="payment"
                id="creditCard"
                value="card"
                v-model="payMethod"
              />
              <label class="form-check-label" for="creditCard"> 宅配線上付款 </label>
            </div>
            <div class="form-check form-check-inline">
              <input
                class="form-check-input"
                type="radio"
                name="payment"
                id="webATM"
                value="ATM"
                v-model="payMethod"
              />
              <label class="form-check-label" for="webATM"> 超商取貨線上付款 </label>
            </div>
              <?php if(isset($_SESSION['bee_name']) AND isset($_SESSION['bee_phone'])){ ?>
            
            <div class="form-check form-check-inline">
              <input
                class="form-check-input"
                type="radio"
                name="payment"
                id="cash"
                value="paycash"
                v-model="payMethod"
              />
              <label class="form-check-label" for="cash"> 到店付現 </label>
            </div>
            <div class="form-check form-check-inline">
              <input
                class="form-check-input"
                type="radio"
                name="payment"
                id="linePay"
                value="LinePay"
                v-model="payMethod"
              />
              <label class="form-check-label" for="linePay"> LinePay </label>
            </div>
          <?php } ?>
        <!-- validation-observer(針對整個表單驗證)、validation-provider(針對單一input) -->
        <!-- <validation-observer v-slot="{ invalid }">
          <form @submit.prevent="sendOrder">
            <div class="form-row">
              <div class="form-group col-md-6">
                <validation-provider rules="required"  v-slot="{ errors, classes }" >
                  <label for="name"  >訂購人姓名 <span class="text-danger">*</span></label  >
                  <input type="text"  class="form-control"  name="name"  id="name" placeholder="請輸入姓名"  value="<?=$bee_name?>" />
                  <span class="invalid-feedback">{{ errors[0] }}</span>
                </validation-provider>
              </div>
              <div class="form-group col-md-6">
                <validation-provider  rules="required|email">
                  <label for="email" >訂購人Email <span class="text-danger">*</span></label >
                  <input type="text"  class="form-control"  name="email"  id="email" placeholder="請輸入email"  value="<?=$bee_email?>"  />
                  <span class="invalid-feedback">{{ errors[0] }}</span>
                </validation-provider>
              </div>
            </div>
            <div class="form-row">
              <validation-provider class="form-group col-md-6" rules="required">
                <div>
                  <label for="tel">連絡電話 <span class="text-danger">*</span></label >
                  <input
                    class="form-control" type="tel" name="tel"  id="tel" value="<?=$bee_phone?>" />
                  <span class="invalid-feedback">{{ errors[0] }}</span>
                </div>
              </validation-provider>
            </div>

            <div class="form-group">
              <label for="address" >寄送地址 <small class="ml-2">請輸入詳細地址</small></label >
              <input type="text" class="form-control"  name="address" id="address" placeholder="路名、樓層等等" />
            </div>
            <div class="form-group">
              <label for="message">留言</label>
              <textarea  name="留言區" id="message"  class="form-control"  cols="20" rows="5" placeholder="有什麼特殊需求嗎?" ></textarea>
            </div>-->
            <div class="d-flex justify-content-end">
              <input type="button" class="btn btn-primary" id="finsh" value="下一步">
            </div>
          <!-- </form> -->
        <!-- </validation-observer>  -->
      </div>
    </section>
        </div>
    </div>
</div>
<?php include('footer.php') ?>
<script>
$('.useCoupon').click(function(){
    var discode = $(".conup").val();
    var pricetotal = $('.pricetotal').text();
    $.ajax({
        url:"./getdiscount.php",
        method:"post",
        data:{
        discode:discode
        },success: function (response) {
            $('.discheck').empty();
            if(response !== '無此優惠碼'){
                finalprice = response * parseInt(pricetotal)/100 ;
                $('.discheck').text(finalprice);
            }else{
                $('.discheck').text(response);
            }
        }
    });
});
$('#finsh').click(function(){
    var payment = $('.form-check-input').val();
    var name    = $('#name').val();
    var tel     = $('#tel').val();
    var email   = $('#email').val();
    var address = $('#address').val();
    var message = $('#message').val();
    var couponCode = $('#couponCode').val();
    var pricetotal = $('.pricetotal').text();
    var disprice = $('.discheck').text();
    $.ajax({
        url:"./finshorder.php",
        method:"post",
        data:{
            name:name,
            tel:tel,
            email:email,
            address:address,
            message:message,
            couponCode:couponCode,
            pricetotal:pricetotal,
            disprice:disprice,
            payment:payment,
        },success: function (response) {
            
        }
    });
});
</script>
</body>
</html>