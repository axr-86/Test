<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$APPLICATION->IncludeComponent(
	'test:events.list',
	'',
	[
		'CACHE_TIME' => $arParams['CACHE_TIME'],
		'CACHE_TYPE' => $arParams['CACHE_TYPE'],
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		'PAGE_SIZE' => $arParams['PAGE_SIZE'],
	],
	$component
);
