<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>

<h1>Записаться на мероприятие</h1>

<form id="feedback-form" class="needs-validation" novalidate="">
	<div class="container">
		<div class="row">
			<div class="col-md-4 mb-3">
				<label for="fio">Ф.И.О.</label>
				<input type="text" class="form-control" id="fio" name="fio" placeholder="" value="" required="">
				<div class="invalid-feedback">
					Поле "Ф.И.О." обязательно к заполнению.
				</div>
			</div>
			<div class="col-md-4 mb-3">
				<label for="email">Email</label>
				<input type="text" class="form-control" id="email" name="email" placeholder="" value="" required="">
				<div class="invalid-feedback">
					Поле "Email" обязательно к заполнению.
				</div>
			</div>
			<div class="col-md-4 mb-3">
				<label for="phone">Телефон</label>
				<input type="text" class="form-control" id="phone" name="phone" placeholder="" value="" required="">
				<div class="invalid-feedback">
					Поле "Телефон" обязательно к заполнению.
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5 mb-3">
				<label for="events">Мероприятия</label>
				<select class="custom-select d-block w-100" id="events" name="events" required="" multiple size="5" >

					<? foreach ($arResult['EVENTS'] as $arEvent): ?>

						<option value="<?= $arEvent['ID'] ?>" <?= $arEvent['CODE'] === $arParams['ELEMENT_CODE'] ? 'selected' : '' ?>>
							<?= $arEvent['NAME'] ?>
						</option>

					<? endforeach; ?>

				</select>
				<div class="invalid-feedback">
					Необходимо выбрать хотябы одно мероприятие.
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col" id="ajax-response"></div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<button class="btn btn-primary btn-lg btn-block" id="send-feedback" type="submit">Отправить</button>
			</div>
		</div>
	</div>
</form>

<?
CJSCore::Init(['maskedinput']);
?>

