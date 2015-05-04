<?php class Novaworks_ThemeOptions_Model_Borderstyles
{
    public function toOptionArray()
    {
        return array(
        	array('value' => 'solid', 'label'  => Mage::helper('themeoptions')->__('Solid')),
            array('value' => 'dotted', 'label'  => Mage::helper('themeoptions')->__('Dotted')),
            array('value' => 'dashed', 'label'  => Mage::helper('themeoptions')->__('Dashed'))
        );
    }

}?>