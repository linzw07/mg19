<?php
class Lero9_Mfshipping_Model_System_Config_Source_Jobtypes
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => "Delivery", 'label'=>Mage::helper('adminhtml')->__('Delivery')),
            array('value' => "Pickup", 'label'=>Mage::helper('adminhtml')->__('Pickup')),
            array('value' => "Linehaul", 'label'=>Mage::helper('adminhtml')->__('Linehaul')),
            array('value' => "TMS", 'label'=>Mage::helper('adminhtml')->__('TMS'))
        );
    }

}
