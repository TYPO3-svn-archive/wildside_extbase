<?php 

$extensionClassesPath = t3lib_extMgm::extPath('wildside_extbase') . 'Classes/';
return array(
        'tx_wildsideextbase_core_bootstrap' => $extensionClassesPath . 'Core/Bootstrap.php',
		'tx_wildsideextbase_utility_pdf' => $extensionClassesPath . 'Utility/PDF.php',
		'tx_wildsideextbase_utility_propertymapper' => $extensionClassesPath . 'Utility/PropertyMapper.php',
);


?>