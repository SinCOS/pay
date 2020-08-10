
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>注册</title>
<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
<script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="https://cdn.staticfile.org/vue/2.4.2/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
<link href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://cdn.staticfile.org/layer/2.3/layer.js"></script>
<script src="/js/common.js"></script>
<link href="/css/common.css" rel="stylesheet" type="text/css">
<style type="text/css">
.register-container {
	padding-top: 2rem;
	padding-bottom: 1rem;
}

.register-container .fa {
	height: 20px;
	width: 20px;
}
</style>
</head>

<body>
	<html>
<head>
<style>
.header-navbar {
	color: white;
	display: block;
	text-align: center;
	height: 2.5rem;
	line-height: 1rem;
	background-color: #dc3545;
}

</style>
</head>
<body>
	<div id="header" v-cloak>
		<nav class="navbar fixed-top bg-danger header-navbar" v-show="showHeaderFlag">
			<i class="fa fa-angle-left" aria-hidden="true" style="float: left; font-size: 1.8rem;" v-show="showBackFlag" v-on:click="window.history.back(-1);"></i><a class="navbar-brand">@{{title}}</a>
		</nav>
	</div>
	<script type="text/javascript">
		var headerVM = new Vue({
			el : '#header',
			data : {
				title : '',
				showHeaderFlag : true,
				showBackFlag : false
			},
			computed : {},
			created : function() {
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
	<div id="register" v-cloak>
		<div class="page-body">
			<div class="container register-container">
				<form>
					<div class="input-group input-group-lg mb-4">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="请输入用户名" v-model="userName">
					</div>

					<div class="input-group input-group-lg mb-4">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fa fa-info" aria-hidden="true"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="请输入真实姓名" v-model="realName">
					</div>

					<div class="input-group input-group-lg mb-4">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="请输入手机号" v-model="mobile">
					</div>

					<div class="input-group input-group-lg mb-4">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="请输入登录密码" v-model="loginPwd">
					</div>

					<div class="input-group input-group-lg mb-4">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fa fa-money" aria-hidden="true"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="请输入资金密码" v-model="moneyPwd">
					</div>
					<div class="input-group input-group-lg mb-3" v-if="inviteRegisterFlag">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fa fa-leaf" aria-hidden="true"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="请输入邀请码" v-model="inviteCode" :disabled="inviteCodeReadonlyFlag">
					</div>
					<button type="button" class="btn btn-danger btn-lg btn-block" v-on:click="registerAndLogin">注册并登录</button>
				</form>
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
	<link href="/css/theme-brown.css" rel="stylesheet" type="text/css">
	<script type="text/javascript">
		var registerVM = new Vue({
			el : '#register',
			data : {
				inviteRegisterFlag : false,
				inviteCodeReadonlyFlag : false,
				userName : '',
				realName : '',
				mobile : '',
				loginPwd : '',
				moneyPwd : '',
				inviteCode : '',
			},
			computed : {},
			created : function() {
			},
			mounted : function() {
				headerVM.title = '注册';
				var inviteCode = getQueryString('inviteCode');
				if (inviteCode != null && inviteCode != '') {
					this.inviteCode = inviteCode;
					this.inviteCodeReadonlyFlag = true;
				}
				this.loadRegisterSetting();
			},
			methods : {
				loadRegisterSetting : function() {
					var that = this;
					that.$http.get('/api/masterControl/getRegisterSetting').then(function(res) {
						that.inviteRegisterFlag = res.body.data.inviteRegisterEnabled;
					});
				},

				/**
				 * 注册并登录
				 */
				registerAndLogin : function() {
					var that = this;
					if (that.userName == null || that.userName == '') {
						layer.alert('请输入用户名');
						return;
					}
					var userNamePatt = /^[A-Za-z][A-Za-z0-9]{5,11}$/;
					if (!userNamePatt.test(that.userName)) {
						layer.alert('用户名不合法!请输入以字母开头,长度为6-12个字母和数字的用户名');
						return;
					}
					if (that.realName == null || that.realName == '') {
						layer.alert('请输入真实姓名');
						return;
					}
					if (that.mobile == null || that.mobile == '') {
						layer.alert('请输入手机号');
						return;
					}
					if (that.mobile.length != 11) {
						layer.alert('手机号不合法,请重新输入');
						return;
					}
					if (that.loginPwd == null || that.loginPwd == '') {
						layer.alert('请输入登录密码');
						return;
					}
					var passwordPatt = /^[A-Za-z][A-Za-z0-9]{5,14}$/;
					if (!passwordPatt.test(that.loginPwd)) {
						layer.alert('登录密码不合法!请输入以字母开头,长度为6-15个字母和数字的密码');
						return;
					}
					if (that.moneyPwd == null || that.moneyPwd == '') {
						layer.alert('请输入资金密码');
						return;
					}
					if (!passwordPatt.test(that.moneyPwd)) {
						layer.alert('资金密码不合法!请输入以字母开头,长度为6-15个字母和数字的密码');
						return;
					}
					if (that.inviteRegisterFlag && (that.inviteCode == null || that.inviteCode == '')) {
						layer.alert('请输入邀请码');
						return;
					}
					that.$http.post('/userAccount/register', {
						userName : that.userName,
						realName : that.realName,
						mobile : that.mobile,
						loginPwd : that.loginPwd,
						moneyPwd : that.moneyPwd,
						inviteCode : that.inviteCode
					}, {
						emulateJSON : true
					}).then(function(res) {
						layer.alert('注册成功');
						window.location.href = '/login';
					});
				}
			}
		});
	</script>
</body>
</html>