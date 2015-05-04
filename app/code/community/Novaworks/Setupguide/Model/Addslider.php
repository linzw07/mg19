<?php class Novaworks_Setupguide_Model_Addslider
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'adminhtml/widget_instance/new/', 'label'=>Mage::helper('setupguide')->__('Add New Widget Instance')),
        );
    }

}?>