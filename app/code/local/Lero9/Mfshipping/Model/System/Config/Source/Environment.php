<?php
class Lero9_Mfshipping_Model_System_Config_Source_Environment
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => "Test", 'label'=>Mage::helper('adminhtml')->__('Test')),
            array('value' => "Production", 'label'=>Mage::helper('adminhtml')->__('Production'))
        );
    }

}
