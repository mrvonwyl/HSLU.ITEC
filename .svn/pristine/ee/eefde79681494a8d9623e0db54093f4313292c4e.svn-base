<!doctype html>

<?php

include 'includes/config.php';

$pdo = database::connect();

$loc = getParam('loc', $_CONFIG['defaultLocale']);
$lng = substr($loc, 0, 2);
$page = getParam('page', $_CONFIG['homeSite']);

$reqURI = $_SERVER['REQUEST_URI'];
$url = ($reqURI != '/' ? $reqURI : '/' . $_CONFIG['defaultLocale'] . $_CONFIG['homeSite']);

?>

<html>
<head>

<meta nam="author" content="Marcel von Wyl">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Tharsis Control Panel</title>

<link type="text/css" rel="stylesheet" href="/styles/jquery-ui.structure.css" />
<link type="text/css" rel="stylesheet" href="/styles/jquery-ui.theme.css" />
<link type="text/css" rel="stylesheet" href="/styles/jquery.datatables.css" />
<link type="text/css" rel="stylesheet" href="/styles/<?php echo getCookie('style', 'style'); ?>.css" />
<link type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"/>
<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic">

<script type="text/javascript" src="/scripts/jquery.js"></script>
<script type="text/javascript" src="/scripts/jquery-ui.js"></script>
<script type="text/javascript" src="/scripts/jquery.datatables.js"></script>
<script type="text/javascript" src="/scripts/jquery.typewatch.js"></script>
<script type="text/javascript" src="/scripts/jquery.cookie.js"></script>
<script type="text/javascript" src="/scripts/jquery.messenger.js"></script>
<script type="text/javascript" src="/scripts/jquery.loading.js"></script>
<script type="text/javascript" src="/scripts/jcanvas.js"></script>
<script type="text/javascript" src="/scripts/less.js"></script>
<script type="text/javascript" src="/scripts/scripts.js"></script>

<script>
	
$(function(){
	$('#messenger').messenger({
		autoHide: false
	});
	
	setActiveNode($("a[href='" + '<?php echo $url; ?>' + "']"));
});

function setActiveNode(node){
	$('.nav .current').removeClass('current');
	$('.nav li').find('ul').hide();
	$('.nav li').find('.arrow').switchClass('fa-caret-down', 'fa-caret-right', 0);
	
	node.children('span').addClass('current').find('.arrow').switchClass('fa-caret-right', 'fa-caret-down', 0);
	node.parents('li').children('a').children('span').addClass('current').find('.arrow').switchClass('fa-caret-right', 'fa-caret-down', 0);
	node.parents('li').find('ul').show();
}
	
</script>

</head>
<body>

<div id="page">
	<div id="header">
	</div>
	<div id="center">
		<div id="left">
			<?php echo navigation::getNavigation(1, 0, 1, $loc); ?>
		</div>
		<div id="content">
			<?php include $_CONFIG['contentPath'] . '/' . $page . '.php'; ?>
		</div>
		<div id="right">
			<div id="messenger">				
			</div>
		</div>
	</div>
	<div id="footer">
		<!-- Copyright &copy; 2013 by Tharsis Webdesign -->
	</div>
</div>
</body>
</html>
