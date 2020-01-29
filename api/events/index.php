<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main;
use Bitrix\Main\Context;

$request = Context::getCurrent()->getRequest();

if ($request->getPost('code')) {

	Main\Loader::includeModule('iblock');

	$event = \Bitrix\Iblock\ElementTable::getList([
		'order' => [],
		'select' => ['ID', 'NAME', 'CODE', 'PREVIEW_TEXT', 'DETAIL_TEXT'],
		'filter' => [
			'IBLOCK_ID' => 13,
			'CODE' => $request->getPost('code')
		],
		'limit' => 1,
		'cache' => [
			'ttl' => 3600,
			'cache_joins' => true
		],
	])->fetch();

	echo json_encode($event, JSON_UNESCAPED_UNICODE);
}
