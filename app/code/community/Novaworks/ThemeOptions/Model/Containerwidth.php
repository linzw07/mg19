<?php class Novaworks_ThemeOptions_Model_Containerwidth
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>980, 'label'=>Mage::helper('themeoptions')->__('980px')),
            array('value'=>1170, 'label'=>Mage::helper('themeoptions')->__('1170px')),
            array('value'=>1360, 'label'=>Mage::helper('themeoptions')->__('1440px'))            
        );
    }

}?>