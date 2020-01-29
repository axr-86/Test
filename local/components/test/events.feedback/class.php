<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Context;
use Bitrix\Main\Mail\Event;

class EventsFeedback extends CBitrixComponent
{
	protected $cacheKeys = [];

	public function getApplication() {
		global $APPLICATION;
		return $APPLICATION;
	}

	protected function validatePhone($phone){
		if (!preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/iu', $phone))
			return false;

		return true;
	}

	protected function checkModules() {
		if (!Main\Loader::includeModule('iblock'))
			throw new Main\LoaderException('Не установлен модуль "iblock"');
	}

	protected function checkParams() {
		if ($this->arParams['IBLOCK_ID'] <= 0)
			throw new Main\ArgumentNullException('IBLOCK_ID');
	}

	protected function checkAjax() {
		if ($this->arParams['AJAX_MODE'] !== 'Y')
			return;

		$request = Context::getCurrent()->getRequest();

		if ($request->getPost('ajax_mode') === 'Y') {

			$this->getApplication()->RestartBuffer();

			$postData = $request->getPostList()->toArray();
			$response = $this->processAjaxData($postData);

			echo json_encode($response, JSON_UNESCAPED_UNICODE);

			die();
		}
	}

	protected function processAjaxData(array $postData) {
		$response = [];

		if (!$this->validatePhone($postData['phone']))
			$response = [
				'result' => 'error',
				'message' => 'Неверный формат номера телефона.'
			];

		if ($response['result'] === 'error')
			return $response;

		$newElement = new CIBlockElement;

		$properties = [
			'FIO' => $postData['fio'],
			'EMAIL' => $postData['email'],
			'PHONE_NUMBER' => $postData['phone'],
			'EVENTS_LIST' => $postData['events'],
		];

		$element = [
			'IBLOCK_ID' => $this->arParams['IBLOCK_ID_FEEDBACK'],
			'PROPERTY_VALUES' => $properties,
			'NAME' => $postData['fio'],
			'ACTIVE' => 'Y',
		];

		if ($newElementId = $newElement->Add($element)) {
			$response = ['result' => 'ok'];

			$this->sendFeedbackEmail($postData);
		}
		else {
			$response = [
				'result' => 'error',
				'message' => 'Не удалось создать заявку.'
			];
		}

		return $response;
	}

	protected function sendFeedbackEmail(array $data) {
		$eventsList = \Bitrix\Iblock\ElementTable::getList([
			'order' => ['ID' => 'ASC'],
			'select' => ['NAME'],
			'filter' => [
				'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
				'=ID' => $data['events']
			],
			'cache' => [
				'ttl' => 3600,
				'cache_joins' => true
			],
		])->fetchAll();

		$events = [];

		foreach ($eventsList as $event)
			$events[] = $event['NAME'];

		Event::send([
			'EVENT_NAME' => 'NEW_FEEDBACK',
			'LID' => 's1',
			'C_FIELDS' => [
				'FIO' => $data['fio'],
				'EMAIL' => $data['email'],
				'PHONE_NUMBER' => $data['phone'],
				'EVENTS_LIST' => implode(', ', $events),
			],
		]);
	}

	protected function readDataFromCache() {
		if ($this->arParams['CACHE_TYPE'] == 'N')
			return false;

		return !($this->StartResultCache(false, []));
	}

	protected function putDataToCache() {
		if (is_array($this->cacheKeys) && sizeof($this->cacheKeys) > 0)
			$this->SetResultCacheKeys($this->cacheKeys);
	}

	protected function getResult() {
		$this->arResult['EVENTS'] = \Bitrix\Iblock\ElementTable::getList([
			'order' => ['ID' => 'ASC'],
			'select' => ['ID', 'NAME', 'CODE', 'IBLOCK_ID'],
			'filter' => ['IBLOCK_ID' => $this->arParams['IBLOCK_ID']],
			'cache' => [
				'ttl' => 3600,
				'cache_joins' => true
			],
		])->fetchAll();
	}

	public function executeComponent() {
		try {
			$this->checkModules();
			$this->checkParams();
			$this->checkAjax();
			if (!$this->readDataFromCache()) {
				$this->getResult();
				$this->putDataToCache();
				$this->includeComponentTemplate();
			}
		}
		catch (Exception $e) {
			$this->AbortResultCache();
			ShowError($e->getMessage());
		}
	}

}