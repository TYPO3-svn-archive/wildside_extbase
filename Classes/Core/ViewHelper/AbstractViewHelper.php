<?php 






class Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
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
			
		}
		return $values;
	}
	
}






?>