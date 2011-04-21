<?php
if (!defined ('TYPO3_MODE')){
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Template',
	'Fluid Template Display'
);

//$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_template'] = 'pi_flexform';
//t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_template', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_template.xml');


Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Datasource',
	'Data Source Display'
);

//$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_datasource'] = 'pi_flexform';
//t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_datasource', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_datasource.xml');





t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Wildside ExtBase Framework');


t3lib_extMgm::addLLrefForTCAdescr('tx_wildsideextbase_domain_model_datasource', 'EXT:wildside_extbase/Resources/Private/Language/locallang_csh_tx_wildsideextbase_domain_model_datasource.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wildsideextbase_domain_model_datasource');
$TCA['tx_wildsideextbase_domain_model_datasource'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:wildside_extbase/Resources/Private/Language/locallang_db.xml:tx_wildsideextbase_domain_model_datasource',
		'label' 			=> 'name',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'dividers2tabs' => true,
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l10n_parent',
		'transOrigDiffSourceField' 	=> 'l10n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/DataSource.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wildsideextbase_domain_model_datasource.gif'
	),
);

## KICKSTARTER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the kickstarter


$TCA['tt_content']['types']['list']['subtypes_addlist']['wildsideextbase_datasource'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('wildsideextbase_datasource', 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/DataSource.xml');

if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_wildsideextbase_configuration_wizard_datasource'] = t3lib_extMgm::extPath($_EXTKEY, 'Configuration/Wizard/DataSource.php');
}


$TCA['tt_content']['types']['list']['subtypes_addlist']['wildsideextbase_template'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('wildsideextbase_template', 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/Template.xml');

if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_wildsideextbase_configuration_wizard_template'] = t3lib_extMgm::extPath($_EXTKEY, 'Configuration/Wizard/Template.php');
}

?>