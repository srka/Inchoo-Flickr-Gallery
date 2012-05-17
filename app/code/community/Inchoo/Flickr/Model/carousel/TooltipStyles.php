<?php
class Inchoo_Flickr_Model_Carousel_Tooltipstyles extends Mage_Eav_Model_Entity_Attribute_Source_Abstract{	
	protected $_options;

    public function toOptionArray(){
		if (!isset($this->_options)){
			$options = array();
			$options[] = array('label' => 'Standard', 'value' => 'standard');
			$options[] = array('label' => 'Black', 'value' => 'black');
			$options[] = array('label' => 'Slick', 'value' => 'slick');
			$options[] = array('label' => 'Glass', 'value' => 'glass');
			$options[] = array('label' => 'Rounded', 'value' => 'rounded');
		}
		$this->_options = $options;
		return $this->_options;
    }

    public function getAllOptions(){
    	return $this->toOptionArray();
    }
	
}