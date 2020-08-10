@extends('layouts.theme')
@section('head-style')

<style type="text/css">
.cash-deposit-area {
	height: 3rem;
	line-height: 3rem;
	font-size: 0.8rem;
	padding-left: 1em;
	padding-right: 1em;
}

.cash-deposit-area label {
	padding-right: 0.2rem;
}

.cash-deposit-highlight {
	color: #c3606a;
	display: inline-block;
	font-weight: bold;
	font-size: 0.6rem;
}

.switch-payee {
	color: #0062cc;
	font-size: 1rem;
	font-weight: bold;
	float: right;
}

.receive-order-channel-area {
	box-shadow: 0px 0px 6px #545b62;
	padding-top: 0.4rem;
	font-size: 14px;
	margin-left: 0.4rem;
	margin-right: 0.4rem;
	padding-bottom: 0.1rem;
	padding-left: 0.2rem;
}

.receive-order-channel {
	box-shadow: 0px 1px 4px #908484;
	height: 1.8rem;
	line-height: 1.8rem;
	margin-bottom: 0.3rem;
	margin-left: 0.5rem;
	margin-right: 0.5rem;
}

.channel-rebate {
	min-width: 7rem;
	padding-left: 1rem;
	text-align: end;
}

.channel-state {
	display: inline-block;
	color: #17a2b8;
	font-weight: bold;
	float: right;
	padding-right: 1rem;
}

.suspend-receive-order {
	padding-top: 2rem;
}

.receive-order-action {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
}

.receive-order-action-body {
	border-radius: 50%;
	background: linear-gradient(120deg, #fed176, #fd8793);
	text-align: center;
	height: 12rem;
	width: 12rem;
	line-height: 12rem;
	color: #fff;
	font-weight: bold;
	font-size: 1.6rem;
}

.receive-order {
	padding-top: 1rem;
}

.suspend-receive-order-action {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	padding-bottom: 1rem;
}

.suspend-receive-order-action-body {
	border-radius: 50%;
	background: linear-gradient(120deg, #fed176, #fd8793);
	text-align: center;
	height: 8rem;
	width: 8rem;
	line-height: 8rem;
	color: #e45d5d;
	font-weight: bold;
	font-size: 1.4rem;
}

.form-details {
	background: rgb(242, 242, 242);
}

.switch-payee-action-area {
	padding-top: 3rem;
	padding-left: 2rem;
	padding-right: 2rem;
}

.switch-payee-action-area button {
	margin-bottom: 1rem;
}

.in-use-state {
	position: absolute;
	width: 3.5rem;
	height: 3.5rem;
	font-size: 40px;
	z-index: 5;
	right: 1rem;
}

.confirm-selected-payee-action {
	position: fixed;
	background-color: #007bff;
	width: 3.5rem;
	height: 3.5rem;
	line-height: 3.5rem;
	color: #f8f9fa;
	display: flex;
	justify-content: center;
	z-index: 5;
	right: 7rem;
	bottom: 8rem;
	border-radius: 50%;
	box-shadow: 0 0 6px rgba(53, 53, 53, 0.12);
}

.back-receive-order-action {
	position: fixed;
	background-color: #dc3545;
	width: 3.5rem;
	height: 3.5rem;
	line-height: 3.5rem;
	color: #f8f9fa;
	display: flex;
	justify-content: center;
	z-index: 5;
	right: 2rem;
	bottom: 8rem;
	border-radius: 50%;
	box-shadow: 0 0 6px rgba(53, 53, 53, 0.12);
}

.auto-receive-order {
	display: flex;
	justify-content: flex-end;
	padding-top: 0.5rem;
	padding-right: 1rem;
	padding-top: 0.5rem;
}

.city {
	color: #0062cc;
	font-weight: bold;
	width: 60%;
	display: inline-block;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;
}

#select-city-modal select {
	width: 100%;
	text-align: center;
	text-align-last: center;
	margin-bottom: 1rem;
}

.common-nav-item {
	font-size: 12px;
}



</style>

@endsection
@section('others')


	<div id="receiveOrder" v-cloak>
		<div class="page-body" v-show="showReceiveOrderPageFlag">
			<div class="cash-deposit-area">
				<label>保证金:</label><span class="cash-deposit-highlight">@{{cashDeposit}}@{{global.systemSetting.currencyUnit}}</span>
				<template v-if="freezeAmount > 0"> <label>冻结:</label> <span class="cash-deposit-highlight">@{{freezeAmount}}@{{global.systemSetting.currencyUnit}}</span> </template>
				<span class="switch-payee" v-on:click="showSwitchPayeePage">切换收款码</span>
			</div>
			<div class="receive-order-channel-area">
				<div class="receive-order-channel" v-for="channel in channels">
					<label class="channel-rebate">@{{channel.channelName}}</label><span class="channel-state">@{{channel.stateName}}</span>
				</div>
			</div>
			<div style="margin-left: 0.5rem; margin-right: 1rem; padding-top: 0.5rem; height: 1.5rem;">
				<div class="city" v-show="dispatchMode" v-on:click="showSelectCityModal">@{{this.province == null || this.province == '' ? '请选择接单城市' : this.province + this.city}}</div>
				<div style="float: right;" v-show="!dispatchMode && openAutoReceiveOrder && receiveOrderState == '1'">
					<div class="custom-control custom-checkbox" style="display: inline-block;">
						<input type="checkbox" class="custom-control-input" id="autoReceiveOrderFlag" v-model="autoReceiveOrderFlag"> <label class="custom-control-label" for="autoReceiveOrderFlag">自动接单</label>
					</div>
				</div>
				<div style="float: right; color: #007bff; font-weight: bold;" v-show="dispatchMode && receiveOrderState == '1'">
					排在第<span>@{{queueRanking}}</span>位
				</div>
			</div>
			<div class="suspend-receive-order" v-show="receiveOrderState == '2'">
				<div class="receive-order-action">
					<div class="receive-order-action-body" v-on:click="updateReceiveOrderState('1')">开始接单</div>
				</div>
			</div>
			<div class="receive-order" v-show="receiveOrderState == '1'">
				<div class="suspend-receive-order-action">
					<div class="suspend-receive-order-action-body" v-on:click="updateReceiveOrderState('2')">停止接单</div>
				</div>
				<div class="platform-order-list-area">
					<div class="form-details" v-for="order in waitReceivingOrders">
						<div class="form-details-body">
							<div class="form-details-item form-details-item-sm" v-show="order.attch != null && order.attch != ''">
								<label>会员id:</label> <span>@{{order.attch}}</span>
							</div>
							<div class="form-details-item form-details-item-sm">
								<label>通道:</label> <span>@{{order.gatheringChannelName}}</span><label>金额:</label> <span class="form-details-item-highlight">@{{order.gatheringAmount}}@{{global.systemSetting.currencyUnit}}</span>
							</div>
							<div class="form-details-item form-details-item-sm">
								<button class="btn btn-outline-info btn-lg" type="button" v-on:click="receiveOrder(order.id)">立即接单</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="page-body" v-show="showSwitchPayeePageFlag">
			<ul class="nav nav-tabs nav-justified">
				<li class="nav-item common-nav-item" v-for="channel in channels" v-bind:class="{'common-nav-item-active': channel.channelId == gatheringChannelId}"
					v-on:click="gatheringChannelId = channel.channelId"><a class="nav-link">@{{channel.channelName}}<span style="float: right; font-size: 12px;">@{{channel.rebate}}</span></a></li>
			</ul>
			<div class="form-details" v-for="gatheringCode in gatheringCodes" v-show="gatheringChannelId == gatheringCode.gatheringChannelId">
				<div class="form-details-body" v-on:click="gatheringCode.inUse = !gatheringCode.inUse">
					<div class="form-details-item form-details-item-sm" v-if="gatheringCode.gatheringChannelCode == 'wechat' || gatheringCode.gatheringChannelCode == 'alipay'">
						<label>收款人:</label> <span class="form-details-item-highlight">@{{gatheringCode.payee}}</span>
					</div>
					<div class="form-details-item form-details-item-sm" v-if="gatheringCode.gatheringChannelCode == 'bankCard'">
						<label>银行:</label> <span class="form-details-item-highlight">@{{gatheringCode.openAccountBank}}</span><label>开户人:</label> <span class="form-details-item-highlight">@{{gatheringCode.accountHolder}}</span>
					</div>
					<div class="form-details-item form-details-item-sm" v-if="gatheringCode.gatheringChannelCode == 'bankCard'">
						<label>卡号:</label> <span class="form-details-item-highlight">@{{gatheringCode.bankCardAccount}}</span>
					</div>
					<div class="form-details-item form-details-item-sm" v-if="gatheringCode.gatheringChannelCode == 'wechatMobile'">
						<label>手机号:</label> <span class="form-details-item-highlight">@{{gatheringCode.mobile}}</span><label>姓名:</label> <span class="form-details-item-highlight">@{{gatheringCode.realName}}</span>
					</div>
					<div class="form-details-item form-details-item-sm" v-if="gatheringCode.gatheringChannelCode == 'alipayTransfer'">
						<label>账号:</label> <span class="form-details-item-highlight">@{{gatheringCode.account}}</span><label>姓名:</label> <span class="form-details-item-highlight">@{{gatheringCode.realName}}</span>
					</div>
					<div class="form-details-item form-details-item-sm" v-if="gatheringCode.gatheringChannelCode == 'alipayIdTransfer'">
						<label>账号/支付宝id:</label> <span class="form-details-item-highlight">@{{gatheringCode.account}}/@{{gatheringCode.alipayId}}</span>
					</div>
					<div class="form-details-item form-details-item-sm" v-if="gatheringCode.minAmount != null">
						<label>单笔限额: </label> <span>@{{gatheringCode.minAmount}}-@{{gatheringCode.maxAmount}}</span>
					</div>
					<div class="form-details-item form-details-item-sm">
						<label>累计收款: </label> <span>@{{gatheringCode.totalTradeAmount + global.systemSetting.currencyUnit}}</span><label>收款次数:</label> <span>@{{gatheringCode.totalPaidOrderNum}}次</span>
					</div>
					<div class="form-details-item form-details-item-sm">
						<label>今日收款: </label> <span>@{{gatheringCode.todayTradeAmount + global.systemSetting.currencyUnit}}</span><label>收款次数:</label> <span>@{{gatheringCode.todayPaidOrderNum}}次</span>
					</div>
				</div>
				<div class="in-use-state">
					<label style="color: #5FC400;" v-show="gatheringCode.inUse">✔</label> <label v-show="!gatheringCode.inUse">✖</label>
				</div>
			</div>
			<div class="confirm-selected-payee-action" v-on:click="switchGatheringCode">
				<label>确认</label>
			</div>
			<div class="back-receive-order-action" v-on:click="showReceiveOrderPage">
				<label>返回</label>
			</div>
		</div>
		<template v-if="receiveOrderSound && playAudioFlag"> <iframe autoplay="autoplay" src="audio/ring.wav" style="display: none;"></iframe> </template>
		<template v-if="receiveOrderSound && receiveOrderSuccessFlag"> <iframe autoplay="autoplay" src="audio/receiveOrderSuccess.mp3" style="display: none;"></iframe> </template>
		<div id="select-city-modal" v-cloak>
			<div v-if="selectCityFlag">
				<div class="modal-mask">
					<div class="modal-wrapper">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body">
									<div style="height: 2rem;">
										<label>选择接单城市</label>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="selectCityFlag = false">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div style="padding-top: 3rem; padding-bottom: 3rem; height: 10rem;">
										<div class="area-picker">
											<select class="form-control-sm province-select"></select> <select class="form-control-sm city-select"></select>
										</div>
									</div>
									<button type="button" class="btn btn-lg btn-danger btn-block" v-on:click="updateCityInfo">保存</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<html>
<head>
<style>
.view-system-notice-dialog {
	max-width: 100%;
	width: 96%;
}

.view-system-notice-dialog .modal-body {
	height: 25rem;
	overflow: auto;
}

.view-notice {
	margin-bottom: 0rem;
}

.notice-title {
	text-align: center;
	font-size: 18px;
	font-weight: bold;
	overflow: hidden;
}

.notice-publish-time {
	text-align: center;
}

.notice-content {
	height: 14rem;
	overflow: auto;
}
</style>
</head>

<body>
	<div id="view-system-notice-modal" v-cloak>
		<div v-show="showViewNoticeFlag">
			<div class="modal-mask">
				<div class="modal-wrapper">
					<div class="modal-dialog view-system-notice-dialog">
						<div class="modal-content">
							<div class="modal-body">
								<div style="height: 1.5rem;">
									<label><i class="fa fa-volume-up" aria-hidden="true"></i></label>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="showViewNoticeFlag = false">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="view-notice">
									<div class="notice-title">@{{systemNotice.title}}</div>
									<div class="notice-publish-time">@{{systemNotice.publishTime}}</div>
									<div class="notice-content" v-html="systemNotice.content"></div>
								</div>
								<button type="button" class="btn btn-lg btn-danger btn-block" v-on:click="markRead(systemNotice.id)">我知道了</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var viewSystemNoticeModal = new Vue({
			el : '#view-system-notice-modal',
			data : {
				showViewNoticeFlag : false,
				systemNotice : {}
			},
			computed : {},
			created : function() {
			},
			methods : {

				viewNoticeContent : function(systemNotice) {
					this.systemNotice = systemNotice;
					this.showViewNoticeFlag = true;
				},

				getLatestNotice : function() {
					var that = this;
					that.$http.get('/systemNotice/getLatestNotice').then(function(res) {
						var systemNotice = res.body.data;
						if (systemNotice != null) {
							that.systemNotice = systemNotice;
							that.showViewNoticeFlag = true;
						}
					});
				},

				markRead : function(id) {
					var that = this;
					that.$http.get('/systemNotice/markRead', {
						params : {
							id : id
						}
					}).then(function(res) {
						that.showViewNoticeFlag = false;
					});
				}
			}
		});
	</script>
</body>
</html>
	<html>
<link href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<head>
<style>
.footer-navbar {
	padding-top: 0.2rem;
	padding-bottom: 0.2rem;
	height: 4.5rem;
}

.footer-navbar-brand {
	text-align: center;
	color: #838793 !important;
	padding-top: 0rem;
	padding-bottom: 0rem;
}

.selected-footer-navbar-brand {
	color: #d22018 !important;
}

.footer-navbar-brand span {
	font-size: 1rem;
}

.footer-navbar-brand .fa {
	display: block;
	font-size: 2rem;
}
</style>
</head>
<body>
	<div id="footer" v-cloak>
		<nav class="navbar fixed-bottom bg-light footer-navbar" v-show="showFooterFlag">
			<a class="navbar-brand footer-navbar-brand" v-show="global.systemSetting.showRankingListFlag" v-on:click="goTo('/ranking-list')" v-bind:class="{'selected-footer-navbar-brand': currentPathName == '/ranking-list'}"><i class="fa fa-star" aria-hidden="true"></i> <span>排行榜</span> </a>
			<a class="navbar-brand footer-navbar-brand" v-on:click="goTo('/receive-order')" v-bind:class="{'selected-footer-navbar-brand': currentPathName == '/receive-order'}"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>接单</span></a>
			<a class="navbar-brand footer-navbar-brand" v-on:click="goTo('/audit-order')" v-bind:class="{'selected-footer-navbar-brand': currentPathName == '/audit-order'}"><i class="fa fa-hourglass" aria-hidden="true"></i><span>审核</span></a>
			<a class="navbar-brand footer-navbar-brand" v-on:click="goTo('/my-home-page')" v-bind:class="{'selected-footer-navbar-brand': currentPathName == '/my-home-page'}"><i class="fa fa-user" aria-hidden="true"></i><span>我的</span></a>
		</nav>
	</div>
	<script type="text/javascript">
		var footerVM = new Vue({
			el : '#footer',
			data : {
				global : GLOBAL,
				currentPathName : '',
				showFooterFlag : true
			},
			computed : {},
			created : function() {
				this.currentPathName = window.location.pathname;
			},
			methods : {
				goTo : function(url) {
					window.location.href = url;
				}
			}
		});
	</script>
</body>
</html>
	<link href="/css/common/theme-brown.css" rel="stylesheet" type="text/css">
	<script type="text/javascript">
		var receiveOrderVM = new Vue({
			el : '#receiveOrder',
			data : {
				global : GLOBAL,
				receiveOrderSound : false,
				openAutoReceiveOrder : false,
				dispatchMode : false,
				gatheringChannelId : '',
				cashDeposit : '',
				freezeAmount : 0,
				channels : [],
				receiveOrderState : '',
				autoReceiveOrderFlag : sessionStorage.getItem('autoReceiveOrderFlag') == null ? false : sessionStorage.getItem('autoReceiveOrderFlag') == 'true',
				waitReceivingOrders : [],
				receiveOrderOrDispatchOrderInterval : null,
				getQueueRankingInterval : null,
				queueRanking : '',
				playAudioFlag : false,
				receiveOrderSuccessFlag : false,
				showReceiveOrderPageFlag : true,
				showSwitchPayeePageFlag : false,
				gatheringCodes : [],
				selectCityFlag : false,
				province : '',
				city : '',
			},
			watch : {
				autoReceiveOrderFlag : function(val) {
					sessionStorage.setItem('autoReceiveOrderFlag', val);
				},
			},
			computed : {},
			created : function() {
			},
			mounted : function() {
				headerVM.title = '接单';
				this.loadReceiveOrderSoundSetting();
				this.getCashDeposit();
				this.getFreezeAmount();
				this.getCityInfo();
				this.loadReceiveOrderChannel();
				this.getReceiveOrderState();
				viewSystemNoticeModal.getLatestNotice();
			},
			methods : {

				loadReceiveOrderSoundSetting : function() {
					var that = this;
					that.$http.get('/masterControl/getReceiveOrderSetting').then(function(res) {
						that.receiveOrderSound = res.body.data.receiveOrderSound;
						that.openAutoReceiveOrder = res.body.data.openAutoReceiveOrder;
						that.dispatchMode = res.body.data.dispatchMode;
					});
				},

				getCityInfo: function() {
					var that = this;
					that.$http.get('/userAccount/getCityInfo').then(function(res) {
						that.province = res.body.data.province;
						that.city = res.body.data.city;
					});
				},

				showSelectCityModal : function() {
					this.selectCityFlag = true;
					this.$nextTick(() => {
						$('.area-picker').distpicker({
							province : this.province == null ? '---- 所在省 ----' : this.province,
							city : this.city == null ? '---- 所在市 ----' : this.city
						});
		            });
				},

				updateCityInfo : function() {
					var that = this;
					var province = $('.province-select').val();
					if (province == null || province == '') {
						layer.alert('请选择所在省', {
							title : '提示',
							icon : 7,
							time : 3000
						});
						return;
					}
					var city = $('.city-select').val();
					var cityCode = $('.city-select').find('option:selected').attr('data-code');
					if (cityCode == null || cityCode == '') {
						layer.alert('请选择所在市', {
							title : '提示',
							icon : 7,
							time : 3000
						});
						return;
					}
					that.$http.post('/userAccount/updateCityInfo', {
						province : province,
						city : city,
						cityCode : cityCode
					}, {
						emulateJSON : true
					}).then(function(res) {
						layer.alert('操作成功!', {
							icon : 1,
							time : 2000,
							shade : false
						});
						that.selectCityFlag = false;
						that.getCityInfo();
					});
				},

				switchGatheringCode : function() {
					var that = this;
					var selectedGatheringCodeIds = [];
					for (var i = 0; i < that.gatheringCodes.length; i++) {
						if (that.gatheringCodes[i].inUse) {
							selectedGatheringCodeIds.push(that.gatheringCodes[i].id);
						}
					}
					that.$http.post('/gatheringCode/switchGatheringCode', selectedGatheringCodeIds).then(function(res) {
						layer.alert('操作成功!', {
							icon : 1,
							time : 2000,
							shade : false
						});
						that.showReceiveOrderPage();
						that.loadReceiveOrderChannel();
					});
				},

				showSwitchPayeePage : function() {
					this.showReceiveOrderPageFlag = false;
					this.showSwitchPayeePageFlag = true;
					if (this.channels.length > 0) {
						this.gatheringChannelId = this.channels[0].channelId;
					}
					this.loadAllGatheringCode();
				},

				loadAllGatheringCode : function() {
					var that = this;
					that.$http.get('/gatheringCode/findAllNormalGatheringCode').then(function(res) {
						that.gatheringCodes = res.body.data;
					});
				},

				showReceiveOrderPage : function() {
					this.showReceiveOrderPageFlag = true;
					this.showSwitchPayeePageFlag = false;
				},

				loadReceiveOrderChannel : function() {
					var that = this;
					that.$http.get('/userAccount/findMyReceiveOrderChannel').then(function(res) {
						that.channels = res.body.data;
					});
				},

				updateReceiveOrderState : function(receiveOrderState) {
					var that = this;
					that.$http.post('/userAccount/updateReceiveOrderState', {
						receiveOrderState : receiveOrderState
					}, {
						emulateJSON : true
					}).then(function(res) {
						that.getReceiveOrderState();
					});
				},

				getCashDeposit : function() {
					var that = this;
					that.$http.get('/userAccount/getUserAccountInfo').then(function(res) {
						that.cashDeposit = res.body.data.cashDeposit;
					});
				},

				getFreezeAmount : function() {
					var that = this;
					that.$http.get('/userAccount/getFreezeAmount').then(function(res) {
							that.freezeAmount = res.body.data;
					});
				},

				getReceiveOrderState : function() {
					var that = this;
					that.$http.get('/userAccount/getUserAccountInfo').then(function(res) {
						that.receiveOrderState = res.body.data.receiveOrderState;
						that.receiveOrderOrDispatchOrder();
					});
				},

				checkStopReceiveOrderState : function() {
					var that = this;
					that.$http.get('/userAccount/getUserAccountInfo').then(function(res) {
						that.receiveOrderState = res.body.data.receiveOrderState;
						if (that.receiveOrderState == '2') {
							window.clearInterval(that.receiveOrderOrDispatchOrderInterval);
							that.receiveOrderOrDispatchOrderInterval = null;
						}
					});
				},

				getQueueRanking : function() {
					var that = this;
					that.$http.get('/merchantOrder/getQueueRanking').then(function(res) {
						that.queueRanking = res.body.data;
					});
				},

				receiveOrderOrDispatchOrder : function() {
					var that = this;
					if (that.dispatchMode) {
						if (that.receiveOrderState == '1') {
							that.dispatchOrderTip();
							that.receiveOrderOrDispatchOrderInterval = window.setInterval(function() {
								that.checkStopReceiveOrderState();
								that.dispatchOrderTip();
							}, 5000);
							that.getQueueRanking();
							that.getQueueRankingInterval = window.setInterval(function() {
								that.getQueueRanking();
							}, 5000);
						} else if (that.receiveOrderState == '2') {
							headerVM.title = '接单';
							window.clearInterval(that.receiveOrderOrDispatchOrderInterval);
							that.receiveOrderOrDispatchOrderInterval = null;
						}
					} else {
						if (that.receiveOrderState == '1') {
							that.loadPlatformOrder();
							that.receiveOrderOrDispatchOrderInterval = window.setInterval(function() {
								that.checkStopReceiveOrderState();
								that.loadPlatformOrder();
							}, 6000);
						} else if (that.receiveOrderState == '2') {
							headerVM.title = '接单';
							that.waitReceivingOrders = [];
							window.clearInterval(that.receiveOrderOrDispatchOrderInterval);
							that.receiveOrderOrDispatchOrderInterval = null;
						}
					}
				},

				dispatchOrderTip : function() {
					var that = this;
					that.receiveOrderSuccessFlag = false;
					headerVM.title = '正在获取订单...';
					that.$http.get('/merchantOrder/dispatchOrderTip').then(function(res) {
						var tip = res.body.data;
						if (tip == null) {
							headerVM.title = '暂无最新订单';
							return;
						}
						that.dispatchOrderTipMarkRead(tip.id);
						if (tip.note == '接单成功') {
							layer.alert('接单成功,请及时审核', {
								icon : 1,
								time : 2000,
								shade : false
							});
							that.receiveOrderSuccessFlag = true;
							that.getFreezeAmount();
							that.getCashDeposit();
							return;
						}
						layer.alert(tip.note, {
							icon : 1,
							time : 2000,
							shade : false
						});
					});
				},

				dispatchOrderTipMarkRead : function(id) {
					var that = this;
					that.$http.get('/merchantOrder/dispatchOrderTipMarkRead').then(function(res) {
					});
				},

				loadPlatformOrder : function() {
					var that = this;
					that.playAudioFlag = false;
					headerVM.title = '正在获取订单...';
					that.$http.get('/merchantOrder/findMyWaitReceivingOrder').then(function(res) {
						that.waitReceivingOrders = res.body.data;
						if (that.waitReceivingOrders == null || that.waitReceivingOrders.length == 0) {
							headerVM.title = '暂无最新订单';
						} else {
							that.playAudioFlag = true;
							headerVM.title = '已获取最新订单';
							that.toAutoReceiveOrder();
						}
					});
				},

				toAutoReceiveOrder : function() {
					if (!this.autoReceiveOrderFlag) {
						return;
					}
					var randomOrder = this.waitReceivingOrders[Math.floor(Math.random() * this.waitReceivingOrders.length + 0)];
					this.receiveOrder(randomOrder.id);
				},

				receiveOrder : function(orderId) {
					var that = this;
					layer.msg('拼命抢单中', {
						icon : 16,
						shade : 0.01,
						time : 3500
					});
					that.receiveOrderSuccessFlag = false;
					that.$http.get('/merchantOrder/receiveOrder', {
						params : {
							orderId : orderId
						}
					}).then(function(res) {
						layer.alert('接单成功,请及时审核', {
							icon : 1,
							time : 2000,
							shade : false
						});
						that.receiveOrderSuccessFlag = true;
						that.getFreezeAmount();
						that.getCashDeposit();
						that.waitReceivingOrders = [];
						setTimeout(function() {
							that.loadPlatformOrder();
						}, 4000);
					});
				}
			}
		});
	</script>
</body>
</html>
@endsection
