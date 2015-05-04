<?php
class Novaworks_Setupguide_Block_System_Config_Form_Fieldset_Statusslider
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {    	
    	if(Mage::getModel('revslider/slider')->load(1)->getStatus() == 1) {
        	$html = '<div class="is-completed">Completed!</div>';
       } else {
	        $html = '<div class="not-completed">Incomplete</div>';
        }
        
        return $html;
    }
}
