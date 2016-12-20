<?php
use yii\bootstrap\ActiveForm;
?>
<!-- ============================================================= HEADER : END ============================================================= -->		<!-- ========================================= CONTENT ========================================= -->

<section id="checkout-page">
  <div class="container">
    <div class="col-xs-12 no-margin">
      <section id="shipping-address" style="margin-bottom:100px;margin-top:-10px">
        <h2 class="border h1">收货地址</h2>
        <a href="#" id="createlink">新建联系人</a>
        <?php foreach($addresses as $key => $address): ?>
          <div class="row field-row" style="margin-top:10px">
            <div class="col-xs-12">
              <input onchange="javascript:changeRadio(<?=$address['address_id'];?>)" class="le-radio big address" type="radio" name="address_id" value="<?php echo $address['address_id'] ?>" <?php if ($key == 0) {echo 'checked = "checked"';} ?> />
              <a class="simple-link bold" href="#"><?php echo $address['first_name'].$address['last_name']." ".$address['company']." ".$address['address']. " " . $address['postcode']. " ". $address['email']." ".$address['telephone'] ?></a>
            </div>
            <a style="margin-left:45px" href="<?php echo yii\helpers\Url::to(['address/del', 'address_id' => $address['address_id']]) ?>">删除</a>
          </div><!-- /.field-row -->
        <?php endforeach; ?>
      </section><!-- /#shipping-address -->

      <div class="billing-address" style="display:none;">
        <h2 class="border h1">新建联系人</h2>
        <?php ActiveForm::begin([
          'action' => ['address/add'],
        ]); ?>
        <div class="row field-row">
          <div class="col-xs-12 col-sm-6">
            <label>姓<span style="color:red;">*</span></label>
            <input class="le-input" name="first_name" >
          </div>
          <div class="col-xs-12 col-sm-6">
            <label>名<span style="color:red;">*</span></label>
            <input class="le-input" name="last_name" >
          </div>
        </div><!-- /.field-row -->

        <div class="row field-row">
          <div class="col-xs-12">
            <label>公司名称</label>
            <input class="le-input" name="company" >
          </div>
        </div><!-- /.field-row -->

        <div class="row field-row">
          <div class="col-xs-12 col-sm-6">
            <label>地址<span style="color:red;">*</span></label>
            <input class="le-input" data-placeholder="例如：上海市浦东新区" name="address1" >
          </div>
          <div class="col-xs-12 col-sm-6">
            <label>&nbsp;</label>
            <input class="le-input" data-placeholder="例如：陆家嘴香格里拉酒店2号201室" name="address2" >
          </div>
        </div><!-- /.field-row -->

        <div class="row field-row">
          <div class="col-xs-12 col-sm-4">
            <label>邮编</label>
            <input class="le-input" name="postcode" >
          </div>
          <div class="col-xs-12 col-sm-4">
            <label>电子邮箱地址<span style="color:red;">*</span></label>
            <input class="le-input" name="email" >
          </div>

          <div class="col-xs-12 col-sm-4">
            <label>联系电话<span style="color:red;">*</span></label>
            <input class="le-input" name="telephone" >
          </div>
        </div><!-- /.field-row -->

        <!--<div class="row field-row">
            <div id="create-account" class="col-xs-12">
                <input  class="le-checkbox big" type="checkbox"  />
                <a class="simple-link bold" href="#">新建联系人？</a>
            </div>
        </div>--><!-- /.field-row -->

        <div class="place-order-button">
          <button class="le-button small">新建</button>
        </div><!-- /.place-order-button -->
        <?php ActiveForm::end(); ?>
      </div><!-- /.billing-address -->
      <?php ActiveForm::begin([
        'action' => ['order/confirm'],
        'options'=> ['id' => 'orderconfirm'],
      ]); ?>
      <section id="your-order">
        <h2 class="border h1">您的订单详情</h2>
        <?php $total = 0; ?>
        <?php foreach($products as $product): ?>
          <div class="row no-margin order-item">
            <div class="col-xs-12 col-sm-1 no-margin">
              <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $product['product_id']]) ?>" class="qty"><?php echo $product['product_num'] ?> x</a>
            </div>

            <div class="col-xs-12 col-sm-9 ">

              <div class="title">

                <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $product['product_id']]) ?>" class="thumb-holder">
                  <img class="lazy" alt="" src="http://<?php echo $product['cover'] ?>-picsmall" />
                </a>
                <a style="margin-left:50px" href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $product['product_id']]) ?>"><?php echo $product['title'] ?></a></div>
            </div>

            <div class="col-xs-12 col-sm-2 no-margin">
              <div class="price">￥ <?php echo $product['price'] ?></div>
            </div>
          </div><!-- /.order-item -->
          <?php $total += $product['product_num']*$product['price'] ?>
        <?php endforeach; ?>
      </section><!-- /#your-order -->
      <input type="hidden" name="address_id" value>
      <div id="total-area" class="row no-margin">
        <div class="col-xs-12 col-lg-4 col-lg-offset-8 no-margin-right">
          <div id="subtotal-holder">
            <ul class="tabled-data inverse-bold no-border">
              <li>
                <label>商品总价</label>
                <div style="width:100%;text-align:right" id="total" class="value">￥ <span><?php echo $total ?></span></div>
              </li>
              <li>
                <label>选择快递</label>
                <div style="width:100%;text-align:right" class="value">
                  <div class="radio-group">
                    <?php foreach($express as $k=>$e): ?>
                      <?php $checked = ""; if($k == 2) $checked = "checked" ?>
                      <input class="le-radio express" type="radio" name="express_id" value="<?php echo $k ?>" data="<?php echo $expressPrice[$k] ?>" <?php echo $checked ?>> <div class="radio-label bold"><?php echo $e ?><span class="bold"> ￥ <?php echo $expressPrice[$k] ?></span></div><br>
                    <?php endforeach; ?>
                  </div>
                </div>
              </li>
            </ul><!-- /.tabled-data -->

            <ul id="total-field" class="tabled-data inverse-bold ">
              <li>
                <label>订单总额</label>
                <div class="value" style="width:100%;text-align:right" id="ototal">￥ <span><?php echo $total + 20 ?></span></div>
              </li>
            </ul><!-- /.tabled-data -->

          </div><!-- /#subtotal-holder -->
        </div><!-- /.col -->
      </div><!-- /#total-area -->


      <div class="text-center" id="payment-method-options">
      <div class="btn-group">
        <button type="button" class="btn btn-default"><input class="le-radio " type="radio" name="pay_method" value="alipay" checked> 支付宝支付 </button>
        <div class="btn-group">
          <button type="button" class="btn btn-default"><input class="le-radio " type="radio" name="pay_method" value="alipay"> 微信支付 </button>
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            其它支付方式
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">网银支付</a></li>
            <li><a href="#">信用卡支付</a></li>
          </ul>
        </div>
      </div>
        </div>
        </div>




        <!-- /.payment-method-option -->

      </div><!-- /#payment-method-options -->

      <div class="place-order-button">
        <button class="le-button big">确认订单</button>
      </div><!-- /.place-order-button -->

    </div><!-- /.col -->
  </div><!-- /.container -->
</section><!-- /#checkout-page -->
<!-- ========================================= CONTENT : END ========================================= -->		<!-- ============================================================= FOOTER ============================================================= -->
<input type="hidden" value="<?php echo (int)\Yii::$app->request->get("order_id"); ?>" name="order_id">
<input id="address_id" type="hidden" name="address_id" value="<?=$addresses[0]['address_id'];?>">
<?php ActiveForm::end(); ?>
<script>
  function changeRadio(address_id) {
    $('#address_id').val(address_id);
  }
</script>
