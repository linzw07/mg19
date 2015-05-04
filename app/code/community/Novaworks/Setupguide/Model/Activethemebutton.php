<?php class Novaworks_Setupguide_Model_Activethemebutton
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'installer/adminhtml_installerForm/index/', 'label'=>Mage::helper('setupguide')->__('Active Theme')),
        );
    }

}?>