<?php if(!defined('IN_CRONLITE'))exit(); ?>
<style>
  .shop-mini .input-group-addon{min-width:110px}
  .shop-mini .input-group{border-radius:10px;overflow:hidden;box-shadow:0 6px 16px rgba(17,24,39,.06)}
  .shop-mini .form-control{border-color:rgba(17,24,39,.12)}
  .shop-mini .meta{display:flex;align-items:center;gap:8px;margin:6px 0 12px 0}
  .shop-mini .meta img{width:28px;height:28px;border-radius:6px;object-fit:cover}
  .qty-wrap{display:flex;align-items:center}
  .qty-btn{width:42px;height:42px;border:none;background:linear-gradient(135deg,#667eea,#5a67d8);color:#fff}
  .qty-input{height:42px;text-align:center}
</style>
<div class="shop-mini">
  <div class="meta text-muted">
    <img id="classImg" src="" alt=""/>
    <span id="className">请选择分类</span>
  </div>

  <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon">选择分类</div>
      <select name="cid" id="cid" class="form-control">
        <option value="0">请选择分类</option>
        <?php
        try{
          $rs=$DB->query("SELECT cid,name FROM pre_class ORDER BY sort ASC");
        }catch(Exception $e){
          $rs=$DB->query("SELECT cid,name FROM pre_class");
        }
        while($row=$rs->fetch()){
          echo '<option value="'.(int)$row['cid'].'">'.htmlspecialchars($row['name']).'</option>';
        }
        ?>
      </select>
    </div>
  </div>

  <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon">选择商品</div>
      <select name="tid" id="tid" class="form-control" onChange="getPoint();">
        <option value="0">请选择商品</option>
      </select>
    </div>
  </div>

  <div class="form-group" id="display_price" style="display:block;">
    <div class="input-group">
      <div class="input-group-addon">商品价格</div>
      <input type="text" name="need" id="need" class="form-control" disabled />
    </div>
  </div>

  <div class="form-group" id="display_left" style="display:none;">
    <div class="input-group">
      <div class="input-group-addon">库存数量</div>
      <input type="text" id="leftcount" class="form-control" disabled />
    </div>
  </div>

  <div class="form-group" id="display_num" style="display:none;">
    <label class="text-muted" style="margin-bottom:6px;">下单份数</label>
    <div class="qty-wrap">
      <button type="button" id="num_min" class="qty-btn"><i class="fa fa-minus"></i></button>
      <input id="num" name="num" class="form-control qty-input" type="number" min="1" value="1"/>
      <button type="button" id="num_add" class="qty-btn"><i class="fa fa-plus"></i></button>
    </div>
  </div>

  <div id="inputsname"></div>
  <div id="alert_frame" class="alert alert-warning" style="display:none;"></div>

  <?php if($conf['shoppingcart']==1){?>
  <div class="row">
    <div class="col-xs-6">
      <button class="btn btn-success btn-block" type="button" id="submit_cart_shop"><i class="fa fa-shopping-cart"></i> 加入购物车</button>
    </div>
    <div class="col-xs-6">
      <button type="submit" id="submit_buy" class="btn btn-primary btn-block"><i class="fa fa-credit-card"></i> 立即购买</button>
    </div>
  </div>
  <?php }else{?>
  <button type="submit" id="submit_buy" class="btn btn-primary btn-block"><i class="fa fa-credit-card"></i> 立即购买</button>
  <?php }?>
</div>

