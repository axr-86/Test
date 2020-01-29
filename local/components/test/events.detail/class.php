<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;
use \Bitrix\Iblock\Component\Tools as BitrixTools;

class EventsElement extends CBitrixComponent
{
	protected $cacheKeys = [];

	protected function checkModules() {
		if (!Main\Loader::includeModule('iblock'))
			throw new Main\LoaderException('Не установлен модуль "iblock"');
	}

	protected function checkParams() {
		if ($this->arParams['IBLOCK_ID'] <= 0)
			throw new Main\ArgumentNullException('IBLOCK_ID');

		if (empty($this->arParams['ELEMENT_CODE']))
			$this->process404();
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
		$this->arResult['EVENT'] = \Bitrix\Iblock\ElementTable::getList([
			'order' => [],
			'select' => ['ID', 'NAME', 'CODE', 'IBLOCK_ID', 'DETAIL_TEXT'],
			'filter' => [
				'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
				'CODE' => $this->arParams['ELEMENT_CODE']
			],
			'limit' => 1,
			'cache' => [
				'ttl' => 3600,
				'cache_joins' => true
			],
		])->fetch();

		if(!$this->arResult['EVENT'])
			$this->process404();
	}

	protected function process404() {
		$this->AbortResultCache();
		BitrixTools::process404('',true,true, true);
	}

	public function executeComponent() {
		try {
			$this->checkModules();
			$this->checkParams();
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