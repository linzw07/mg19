<?php class Novaworks_Setupguide_Model_Importblocks
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'adminhtml/cms_enhanced_block/uploadCsv/', 'label'=>Mage::helper('setupguide')->__('Import Static Blocks')),
        );
    }

}?>