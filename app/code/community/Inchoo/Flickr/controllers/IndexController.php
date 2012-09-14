<?php

class Inchoo_Flickr_IndexController extends Mage_Core_Controller_Front_Action{

    public function indexAction(){
		$this->setsAction();
    }
	
	// Photosets (Gallery)
	public function setsAction(){
		$this->loadLayout();
		$root = $this->getLayout()->getBlock('root');
		$root->setTemplate('page/1column.phtml');
		
		$block = $this->getLayout()->createBlock('flickr/photosets', 'flickrgallery')->setTemplate('inchoo/flickrgallery/photosets.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		
		$this->_initLayoutMessages('core/session');
		$this->renderLayout();
	}
	public function renderSetsAction(){
		echo $this->getLayout()->
			createBlock('flickr/photosets')->
			setTemplate('inchoo/flickrgallery/photosets/view.phtml')->
			toHtml();
	}
	
	// Photoset (Photos)
	public function setAction(){
		$this->loadLayout();
		$root = $this->getLayout()->getBlock('root');
		$root->setTemplate('page/1column.phtml');
		
		$block = $this->getLayout()->createBlock('flickr/photoset', 'flickrgalleryset')->setTemplate('inchoo/flickrgallery/photoset.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		
		$this->_initLayoutMessages('core/session');
		$this->renderLayout();
	}
	public function renderSetAction(){
		echo $this->getLayout()->
			createBlock('flickr/photoset')->
			setTemplate('inchoo/flickrgallery/photoset/view.phtml')->
			toHtml();
	}
	
	// Carousle
	public function renderCarouselAction(){
		echo $this->getLayout()->
			createBlock('flickr/photosets')->
			setTemplate('inchoo/flickrgallery/carousel/view.phtml')->
			toHtml();
	}

}