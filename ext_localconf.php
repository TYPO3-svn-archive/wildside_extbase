<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'API',
	array(
		'FileuploadWidget' => 'upload',
		'RecordSelectorWidget' => 'search'
	),
	array(
		'FileuploadWidget' => 'upload',
		'RecordSelectorWidget' => 'search'
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Template',
	array(
		'Template' => 'show',
	),
	array(
		'Template' => 'show',
	)
);


Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Datasource',
	array(
		'DataSource' => 'list,show',
	),
	array(
		'DataSource' => 'list,show',
	)
);


?>