<?php

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
\CModule::IncludeModule('iblock');

function createNewIBlock($iGroupID) {

	$oIBlock = new CIBlock;
	$aIBlockFields = [
		'NAME' => 'SALARY_TEST',
		'CODE' => 'SALARY_TEST',
		'IBLOCK_TYPE_ID' => 'CONTENT',
		'FIELDS' => [
			'CODE' => [
				'IS_REQUIRED' => 'Y',
				'DEFAULT_VALUE' => [
					'UNIQUE' => 'Y',
					'TRANSLITERATION' => 'Y',
					'TRANS_CASE' => 'U'
				]
			],
			"SECTION_CODE" => [
				'IS_REQUIRED' => 'Y',
				'DEFAULT_VALUE' => [
					'UNIQUE' => 'Y',
					'TRANSLITERATION' => 'Y',
					'TRANS_CASE' => 'U'
				]
			],
		],
		'SECTION_PAGE_URL' => '/#SECTION_CODE#/',
		'DETAIL_PAGE_URL' => '/#SECTION_CODE#/#ELEMENT_CODE#',
		'BIZPROC' => 'N',
		'WORKFLOW' => 'N'
	];

	$iIBlockID = $oIBlock->Add($aIBlockFields);
	if ($iIBlockID > 0) {
		echo ("Инфоблок создан успешно. ID инфоблока: {$iIBlockID}\n\n");
		createSalaryProperty($iIBlockID);
	} else {
		echo ("Произошла ошибка при создании инфоблока.\nОшибка:\t" . $oIBlock->LAST_ERROR . "\n\n");
	}
	return $iIBlockID;
}


function createSalaryProperty($iIBlockID) {
	$oProperty = new CIBlockProperty;
	$aPropertyFields = [
		'NAME' => 'Salary',
		'ACTIVE' => 'Y',
		'IBLOCK_ID' => $iIBlockID,
		'CODE' => 'UF_SALARY',
		'PROPERTY_TYPE' => 'S',
		'FILTERABLE' => 'Y',
	];
	$iPropertyID = $oProperty->Add($aPropertyFields);
	if ($iPropertyID > 0) {
		echo ("Свойство 'SALARY' для инфоблока добавлено. ID свойства: {$iPropertyID}\n\n");
	} else {
		echo ("Произошла ошибка при создании свойства. Ошибка:\t" . $oProperty->LAST_ERROR);
	}
	return $iIBlockID;
}

