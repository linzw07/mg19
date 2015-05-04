
<?php
class Lero9_Mfshipping_Model_System_Config_Source_Routingtypes
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => "DirectToConsignee", 'label'=>Mage::helper('adminhtml')->__('Direct To Consignee')),
            array('value' => "DomesticFreightForwarding", 'label'=>Mage::helper('adminhtml')->__('Domestic Freight Forwarding')),
            array('value' => "FullTruckLoad", 'label'=>Mage::helper('adminhtml')->__('Full Truck Load')),
            array('value' => "LinehaulDirectToConsignee", 'label'=>Mage::helper('adminhtml')->__('Linehaul Direct To Consignee')),
            array('value' => "LinehaulDirectToDepot", 'label'=>Mage::helper('adminhtml')->__('Linehaul Direct To Depot')),
            array('value' => "LocalCartage", 'label'=>Mage::helper('adminhtml')->__('Local Cartage')),
            array('value' => "LocalDirect", 'label'=>Mage::helper('adminhtml')->__('Local Direct')),

        );
    }

}
