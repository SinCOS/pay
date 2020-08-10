
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>接单</title>
<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
<script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="https://cdn.staticfile.org/vue/2.4.2/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
<link href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://cdn.staticfile.org/layer/2.3/layer.js"></script>
<script src="https://cdn.staticfile.org/distpicker/2.0.5/distpicker.min.js"></script>
<script src="/js/common.js"></script>
<link href="/css/common.css" rel="stylesheet" type="text/css">
@yield('head-style')
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
@yield('others')

