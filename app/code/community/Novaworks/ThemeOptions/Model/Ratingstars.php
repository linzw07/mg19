<?php class Novaworks_ThemeOptions_Model_Ratingstars
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'stars1', 'label'  => Mage::helper('themeoptions')->__('1')),
            array('value' => 'stars2', 'label'  => Mage::helper('themeoptions')->__('2')),
            array('value' => 'stars3', 'label'  => Mage::helper('themeoptions')->__('3')),
            array('value' => 'stars4', 'label'  => Mage::helper('themeoptions')->__('4')),
            array('value' => 'stars5', 'label'  => Mage::helper('themeoptions')->__('5')),
            array('value' => 'stars6', 'label'  => Mage::helper('themeoptions')->__('6')),
            array('value' => 'stars7', 'label'  => Mage::helper('themeoptions')->__('7')),
            array('value' => 'stars8', 'label'  => Mage::helper('themeoptions')->__('8')),
            array('value' => 'stars9', 'label'  => Mage::helper('themeoptions')->__('9')),
            array('value' => 'stars10', 'label'  => Mage::helper('themeoptions')->__('10'))
        );
    }

}?>