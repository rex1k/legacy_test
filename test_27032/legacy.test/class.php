<?php

class LegacyTest extends \CBitrixComponent
{

	private function parseSefData()
	{
		$arDefaultUrlTemplates404 = [];
		$arDefaultVariableAliases404 = [];
		$arDefaultVariableAliases = [];
		$arComponentVariables = [];
		$arUrlTemplates = [];
		$componentPage = '';
		$arVariables = [];
		if ($this->arParams['SEF_MODE'] == 'Y') {
			$arUrlTemplates = \CComponentEngine::MakeComponentUrlTemplates(
				$arDefaultUrlTemplates404,
				$this->arParams['SEF_URL_TEMPLATES']
			);
			$arVariableAliases = \CComponentEngine::MakeComponentVariableAliases(
				$arDefaultVariableAliases404,
				$this->arParams['VARIABLE_ALIASES']
			);
			$componentPage = \CComponentEngine::ParseComponentPath(
				$this->arParams['SEF_FOLDER'],
				$arUrlTemplates,
				$arVariables
			);
			\CComponentEngine::InitComponentVariables(
				$componentPage,
				$arComponentVariables,
				$arVariableAliases,
				$arVariables
			);
		} else {
			$arVariableAliases = \CComponentEngine::MakeComponentVariableAliases(
				$arDefaultVariableAliases,
				$this->arParams['VARIABLE_ALIASES']
			);
			\CComponentEngine::InitComponentVariables('', $arComponentVariables, $arVariableAliases, $arVariables);
		}
		$this->arParams['SECTION_CODE'] = $arVariables['SECTION_CODE'];
	}


	private function getData()
	{
		\CModule::IncludeModule('iblock');
		$oElements = \CIBlockElement::GetList(
			['ID' => 'DESC'],
			['ACTIVE' => 'Y', 'IBLOCK_CODE' => 'legacy.test', 'IBLOCK_SECTION' => $this->arParams['SECTION_CODE']],
			false,
			false,
			['ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_UF_SALARY']
		);
		$aElements = [];
		while ($aElement = $oElements->Fetch()) {
			$aElements[] = $aElement;
		}
		$this->arResult['ELEMENTS'] = $aElements;
	}


	public function onPrepareComponentParams($arParams)
	{
		$this->parseSefData();
		return $arParams;
	}


	public function executeComponent()
	{
		if ($this->StatrResultCache()) {
			$this->getData();
			$this->includeComponentTemplate();
		}
	}
}