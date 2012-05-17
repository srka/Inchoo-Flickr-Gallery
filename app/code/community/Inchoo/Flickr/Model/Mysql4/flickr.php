<?php 
class Inchoo_Flickr_Model_Mysql4_Flickr extends Mage_Core_Model_Mysql4_Abstract{
	public function _construct(){   
		$this->_init('flickr/flickr', 'flickr_id');
	}
}