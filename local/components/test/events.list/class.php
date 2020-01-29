<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;

class EventsList extends CBitrixComponent
{
	protected $cacheKeys = [];
	protected $navParams = null;

	protected function checkModules() {
		if (!Main\Loader::includeModule('iblock'))
			throw new Main\LoaderException('Не установлен модуль "iblock"');
	}

	protected function checkParams() {
		if ($this->arParams['IBLOCK_ID'] <= 0)
			throw new Main\ArgumentNullException('IBLOCK_ID');
	}

	protected function readDataFromCache() {
		if ($this->arParams['CACHE_TYPE'] == 'N')
			return false;

		return !($this->StartResultCache(false, $this->navParams->getCurrentPage()));
	}

	protected function putDataToCache() {
		if (is_array($this->cacheKeys) && sizeof($this->cacheKeys) > 0)
			$this->SetResultCacheKeys($this->cacheKeys);
	}

	protected function getNavParams() {
		$this->navParams = new \Bitrix\Main\UI\PageNavigation('nav');
		$this->navParams->allowAllRecords(false)
			->setPageSize($this->arParams['PAGE_SIZE'])
			->initFromUri();
	}

	protected function getResult() {
		$eventsList = \Bitrix\Iblock\ElementTable::getList([
			'order' => ['ID' => 'ASC'],
			'select' => ['ID', 'NAME', 'CODE', 'IBLOCK_ID', 'PREVIEW_TEXT'],
			'filter' => ['IBLOCK_ID' => $this->arParams['IBLOCK_ID']],
			'offset' => $this->navParams->getOffset(),
			'limit' => $this->navParams->getLimit(),
			'count_total' => true,
			'cache' => array(
				'ttl' => 3600,
				'cache_joins' => true
			),
		]);

		$this->navParams->setRecordCount($eventsList->getCount());

		$this->arResult['EVENTS'] = $eventsList->fetchAll();
		$this->arResult['NAVIGATION'] = $this->navParams;
	}

	public function executeComponent() {
		try {
			$this->checkModules();
			$this->checkParams();
			$this->getNavParams();
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