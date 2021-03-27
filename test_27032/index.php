<?php


$APPLICATION->IncludeComponent(
	'custom:legacy_test', //custom is a components folder
	'',
	[
		'CACHE' => 'Y',
		'SEF_MODE' => 'Y'
	]
);