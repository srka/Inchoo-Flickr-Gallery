<?php
class Inchoo_Flickr_Block_View extends Mage_Core_Block_Template{  

	public function _prepareLayout(){
		return parent::_prepareLayout();
	}
	
	public function getPageNumber(){
		return $this->getRequest()->getParam('page');
	}
	
	public function canDisplay($photoset_id){
		$selected_sets = Mage::getStoreConfig('flickrconfig/flickrgeneral/photosets');
		$selected_sets_array = explode(',', $selected_sets);
		return in_array($photoset_id, $selected_sets_array);
	}

}
?>