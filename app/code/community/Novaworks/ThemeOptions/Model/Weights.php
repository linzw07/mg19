<?php class Novaworks_ThemeOptions_Model_Weights
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'normal', 'label'=>Mage::helper('themeoptions')->__('Normal')),
            array('value'=>'bold', 'label'=>Mage::helper('themeoptions')->__('Bold'))  
        );
    }

}?>