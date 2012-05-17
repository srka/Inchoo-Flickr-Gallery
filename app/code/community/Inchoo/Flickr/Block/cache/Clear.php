<?php 
class Inchoo_Flickr_Block_Cache_Clear extends Mage_Adminhtml_Block_System_Config_Form_Field {
	
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $url = $this->getUrl('flickr/cache/clear'); //

        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setType('button')
                    ->setClass('scalable')
                    ->setLabel('Flush Flickr API Response Cache')
                    ->setOnClick("setLocation('$url')")
                    ->toHtml();

        return $html;
    }
}
?>
