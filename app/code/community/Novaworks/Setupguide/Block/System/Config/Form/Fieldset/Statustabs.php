<?php
class Novaworks_Setupguide_Block_System_Config_Form_Fieldset_Statustabs
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
    	$collection=Mage::getModel('producttab/tab')->getCollection();
    	if($collection->getData()) {
        	$html = '<div class="is-completed">Completed!</div>';
       } else {
	        $html = '<div class="not-completed">Incomplete</div>';
        }
        
        return $html;
    }
}
