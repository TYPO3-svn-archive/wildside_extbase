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

/**
 * Injector base class
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
abstract class Tx_WildsideExtbase_ViewHelpers_InjectViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper {
	
	const TYPE_JAVASCRIPT = 'js';
	const TYPE_STYLESHEET = 'css';
	
	/**
	 * Void
	 * @return string
	 */
	public function render() {
		return '';
	}
	
	/**
	 * Injects $code in header data
	 *
	 * @param string $code
	 * @param bool $header
	 * @param string $key
	 */
	public function process($code=NULL, $key=NULL) {
		if ($key == NULL) {
			$key = md5($code);
		}
		$GLOBALS['TSFE']->additionalHeaderData[$key] = $code;
	}
	
	/**
	 * Wrap the code in proper HTML tags
	 * @param string $code The code, JS or CSS, to be wrapped
	 * @param string $filename If specified, file is used instead of source inject
	 * @return string
	 */
	public function wrap($code=NULL, $file=NULL) {
		if ($this->type == self::TYPE_JAVASCRIPT) {
			if ($file) {
				return "<script type='text/javascript' src='{$file}'></script>";
			} else {
				return "<script type='text/javascript'>\n{$code}\n</script>";
			}
		} else if ($this->type == self::TYPE_STYLESHEET) {
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
		if ($concat === TRUE) {
			$file = $this->concatenate($filenames, $cache, $this->type);
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
		if ($cache === FALSE && $compress === FALSE) {
			$code = $this->wrap(NULL, $filename);
			$this->process($code);
		} else if ($compress === TRUE) {
			$contents = file_get_contents(PATH_site . $filename);
			$packed = $this->pack($contents);
			$md5 = md5($filename);
			if ($cache === TRUE) {
				$cachedFile = $this->saveToTempFile($contents, $uniqid, $this->type);
				$code = $this->wrap(NULL, $cachedFile);
				$this->process($code);
			} else {
				$contents = $this->wrap($contents);
				$this->process($contents);
			}
		} else {
			$code = $this->wrap(NULL, $filename);
			$this->process($code);
		}
	}
	
	/**
	 * Pack/compress code
	 * @param string $code
	 */
	public function pack($code) {
		$encoding = 62; // see value in Tx_WildsideExtbase_Utility_JavascriptPacker
		$fastDecode = FALSE;
		$specialChars = FALSE;
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$packer = $objectManager->get('Tx_WildsideExtbase_Utility_JavascriptPacker', $encoding, $fastDecode, $specialChars);
		$packed = $packer->pack();
		return (string) $packed;
	}
}
	

?>