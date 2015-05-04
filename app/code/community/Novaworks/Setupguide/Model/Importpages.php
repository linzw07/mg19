<?php class Novaworks_Setupguide_Model_Importpages
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'adminhtml/cms_enhanced_page/uploadCsv/', 'label'=>Mage::helper('setupguide')->__('Import CMS Pages')),
        );
    }

}?>