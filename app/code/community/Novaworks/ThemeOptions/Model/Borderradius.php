<?php class Novaworks_ThemeOptions_Model_Borderradius
{
    public function toOptionArray()
    {
        return array(
        	array('value' => '0px', 'label'  => Mage::helper('themeoptions')->__('0px')),
            array('value' => '1px', 'label'  => Mage::helper('themeoptions')->__('1px')),
            array('value' => '2px', 'label'  => Mage::helper('themeoptions')->__('2px')),
            array('value' => '3px', 'label'  => Mage::helper('themeoptions')->__('3px')),
            array('value' => '4px', 'label'  => Mage::helper('themeoptions')->__('4px')),
            array('value' => '5px', 'label'  => Mage::helper('themeoptions')->__('5px')),
            array('value' => '6px', 'label'  => Mage::helper('themeoptions')->__('6px')),
            array('value' => '7px', 'label'  => Mage::helper('themeoptions')->__('7px')),
            array('value' => '8px', 'label'  => Mage::helper('themeoptions')->__('8px')),
            array('value' => '9px', 'label'  => Mage::helper('themeoptions')->__('9px')),
            array('value' => '10px', 'label' => Mage::helper('themeoptions')->__('10px'))
        );
    }

}?>