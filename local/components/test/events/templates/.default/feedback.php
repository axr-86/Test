<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$APPLICATION->IncludeComponent(
	'test:events.feedback',
	'',
	[
		'CACHE_TIME' => $arParams['CACHE_TIME'],
		'CACHE_TYPE' => $arParams['CACHE_TYPE'],
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		'IBLOCK_ID_FEEDBACK' => $arParams['IBLOCK_ID_FEEDBACK'],
		'ELEMENT_CODE' => $_REQUEST['ELEMENT_CODE'],
		'AJAX_MODE' => 'Y',
	],
	$component
);
