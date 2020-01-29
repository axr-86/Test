<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\UI\Extension;

class EventsComponent extends CBitrixComponent
{
	protected $defaultUrlTemplates404;
	protected $componentVariables;

	protected $defaultPage = 'list';
	protected $defaultSefPage = 'list';

	protected $templatePage;
	protected $sefFolder;
	protected $urlTemplates;
	protected $variables;
	protected $variableAliases;

	protected function loadExtensions() {
		Extension::load('ui.bootstrap4');
	}

	protected function setSefDefaultParams() {
		$this->defaultUrlTemplates404 = [
			'list' => 'index.php',
			'detail' => '#ELEMENT_CODE#/',
			'feedback' => '#ELEMENT_CODE#/feedback/',
		];

		$this->componentVariables = [
			'ELEMENT_CODE'
		];
	}

	protected function setPage() {
		$urlTemplates = [];

		if ($this->arParams['SEF_MODE'] === 'Y') {
			$variables = [];

			$urlTemplates = \CComponentEngine::MakeComponentUrlTemplates(
				$this->defaultUrlTemplates404,
				$this->arParams['SEF_URL_TEMPLATES']
			);

			$variableAliases = \CComponentEngine::MakeComponentVariableAliases(
				$this->defaultUrlTemplates404,
				$this->arParams['VARIABLE_ALIASES']
			);

			$this->templatePage = \CComponentEngine::ParseComponentPath(
				$this->arParams['SEF_FOLDER'],
				$urlTemplates,
				$variables
			);

			if (!$this->templatePage)
				$this->templatePage = $this->defaultSefPage;

			\CComponentEngine::InitComponentVariables(
				$this->templatePage,
				$this->componentVariables,
				$variableAliases,
				$variables
			);
		}
		else {
			$this->templatePage = $this->defaultPage;
		}

		$this->sefFolder = $this->arParams['SEF_FOLDER'];
		$this->urlTemplates = $urlTemplates;
		$this->variables = $variables;
		$this->variableAliases = $variableAliases;
	}

	protected function setResult() {
		$this->arResult['FOLDER'] = $this->sefFolder;
		$this->arResult['URL_TEMPLATES'] = $this->urlTemplates;
		$this->arResult['VARIABLES'] = $this->variables;
		$this->arResult['ALIASES'] = $this->variableAliases;
	}

	public function executeComponent() {
		$this->loadExtensions();
		$this->setSefDefaultParams();
		$this->setPage();
		$this->setResult();
		$this->includeComponentTemplate($this->templatePage);
	}

}