<?php 
class Inchoo_Flickr_Model_Mysql4_Flickr_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
	public function _construct(){
		$this->_init('flickr/flickr');
	}
	
	public function hasResponseType($response_type){
		$this->addFilter('response_type', array('eq' => $response_type))->load();
		$result = $this->getData();
		if(empty($result)){
			return false;
		}else{
			return $result[0]['flickr_id'];
		}
	}
	
	public function cacheExpired($response_type){
		
		$cacheExpirationHours = Mage::getStoreConfig('flickrconfig/cache/timeout');
		$hasCache = $this->hasResponseType($response_type);
		if($hasCache !== false){
			$this->addFilter('flickr_id', array('eq' => $hasCache))->load();
			$result = $this->getData();
			$item = $result[0];
			$itemTime = $item['created_time'];
			$cacheExpiration = strtotime("+$cacheExpirationHours hours", strtotime($itemTime));
			
			return (time() > $cacheExpiration);
		}else{
			return NULL;
		}

	}
}