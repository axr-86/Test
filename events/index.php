<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php'); ?>

<main role="main" class="container">

<?
$APPLICATION->IncludeComponent(
	'test:events',
	'',
	[
		'CACHE_TIME' => '3600',
		'CACHE_TYPE' => 'A',
		'IBLOCK_ID'  => 13,
		'IBLOCK_ID_FEEDBACK'  => 17,
		'SEF_MODE' => 'Y',
		'SEF_FOLDER' => '/events',
		'PAGE_SIZE' => 3,
	]
);
?>

</main>
