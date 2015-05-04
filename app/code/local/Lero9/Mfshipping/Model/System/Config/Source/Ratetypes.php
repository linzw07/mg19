
<?php
class Lero9_Mfshipping_Model_System_Config_Source_Ratetypes
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => "Sell", 'label'=>Mage::helper('adminhtml')->__('Sell')),
            array('value' => "Cost", 'label'=>Mage::helper('adminhtml')->__('Cost')),
            array('value' => "CostPlus", 'label'=>Mage::helper('adminhtml')->__('CostPlus')),
        
        );
    }

}
