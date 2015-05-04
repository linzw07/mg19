<?php class Novaworks_Setupguide_Model_Activethemebuttonguide
{
    public function toOptionArray()
    {
        return array(
			array('value'=>'http://novaworks.net/support/knowledgebase/requirements/', 'label'=>Mage::helper('setupguide')->__('Requirements')),      
        	array('value'=>'http://novaworks.net/support/knowledgebase/installation/', 'label'=>Mage::helper('setupguide')->__('Installation')),
        );
    }

}?>