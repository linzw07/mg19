<?php
class Novaworks_Setupguide_Block_System_Config_Form_Fieldset_Status 
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
    	$storeId = Mage::app()->getStore()->getStoreId();
    	if(Mage::getStoreConfig('design/theme/template', $storeId) == 'nova_bazien' && Mage::getStoreConfig('design/theme/skin', $storeId) == 'nova_bazien' && Mage::getStoreConfig('design/theme/layout', $storeId) == 'nova_bazien') {
        	$html = '<div class="is-completed">Completed!</div>';
       } else {
	        $html = '<div class="not-completed">Incomplete</div>';
        }
        
        return $html;
    }
}
