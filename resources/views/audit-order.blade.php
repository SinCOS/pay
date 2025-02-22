@extends('layouts.theme')
@section('head-style')
<style type="text/css">
    .form-details {
        background: rgb(242, 242, 242);
    }

    .platform-order-body-item button {
        width: 48%;
    }
    </style>
@endsection

@section('others')
<div id="auditOrder" v-cloak>
    <div class="page-body">
        <div v-show="showWaitConfirmOrderFlag">
            <div class="form-details" v-for="order in waitConfirmOrders">
                <div class="form-details-body">
                    <div class="form-details-item form-details-item-sm">
                        <label>订单号:</label> <span>@{{order.orderNo}}</span>
                    </div>
                    <div class="form-details-item form-details-item-sm" v-show="order.attch != null && order.attch != ''">
                        <label>会员id:</label> <span>@{{order.attch}}</span>
                    </div>
                    <div class="form-details-item form-details-item-sm">
                        <label>接单时间:</label> <span>@{{order.receivedTime}}</span><label class="form-details-item-highlight" v-show="order.floatAmount != null && order.floatAmount != 0">@{{order.floatAmount !=
                            null && order.floatAmount > 0 ? '+' : ''}}@{{order.floatAmount}}@{{global.systemSetting.currencyUnit}}</label>
                    </div>
                    <div class="form-details-item form-details-item-sm">
                        <label>通道/金额:</label> <span style="font-weight: bold; color: red;">@{{order.gatheringChannelName}}/@{{order.gatheringAmount}}@{{global.systemSetting.currencyUnit}}</span>
                        <template v-if="order.gatheringChannelCode == 'wechat' || order.gatheringChannelCode == 'alipay'"> <label>收款人:</label> <span class="form-details-item-highlight" style="font-weight: bold; color: #dc3545;">@{{order.payee}}</span>
                        </template>
                    </div>
                    <div class="form-details-item form-details-item-sm" style="font-size: 12px;" v-if="order.gatheringChannelCode == 'bankCard'">
                        <label>银行卡信息:</label> <span>@{{order.openAccountBank}}/@{{order.accountHolder}}/@{{order.bankCardAccount}}</span>
                    </div>
                    <div class="form-details-item form-details-item-sm">
                        <button class="btn btn-outline-info" type="button" v-show="manualConfirmOrder" v-on:click="confirmToPaid(order.id)">确认已支付</button>
                        <button class="btn btn-outline-danger" type="button" v-on:click="showAppealPage(order)">申诉</button>
                    </div>
                    <div class="form-details-item" v-show="order.orderState == '8'">
                        <button class="btn btn-outline-info btn-lg" type="button" v-on:click="showAppealDetailsPage(order.id)">查看申诉详情</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="order-appeal-area" v-show="!showWaitConfirmOrderFlag">
            <div class="form-details">
                <div class="form-details-body">
                    <div class="form-details-item form-details-item-sm">
                        <label>订单号:</label> <span>@{{selectedOrder.orderNo}}</span>
                    </div>
                    <div class="form-details-item form-details-item-sm" v-show="selectedOrder.attch != null && selectedOrder.attch != ''">
                        <label>会员id:</label> <span>@{{selectedOrder.attch}}</span>
                    </div>
                    <div class="form-details-item form-details-item-sm">
                        <label>接单时间:</label> <span>@{{selectedOrder.receivedTime}}</span><label class="form-details-item-highlight" v-show="selectedOrder.floatAmount != null && selectedOrder.floatAmount != 0">@{{selectedOrder.floatAmount
                            != null && selectedOrder.floatAmount > 0 ? '+' : ''}}@{{selectedOrder.floatAmount}}@{{global.systemSetting.currencyUnit}}</label>
                    </div>
                    <div class="form-details-item form-details-item-sm">
                        <label>通道/金额:</label> <span>@{{selectedOrder.gatheringChannelName}}/@{{selectedOrder.gatheringAmount}}@{{global.systemSetting.currencyUnit}}</span>
                        <template v-if="selectedOrder.gatheringChannelCode == 'wechat' || selectedOrder.gatheringChannelCode == 'alipay'"> <label>收款人:</label> <span class="form-details-item-highlight">@{{selectedOrder.payee}}</span>
                        </template>
                    </div>
                    <div class="form-details-item form-details-item-sm" style="font-size: 12px;" v-if="selectedOrder.gatheringChannelCode == 'bankCard'">
                        <label>银行卡信息:</label> <span>@{{selectedOrder.openAccountBank}}/@{{selectedOrder.accountHolder}}/@{{selectedOrder.bankCardAccount}}</span>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 1.3rem;">
                <form>
                    <div class="form-group">
                        <label>申诉类型:</label> <select class="form-control" v-model="appealType">
                            <option value="">请选择</option>
                            <option v-for="dictItem in appealTypeDictItems" :value="dictItem.dictItemCode" v-if="dictItem.dictItemCode != '1' || (dictItem.dictItemCode == '1' && appealCancelOrderEnabled)">@{{dictItem.dictItemName}}</option>
                        </select>
                    </div>
                    <div class="form-group" v-show="appealType == '2' || appealType == '4'">
                        <label>实际支付金额:</label> <input type="number" class="form-control" v-model="actualPayAmount">
                    </div>
                    <div class="form-group" v-show="appealType == '2' || appealType == '4'">
                        <label>截图:</label> <input type="file" class="form-control sreenshot" multiple>
                    </div>
                    <button type="button" class="btn btn-danger btn-lg btn-block" v-on:click="userStartAppeal">发起申诉</button>
                    <button type="button" class="btn btn-light btn-lg btn-block" v-on:click="showWaitConfirmOrderPage">返回</button>
                </form>
            </div>
        </div>
    </div>
</div>
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
<script type="text/javascript" src="/js/audit-order.js"></script>
</body>
</html>
@endsection
