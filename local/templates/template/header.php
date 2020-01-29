<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJSCore::RegisterExt('maskedinput', array(
	'js' => SITE_TEMPLATE_PATH . '/libs/maskedinput/jquery.maskedinput.min.js',
));

$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/css/main.css');
?>

<!DOCTYPE HTML>
<html lang="ru">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><? $APPLICATION->ShowTitle()?></title>

	<? $APPLICATION->ShowHead();?>
</head>
<body>

<? $APPLICATION->ShowPanel();?>
