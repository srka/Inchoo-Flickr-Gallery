<?php
class Inchoo_Flickr_Block_Photoset extends Inchoo_Flickr_Block_View{  
	public function _prepareLayout(){
		
		return parent::_prepareLayout();
	}
	
	public function getPhotosetId(){
		return $this->getRequest()->getParam('id');
	}
	
	public function getPerPage(){
		return Mage::getStoreConfig('flickrconfig/flickrphotoset/photos_per_page');
	}
	
	public function getThumbSizePrefix(){
		return Mage::getStoreConfig('flickrconfig/flickrphotoset/thumbsize');
	}
	
	public function getFullSizePrefix(){
		return Mage::getStoreConfig('flickrconfig/flickrphotoset/fullsize');
	}
	
	public function getPhotoSetNameFromID($setid){
		$result = '';
		$apikey = Mage::getStoreConfig('flickrconfig/flickrgeneral/apikey');
		$userid = Mage::getStoreConfig('flickrconfig/flickrgeneral/user');
		
		$cacheModel = Mage::getModel('flickr/flickr'); 
		$cacheCollection = $cacheModel->getCollection();
		$cacheData = $cacheCollection->getData();
		$hasCache = $cacheCollection->hasResponseType('getPhotoSetNameFromID-' . $setid);
		
		if(empty($cacheData) || $hasCache === false){
			$raw_photosets = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photosets.getList&api_key=$apikey&user_id=$userid&format=rest");
			$cacheModel->setResponseType('getPhotoSetNameFromID-' . $setid)
					   ->setContent($raw_photosets)
					   ->setCreatedTime(date('Y-m-d H:i:s'))
			->save();
		}elseif($hasCache !== false && $cacheCollection->cacheExpired('getPhotoSetNameFromID-' . $setid)){
			$raw_photosets = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photosets.getList&api_key=$apikey&user_id=$userid&format=rest");
			$cachedItem = $cacheModel->load($hasCache);
			$cachedItem->setResponseType('getPhotoSetNameFromID-' . $setid)
					   ->setContent($raw_photosets)
					   ->setCreatedTime(date('Y-m-d H:i:s'))
			->save();
		}else{
			$raw_photosets = $cacheModel->load($hasCache)->getContent();
		}
		
		$photosets_xml = new SimpleXMLElement($raw_photosets);
		if($photosets_xml['stat'] == 'ok'){
			foreach($photosets_xml->photosets->photoset as $photoset){
				if((string)$photoset['id'] == $setid){
					$result = $photoset->title;
					break;
				}
			}
		}
		return $result;
	}
	
	public function getPhotoSetFromID($setid){
		$result = '';
		$apikey = Mage::getStoreConfig('flickrconfig/flickrgeneral/apikey');
		$userid = Mage::getStoreConfig('flickrconfig/flickrgeneral/user');
		
		$cacheModel = Mage::getModel('flickr/flickr'); 
		$cacheCollection = $cacheModel->getCollection();
		$cacheData = $cacheCollection->getData();
		$hasCache = $cacheCollection->hasResponseType('getPhotoSetFromID-' . $setid);
		
		if(empty($cacheData) || $hasCache === false){
			$raw_photosets = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photosets.getList&api_key=$apikey&user_id=$userid&format=rest");
			$cacheModel->setResponseType('getPhotoSetFromID-' . $setid)
					   ->setContent($raw_photosets)
					   ->setCreatedTime(date('Y-m-d H:i:s'))
			->save();
		}elseif($hasCache !== false && $cacheCollection->cacheExpired('getPhotoSetFromID-' . $setid)){
			$raw_photosets = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photosets.getList&api_key=$apikey&user_id=$userid&format=rest");
			$cachedItem = $cacheModel->load($hasCache);
			$cachedItem->setResponseType('getPhotoSetFromID-' . $setid)
					   ->setContent($raw_photosets)
					   ->setCreatedTime(date('Y-m-d H:i:s'))
			->save();
		}else{
			$raw_photosets = $cacheModel->load($hasCache)->getContent();
		}
		
		$photosets_xml = new SimpleXMLElement($raw_photosets);
		if($photosets_xml['stat'] == 'ok'){
			foreach($photosets_xml->photosets->photoset as $photoset){
				if((string)$photoset['id'] == $setid){
					$result = array('id' => $photoset['id'], 'title' => $photoset->title, 'description' => $photoset->description , 'cover' => $photoset['primary'], 'photos' => $photoset['photos'], 'videos' => $photoset['videos'], 'server' => $photoset['server'], 'farm' => $photoset['farm'], 'secret' => $photoset['secret']);
					break;
				}
			}
		}
		return $result;
	}
	
	public function getMaxSizePhoto($photo_id){
		if(isset($photo_id) && !empty($photo_id)){
			$apikey = Mage::getStoreConfig('flickrconfig/flickrgeneral/apikey');
			
			$cacheModel = Mage::getModel('flickr/flickr'); 
			$cacheCollection = $cacheModel->getCollection();
			$cacheData = $cacheCollection->getData();
			$hasCache = $cacheCollection->hasResponseType('getMaxSizePhoto-' . $photo_id);
			
			if(empty($cacheData) || $hasCache === false){
				$raw_photo = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=$apikey&photo_id=$photo_id&format=rest");
				$cacheModel->setResponseType('getMaxSizePhoto-' . $photo_id)
						   ->setContent($raw_photo)
						   ->setCreatedTime(date('Y-m-d H:i:s'))
				->save();
			}elseif($hasCache !== false && $cacheCollection->cacheExpired('getMaxSizePhoto-' . $photo_id)){
				$raw_photo = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=$apikey&photo_id=$photo_id&format=rest");
				$cachedItem = $cacheModel->load($hasCache);
				$cachedItem->setResponseType('getMaxSizePhoto-' . $photo_id)
						   ->setContent($raw_photo)
						   ->setCreatedTime(date('Y-m-d H:i:s'))
				->save();
			}else{
				$raw_photo = $cacheModel->load($hasCache)->getContent();
			}
	
			$photo_xml = new SimpleXMLElement($raw_photo);
			if($photo_xml['stat'] == 'ok'){
				$sizes_xml = $photo_xml->sizes;
				$sizes_children = $sizes_xml->children();
				$sizes_children_last_index = count($sizes_xml->children()) - 1;
				$photo_max_size = $sizes_children[$sizes_children_last_index];
				$photo_max_size_url = $photo_max_size['source'];
				return $photo_max_size_url;
			}
			
		}else{
			return NULL;
		}
	}
	
	public function getPhotoSet($setid, $page = 1, $per_page = 0){
		if(!isset($page) || $page == '') $page = 1; 
		if(!isset($per_page) || $per_page == '') $per_page = 0;
		$setname = $this->getPhotoSetNameFromID($setid);
		$apikey = Mage::getStoreConfig('flickrconfig/flickrgeneral/apikey');
		
		$cacheModel = Mage::getModel('flickr/flickr'); 
		$cacheCollection = $cacheModel->getCollection();
		$cacheData = $cacheCollection->getData();
		$hasCache = $cacheCollection->hasResponseType('getPhotoSet-' . $setid);
		
		if(empty($cacheData) || $hasCache === false){
			$raw_photoset = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=$apikey&photoset_id=$setid&format=rest");
			$cacheModel->setResponseType('getPhotoSet-' . $setid)
					   ->setContent($raw_photoset)
					   ->setCreatedTime(date('Y-m-d H:i:s'))
			->save();
			//Mage::log('Cache not used for getPhotoSet with ID = ' . $setid, NULL, 'flickrdb.log');
		}elseif($hasCache !== false && $cacheCollection->cacheExpired('getPhotoSet-' . $setid)){
			$raw_photoset = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=$apikey&photoset_id=$setid&format=rest");
			$cachedItem = $cacheModel->load($hasCache);
			$cachedItem->setResponseType('getPhotoSet-' . $setid)
					   ->setContent($raw_photoset)
					   ->setCreatedTime(date('Y-m-d H:i:s'))
			->save();
			//Mage::log('Cache refreshed for getPhotoSet with ID = ' . $setid, NULL, 'flickrdb.log');
		}else{
			$raw_photoset = $cacheModel->load($hasCache)->getContent();
			//Mage::log('Cache used for getPhotoSet with ID = ' . $setid, NULL, 'flickrdb.log');
		}		
		
		$photoset_xml = new SimpleXMLElement($raw_photoset);
		$photos = array();
		$_pages = 1;
		if($photoset_xml['stat'] == 'ok'){
			$_item_count = 0;
			foreach($photoset_xml->photoset->photo as $photo){
				$_item_count++;
				if( (($_item_count > ($page - 1) * $per_page) && ($_item_count <= ($page * $per_page))) || $per_page == 0 ){
					$max_size = $this->getMaxSizePhoto($photo['id']);
					$photos[] = array('id' => $photo['id'], 'title' => $photo['title'], 'server' => $photo['server'], 'farm' => $photo['farm'], 'secret' => $photo['secret'], 'maxsize' => $max_size);
				}
			}
			
			$_result['photoset'] = $this->getPhotoSetFromID($setid);
			$_result['photos'] = $photos;
			$_result['total'] = $_item_count;
			$_result['pages'] = (!empty($per_page) && ($page != 0)) ? ceil($_item_count / $per_page) : 1;
		}
		
		return $_result;
	}
	
	public function carouselHasTooltip(){
		return Mage::getStoreConfig('flickrconfig/flickrphotoset/tooltip');
	}
	
	public function carouselGetTooltipStyle(){
		if($this->carouselHasTooltip()){
			return Mage::getStoreConfig('flickrconfig/flickrphotoset/tooltip_style');
		}else{
			return false;
		}
	}

}
?>