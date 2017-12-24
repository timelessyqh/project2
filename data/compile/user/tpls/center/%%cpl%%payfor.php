<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<?php $this->_compileInclude('menu'); ?>
		</div>
		<div class="span10">
			<ul class="breadcrumb">
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-app">用户中心</a> <span class="divider">/</span></li>
				<li class="active">隐私设置</li>
			</ul>
			<div class="row-fluid">
				<div class="span8">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>订单号</th>
								<th>充值金额</th>
								<th>下单时间</th>
								<th>订单状态</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php $oid = 0;
 foreach($this->tpl_var['orders']['data'] as $key => $order){ 
 $oid++; ?>
							<tr>
								<td><?php echo $order['ordersn']; ?></td>
								<td><?php echo $order['orderprice']; ?></td>
								<td><?php echo date('Y-m-d',$order['ordercreatetime']); ?></td>
								<td><?php echo $this->tpl_var['orderstatus'][$order['orderstatus']]; ?></td>
								<td>
									<div class="btn-group">
										<a class="btn" href="index.php?user-center-payfor-orderdetail&ordersn=<?php echo $order['ordersn']; ?>" title="详细"><em class="icon-th-list"></em></a>
										<?php if($order['orderstatus'] == 1){ ?>
										<a class="btn" href="index.php?user-center-payfor-orderdetail&ordersn=<?php echo $order['ordersn']; ?>" title="支付"><em class="icon-shopping-cart"></em></a>
										<a class="btn ajax" href="index.php?user-center-payfor-remove&ordersn=<?php echo $order['ordersn']; ?>" title="撤单"><em class="icon-remove"></em></a>
										<?php } ?>
									</div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="pagination pagination-right">
						<ul><?php echo $this->tpl_var['orders']['pages']; ?></ul>
					</div>
				</div>
				<div class="span4">
					<form action="index.php?user-center-payfor" method="post">
						<fieldset>
							 <legend>充值</legend>
							 <label>充值金额</label>
							 <input type="text" name="money" type="text" onchange="javascript:$('#moneycoin').html(parseInt($(this).val())*10);" needle="needle" datatype="number" min="1" msg="您最少充值1元，充值数必须为整数"/> 元
							 <span class="help-block">1元 = 10积分，可兑换 <b id="moneycoin">0</b> 积分</span>
							 <button class="btn" type="submit">充值</button>
							 <input type="hidden" name="payforit" value="1" />
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>