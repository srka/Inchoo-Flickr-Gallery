<?php
class Inchoo_Flickr_Model_Observer extends Inchoo_Flickr_Block_View{
	
	private function _isFlickrGalley(){
		return (($this->getRequest()->getRouteName() . '_' . $this->getRequest()->getModuleName()) == 'flickr_gallery') ? true : false;
	}
	
    public function addSetsHandle($observer){
		if($this->_isFlickrGalley()){
	        $update = $observer->getEvent()->getLayout()->getUpdate();
			
			$update->addHandle('flickr_gallery');
			if($this->getRequest()->getParam('id')){
				$update->addHandle('flickr_gallery_set');
				if(Mage::getStoreConfig('flickrconfig/flickrlightbox/include_lightbox')){
					$update->addHandle('flickr_gallery_include_lightbox');
				}
			}else{
				$update->addHandle('flickr_gallery_index');
			}
		}
		return $this;
    }
}
?>