
<?php
class Lero9_Mfshipping_Model_System_Config_Source_Quoteresultsources
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => "MainStreet", 'label'=>Mage::helper('adminhtml')->__('Main Street')),
            array('value' => "TMS", 'label'=>Mage::helper('adminhtml')->__('TMS')),
            array('value' => "CloudLogistics", 'label'=>Mage::helper('adminhtml')->__('Cloud Logistics')),
        );
    }

}
