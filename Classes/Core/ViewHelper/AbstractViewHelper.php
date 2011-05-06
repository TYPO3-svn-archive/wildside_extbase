<?php 
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Claus Due <claus@wildside.dk>, Wildside A/S
*  			
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

abstract class Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper {
	
	const TYPE_JAVASCRIPT = 'js';
	const TYPE_STYLESHEET = 'css';
	
	/**
	 * @var Tx_WildsideExtbase_Utility_JSON
	 */
	protected $jsonService;
	
	/**
	 * Inject JSON Service
	 * @param Tx_WildsideExtbase_Utility_JSON $service
	 */
	public function injectJSONService(Tx_WildsideExtbase_Utility_JSON $service) {
		$this->jsonService = $service;
	}
	
	/**
	 * Get all values (or values specified in $properties
	 * 
	 * @param Tx_Extbase_DomainObject_AbstractDomainObject $object
	 * @param array $properties
	 * @return object
	 */
	public function getValues(Tx_Extbase_DomainObject_AbstractDomainObject $object, array $properties=array()) {
		$className = get_class($object);
		$reflection = t3lib_div::makeInstance('Tx_Extbase_Reflection_ClassReflection', $className);
		$methods = $reflection->getMethods();
		$values = array();
		foreach ($methods as $method) {
			$method = $method->name;
			if (substr($method, 0, 3) != 'get') {
				continue;
			} else {
				$propertyName = substr($method, 3);
				$propertyName{0} = strtolower($propertyName{0});
			}
			$value = $object->$method();
			if ($value instanceof Tx_Extbase_Persistence_ObjectStorage) {
				$value = array();
				foreach ($value as $item) {
					$itemValue = $this->getValues($item);
					array_push($value, $itemValue);
				}
			} else if ($value instanceof Tx_Extbase_DomainObject_AbstractDomainObject) {
				$value = $this->getValues($value);
			}
			$values[$propertyName] = $value;
		}
		return $values;
	}
	
	public function getTemplate($templateFile) {
		$template = $this->objectManager->get('Tx_Fluid_View_StandaloneView');
		$template->setTemplatePathAndFilename($templateFile);
		return $template;
	}
	
	
	/**
	 * Injects $code in header data
	 *
	 * @param string $code
	 * @param bool $header
	 * @param string $key
	 */
	public function process($code=NULL, $key=NULL) {
		if ($key === NULL) {
			$key = md5($code);
		}
		$GLOBALS['TSFE']->additionalHeaderData[$key] = $code;
	}
	
	/**
	 * Injects $code in header data
	 *
	 * @param string $code
	 * @param string $type Optional, if left out we assume the code is already wrapped
	 * @param string $key
	 */
	public function includeHeader($code, $type=NULL, $key=NULL) {
		if ($type !== NULL) {
			$code = $this->wrap($code, NULL, $type);
		}
		return $this->process($code, $key);
	}
	
	/**
	 * Wrap the code in proper HTML tags
	 * @param string $code The code, JS or CSS, to be wrapped
	 * @param string $filename If specified, file is used instead of source inject
	 * @param string $type Type of wrapping (css/js)
	 * @return string
	 */
	public function wrap($code=NULL, $file=NULL, $type=NULL) {
		if ($type === NULL) {
			$type = $this->type;
		}
		if ($type == self::TYPE_JAVASCRIPT) {
			if ($file) {
				return "<script type='text/javascript' src='{$file}'></script>";
			} else {
				return "<script type='text/javascript'>\n{$code}\n</script>";
			}
		} else if ($type == self::TYPE_STYLESHEET) {
			if ($file) {
				return "<link rel='stylesheet' type='text/css' href='{$file}' />";
			} else {
				return "<style type='text/css'>\n{$code}\n</style>";
			}
		} else {
			return $code;
		}
	}
	
	/**
	 * Concatenate files into a string
	 * @param array $files
	 * @param boolean $saveToFile
	 * @return string Contents or filename if $saveToFile was specified
	 */
	public function concatenate(array $files, $saveToFile=FALSE, $extension=self::TYPE_JAVASCRIPT) {
		$contents = "";
		foreach ($files as $file) {
			$contents .= file_get_contents(PATH_site . $file);
			$contents .= "\n";
		}
		if ($saveToFile) {
			$md5 = md5(implode('', $files));
			$contents = $this->saveToTempFile($contents, $md5, $extension);
		}
		return $contents;
	}
	
	/**
	 * Save to a temporary file
	 * @param string $contents Contents of the file
	 * @param string $uniqid Unique id of the temporary file
	 * @param string $extension Extensin of the filename
	 */
	public function saveToTempFile($contents, $uniqid, $extension) {
		$tempFilePath = "typo3temp/{$uniqid}.{$extension}"; 
		$tempFile = PATH_site . $tempFilePath;
		file_put_contents($tempFile, $contents);
		return $tempFilePath;
	}
	
	/**
	 * Include a list of files with optional concat, compress and cache 
	 * @param array $filenames Filenames to include
	 * @param boolean $cache If true, the file is cached (makes sens if $concat or one of the other options is specified)
	 * @param boolean $concat If true, files are concatenated
	 * @param boolean $compress If true, files are compressed
	 * @return string The MD5 checksum of files (which is also the additionalHeaderData array key if you $concat = TRUE)
	 */
	public function includeFiles(array $filenames, $cache=FALSE, $concat=FALSE, $compress=FALSE) {
		$pathinfo = pathinfo($filename);
		$type = $pathinfo['extension'];
		if ($type !== 'css' && $type !== 'js') {
			$type = 'js'; // assume Javascript for unknown files - this may change later on...
		}
		if ($concat === TRUE) {
			$file = $this->concatenate($filenames, $cache, $type);
			if ($cache === TRUE) {
				$this->includeFile($file, $cache, $compress);
			} else {
				$code = $this->wrap(NULL, $file); // will be added as header code
				$this->process($code);
			}
		} else {
			foreach ($filenames as $file) {
				$this->includeFile($file, $cache, $compress);
			}
		}
	}
	
	/**
	 * Include a single file with optional concat, compress and cache 
	 * @param array $filenames Filenames to include
	 * @param boolean $cache If true, the file is cached (makes sens if $concat or one of the other options is specified)
	 * @param boolean $compress If true, files are compressed
	 * @return void
	 */
	public function includeFile($filename, $cache=FALSE, $compress=FALSE) {
		$pathinfo = pathinfo($filename);
		$type = $pathinfo['extension'];
		if ($type !== 'css' && $type !== 'js') {
			$type = 'js'; // assume Javascript for unknown files - this may change later on...
		}
		if ($cache === FALSE && $compress === FALSE) {
			$code = $this->wrap(NULL, $filename, $type);
		} else if ($compress === TRUE) {
			$contents = file_get_contents(PATH_site . $filename);
			$packed = $this->pack($contents);
			$md5 = md5($filename);
			if ($cache === TRUE) {
				$cachedFile = $this->saveToTempFile($contents, $uniqid, $type);
				$code = $this->wrap(NULL, $cachedFile, $type);
			} else {
				$code = $this->wrap($contents, NULL, $type);
			}
		} else {
			$code = $this->wrap(NULL, $filename, $type);
		}
		$this->includeHeader($code);
	}
	
	/**
	 * Pack/compress code
	 * @param string $code
	 */
	public function pack($code) {
		$encoding = 62; // see value in Tx_WildsideExtbase_Utility_JavascriptPacker
		$fastDecode = FALSE;
		$specialChars = FALSE;
		$packer = $this->objectManager->get('Tx_WildsideExtbase_Utility_JavascriptPacker', $encoding, $fastDecode, $specialChars);
		$packed = $packer->pack();
		return (string) $packed;
	}
	
}

?>