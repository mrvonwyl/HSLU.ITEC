<?php

//------------------------------
//definition of $_CONFIG
//------------------------------

//paths
//mainpaths
$_CONFIG['contentPath']			= 'pages';
$_CONFIG['imagesPath']			= '/images';
$_CONFIG['scriptsPath']			= '/scripts';
$_CONFIG['stylesPath']			= '/styles';
$_CONFIG['includesPath']		= '/includes';
$_CONFIG['ajaxPath']			= '/ajax';

//sidepaths
$_CONFIG['galleryPath']			= $_CONFIG['imagesPath'].'gallery/';

//constants
$_CONFIG['defaultLocale']		= 'de';
$_CONFIG['homeSite']			= '/dashboard';


include 'database.php';
include 'functions.php';
include 'navigation.php';
// include 'class.phpmailer.php';
// include 'class.smtp.php';

?>