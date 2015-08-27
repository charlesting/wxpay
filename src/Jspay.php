<?php

namespace CT\Wxpay\src;

use CT\Wxpay\lib\WxPayApi;
use CT\Wxpay\lib\WxPayUnifiedOrder;
use CT\Wxpay\lib\JsApiPay;
use CT\Wxpay\lib\WxPayConfig;

class Jspay
{

	public function create(){
		ini_set('date.timezone','Asia/Shanghai');
		error_reporting(E_ALL & ~E_NOTICE);
		require_once dirname(__FILE__)."/../lib/WxPay.Api.php";

		require_once dirname(__FILE__)."/../lib/WxPay.JsApiPay.php";

//①、获取用户openid
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();
//②、统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody("test");
		$input->SetAttach("test");
		$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee("1");
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url("http://koudaileyuan.com/buy/notify");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openId);
		$order = WxPayApi::unifiedOrder($input);
		//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
		//print_r($order);
		$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
		$editAddress = $tools->GetEditAddressParameters();

		return array(
			"jsApiParameters" => "$jsApiParameters",
			"editAddress" => "$editAddress"
		);

	}

	function printf_info($data){
		foreach($data as $key=>$value){
			echo "<font color='#00ff55;'>$key</font> : $value <br/>";
		}
	}


}