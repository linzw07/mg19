<?php class Novaworks_ThemeOptions_Model_Borderbottoms
{
    public function toOptionArray()
    {
        return array(
        	array('value' => '1', 'label'  => Mage::helper('themeoptions')->__('Yes')),
            array('value' => '2', 'label' => Mage::helper('themeoptions')->__('No'))
        );
    }

}?>