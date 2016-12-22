<!-- main container -->
<div class="content">

  <div class="container-fluid">
    <div id="pad-wrapper" class="users-list">
      <div class="row-fluid header">
        <h3>订单详情</h3>
      </div>
      <div class="row-fluid">
        <p>订单编号：<?php echo $order->order_id ?></p>
        <p>下单用户：<?php echo $order->user_name ?></p>
        <p>收货地址：<?php echo $order->address ?></p>
        <p>订单总价：<?php echo $order->amount ?></p>
        <p>快递方式：<?php echo array_key_exists($order->express_id, \Yii::$app->params['express'])?\Yii::$app->params['express'][$order->express_id]:'' ?></p>
        <p>快递编号：<?php echo $order->express_no ?></p>
        <p>订单状态：<?php echo $order->zhstatus ?></p>
        <p>商品列表：</p>
        <p>
          <?php foreach($order->products as $product): ?>
        <div style="display:inline">
          <img src="http://<?php echo $product->cover ?>-picsmall">
          <?php echo $product->num ?> x <?php echo $product->title ?>
        </div>
        <?php endforeach; ?>
        </p>
      </div>
    </div>
  </div>
</div>
