<?php
class Inchoo_Flickr_Model_Carousel_Transition extends Mage_Eav_Model_Entity_Attribute_Source_Abstract{	
	protected $_options;

    public function toOptionArray(){
		if (!isset($this->_options)){
			$options = array();
			$options[] = array('label' => 'Sinoidal', 'value' => 'sinoidal');
			$options[] = array('label' => 'Spring', 'value' => 'spring');
		}
		$this->_options = $options;
		return $this->_options;
    }

    public function getAllOptions(){
    	return $this->toOptionArray();
    }
	
}