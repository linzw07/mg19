<?php
class Lero9_Mfshipping_Model_System_Config_Source_Feetypes
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => "Insurance", 'label'=>Mage::helper('adminhtml')->__('Insurance')),
            array('value' => "DeclaredValue", 'label'=>Mage::helper('adminhtml')->__('Declared Value'))
        );
    }

}
