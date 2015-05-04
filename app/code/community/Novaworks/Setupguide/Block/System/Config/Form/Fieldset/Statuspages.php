<?php
class Novaworks_Setupguide_Block_System_Config_Form_Fieldset_Statuspages 
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
    	$storeId = Mage::app()->getStore()->getStoreId();
    	if(Mage::getModel('cms/page')->load('home')->getIsActive()) {
        	$html = '<div class="is-completed">Completed!</div>';
       } else {
	        $html = '<div class="not-completed">Incomplete</div>';
        }
        
        return $html;
    }
}
