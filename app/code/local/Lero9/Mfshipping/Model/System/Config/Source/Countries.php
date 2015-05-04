<?php
class Lero9_Mfshipping_Model_System_Config_Source_Countries
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => "US", 'label'=>Mage::helper('adminhtml')->__('US')),
            array('value' => "CA", 'label'=>Mage::helper('adminhtml')->__('CA')),
            array('value' => "MX", 'label'=>Mage::helper('adminhtml')->__('MX')),
                array('value' => "NZ", 'label'=>Mage::helper('adminhtml')->__('NZ'))
        );
    }

}
