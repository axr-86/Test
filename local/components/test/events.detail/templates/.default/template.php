<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>

<h1><?= $arResult['EVENT']['NAME'] ?></h1>

<p><?= $arResult['EVENT']['DETAIL_TEXT'] ?></p>

<p>
	<a class="btn btn-primary" href="/events/<?= $arResult['EVENT']['CODE'] ?>/feedback/" role="button">Записаться на мероприятие</a>
</p>

