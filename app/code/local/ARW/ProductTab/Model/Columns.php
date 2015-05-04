<?php

class ARW_ProductTab_Model_Columns extends Varien_Object
{
	public function toOptionArray()
	{
		return array(
			array("value"=>'3','label'=>Mage::helper('producttab')->__('3')),
			array("value"=>'4','label'=>Mage::helper('producttab')->__('4')),
			array("value"=>'6','label'=>Mage::helper('producttab')->__('6')),
		);
	}
}