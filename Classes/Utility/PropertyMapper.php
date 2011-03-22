<?php 
















class Tx_WildsideExtbase_Utility_PropertyMapper implements t3lib_Singleton {
	
	/**
	 * Returns an array of property names by searching the $object for annotations
	 * based on $annotation and $value. If $annotation is provided but $value is not,
	 * all properties which simply have the annotation present. Relational values
	 * which have the annotation are parsed through the same function - sub-elements'
	 * properties are exported based on the same annotation and value
	 * 
	 * @param Tx_Extbase_DomainObject_AbstractDomainOject $object The object to read
	 * @param string $annotation The annotation on which to base output
	 * @param string $value The value to search for; multiple values may be used in the annotation; $value must be present among them. If TRUE, all properties which have the annotation are returned
	 * @param boolean $addUid If TRUE, the UID of the DomainObject will be force-added to the output regardless of annotation
	 * @return array
	 */
	public function getValuesByAnnotation(Tx_Extbase_DomainObject_AbstractDomainOject $object, $annotation='json', $value=TRUE, $addUid=TRUE) {
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$reflectionService = $objectManager->get('Tx_Extbase_Reflection_Service');
		$className = get_class($object);
		$properties = $reflectionService->getClassPropertyNames($className);
		
		$return = array();
		if ($addUid) {
			$return['uid'] = $object->getUid();
		}
		foreach ($properties as $propertyName) {
			$tags = $this->reflectionService->getPropertyTagsValues($className, $propertyName);
			$getter = 'get' . ucfirst($propertyName);
			$annotationValues = $tags[$annotation];
			if ($annotationValues !== NULL && (in_array($value, $annotationValues) || $value === TRUE)) {
				$returnValue = $object->$getter();
				if ($returnValue instanceof Tx_Extbase_DomainObject_AbstractDomainOject) {
					$returnValue = $this->getValuesByAnnotation($object, $annotation, $value, $addUid);
				} else if ($returnValue instanceof Tx_Extbase_Persistence_ObjectStorage) {
					$array = $returnValue->toArray();
					foreach ($array as $k=>$v) {
						$array[$k] = self::getValuesByAnnotation($v, $annotation, $value, $addUid);
					}
				}
				$return[$propertyName] = $returnValue;
			}
		}
		return $return;
	}
	
	
}




?>