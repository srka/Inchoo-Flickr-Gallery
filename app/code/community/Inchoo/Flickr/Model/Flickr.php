<?php
class Inchoo_Flickr_Model_Flickr extends Mage_Core_Model_Abstract{
	public function _construct(){
		parent::_construct();
		$this->_init('flickr/flickr');
	}
}