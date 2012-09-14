<?php
class Inchoo_Flickr_Block_Photosets extends Inchoo_Flickr_Block_View{  

	public function _prepareLayout(){
		return parent::_prepareLayout();
	}
	
	public function getPerPage(){
		return Mage::getStoreConfig('flickrconfig/flickrphotosets/photosets_per_page');
	}
	
	public function getThumbSizePrefix(){
		return Mage::getStoreConfig('flickrconfig/flickrphotosets/thumbsize');
	}
	
	public function getPhotoSets($page = 1, $per_page = 0){
		if(!isset($page) || $page == '') $page = 1; 
		if(!isset($per_page) || $per_page == '') $per_page = 0;
		
		$apikey = Mage::getStoreConfig('flickrconfig/flickrgeneral/apikey');
		$userid = Mage::getStoreConfig('flickrconfig/flickrgeneral/user');
		
		$cacheModel = Mage::getModel('flickr/flickr'); 
		$cacheCollection = $cacheModel->getCollection();
		$cacheData = $cacheCollection->getData();
		$hasCache = $cacheCollection->hasResponseType('getPhotoSets');
		
		if(empty($cacheData) || $hasCache === false){
			$raw_photosets = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photosets.getList&api_key=$apikey&user_id=$userid&format=rest");
			$cacheModel->setResponseType('getPhotoSets')
					   ->setContent($raw_photosets)
					   ->setCreatedTime(date('Y-m-d H:i:s'))
			->save();
		}elseif($hasCache !== false && $cacheCollection->cacheExpired('getPhotoSets')){
			$raw_photosets = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photosets.getList&api_key=$apikey&user_id=$userid&format=rest");
			$cachedItem = $cacheModel->load($hasCache);
			$cachedItem->setResponseType('getPhotoSets')
					   ->setContent($raw_photosets)
					   ->setCreatedTime(date('Y-m-d H:i:s'))
			->save();
		}else{
			$raw_photosets = $cacheModel->load($hasCache)->getContent();
		}

		$photosets_xml = new SimpleXMLElement($raw_photosets);
		$photosets = array();
		$_pages = 1;
		$selected_sets = Mage::getStoreConfig('flickrconfig/flickrgeneral/photosets');
		if($selected_sets <> ''){
			$selected_sets_array = explode(',', $selected_sets);
			if($photosets_xml['stat'] == 'ok'){
				$_item_count = 0;
				foreach($photosets_xml->photosets->photoset as $photoset){
					if(in_array($photoset['id'], $selected_sets_array)){
						$_item_count++;
						if( (($_item_count > ($page - 1) * $per_page) && ($_item_count <= ($page * $per_page))) || $per_page == 0 ){
							$photosets[] = array('id' => $photoset['id'], 'title' => $photoset->title, 'description' => $photoset->description , 'cover' => $photoset['primary'], 'photos' => $photoset['photos'], 'videos' => $photoset['videos'], 'server' => $photoset['server'], 'farm' => $photoset['farm'], 'secret' => $photoset['secret']);
						}
					}
				}
				$_result['sets'] = $photosets;
				$_result['total'] = $_item_count;
				$_result['pages'] = (!empty($per_page) && ($page != 0)) ? ceil($_item_count / $per_page) : 1;
			}
		}

		return $_result;
	}
	
	public function getCarouselOptions(){
		
		if(Mage::getStoreConfig('flickrconfig/flickrcarousel/duration')) $options['duration'] = Mage::getStoreConfig('flickrconfig/flickrcarousel/duration');
		$options['auto'] = (Mage::getStoreConfig('flickrconfig/flickrcarousel/auto')) ? 'true' : 'false';
		if(Mage::getStoreConfig('flickrconfig/flickrcarousel/frequency')) $options['frequency'] = Mage::getStoreConfig('flickrconfig/flickrcarousel/frequency');
		if(Mage::getStoreConfig('flickrconfig/flickrcarousel/visibleslides')){
			$options['visibleSlides'] = Mage::getStoreConfig('flickrconfig/flickrcarousel/visibleslides');
		} else { 
			$options['visibleSlides'] = '1';
		}
		$options['circular'] = (Mage::getStoreConfig('flickrconfig/flickrcarousel/circular')) ? 'true' : 'false';
		$options['wheel'] = (Mage::getStoreConfig('flickrconfig/flickrcarousel/wheel')) ? 'true' : 'false';
		if(Mage::getStoreConfig('flickrconfig/flickrcarousel/transition')) $options['transition'] = "'" . Mage::getStoreConfig('flickrconfig/flickrcarousel/transition') . "'";

		$result = '';
		foreach($options as $name => $value){
			$result .= $name . ': ' . $value . ', ';
		}
		
		return $result;
	}
	
	public function isCarouselCircular(){
		return Mage::getStoreConfig('flickrconfig/flickrcarousel/circular');
	}
	
	public function getCarouselVisibleCount(){
		if(Mage::getStoreConfig('flickrconfig/flickrcarousel/visibleslides')){
			return Mage::getStoreConfig('flickrconfig/flickrcarousel/visibleslides');
		} else { 
			return '1';
		}
	}
	
	public function carouselHasTooltip(){
		return Mage::getStoreConfig('flickrconfig/flickrcarousel/tooltip');
	}
	
	public function carouselGetTooltipStyle(){
		if($this->carouselHasTooltip()){
			return Mage::getStoreConfig('flickrconfig/flickrcarousel/tooltip_style');
		}else{
			return false;
		}
	}
}
?>