<?php class Novaworks_ThemeOptions_Model_Uppercases
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'uppercase', 'label'=>Mage::helper('themeoptions')->__('Yes')),
            array('value'=>'none', 'label'=>Mage::helper('themeoptions')->__('No'))  
        );
    }

}?>