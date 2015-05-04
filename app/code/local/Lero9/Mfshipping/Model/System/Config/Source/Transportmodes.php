
<?php
class Lero9_Mfshipping_Model_System_Config_Source_Transportmodes
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => "Road", 'label'=>Mage::helper('adminhtml')->__('Road')),
            array('value' => "Air", 'label'=>Mage::helper('adminhtml')->__('Air'))
        );
    }

}
