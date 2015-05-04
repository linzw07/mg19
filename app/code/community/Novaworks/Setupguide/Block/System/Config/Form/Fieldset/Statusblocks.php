<?php
class Novaworks_Setupguide_Block_System_Config_Form_Fieldset_Statusblocks 
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
    	$storeId = Mage::app()->getStore()->getStoreId();
    	if(Mage::getModel('cms/block')->load('block_payment_method')->getIsActive()) {
        	$html = '<div class="is-completed">Completed!</div>';
       } else {
	        $html = '<div class="not-completed">Incomplete</div>';
        }
        
        return $html;
    }
}
