<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>

<h1>Список мероприятий</h1>

<div class="container">
	<div class="row">

		<? foreach ($arResult['EVENTS'] as $arEvent): ?>

			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<h2><?= $arEvent['NAME'] ?></h2>
						<p class="cars-text"><?= $arEvent['PREVIEW_TEXT'] ?></p>
						<p>
							<a class="btn btn-primary" href="/events/<?= $arEvent['CODE'] ?>/" role="button">Подробнее</a>
						</p>
					</div>
				</div>
			</div>

		<? endforeach; ?>

	</div>
</div>

<?
$APPLICATION->IncludeComponent(
	'bitrix:main.pagenavigation',
	'',
	array(
		'NAV_OBJECT' => $arResult['NAVIGATION'],
		'SEF_MODE' => 'N',
		'SHOW_ALWAYS' => 'Y',
	),
	$component
);
?>
