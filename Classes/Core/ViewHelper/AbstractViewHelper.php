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
	
}


?>