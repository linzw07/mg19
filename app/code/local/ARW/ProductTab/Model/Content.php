<?php

class ARW_ProductTab_Model_Content extends Varien_Object
{
		const SHOW_FULLGRID	 = 2;
		const SHOW_SLIDE	 = 1;
		const SHOW_GRID		 = 0;		
	public function toOptionArray()
	{
		return array(
			array("value"=>self::SHOW_SLIDE,'label'		=>Mage::helper('producttab')->__('Show Slide')),
			array("value"=>self::SHOW_GRID,'label' 		=>Mage::helper('producttab')->__('Show Grid')),
			array("value"=>self::SHOW_FULLGRID,'label' 		=>Mage::helper('producttab')->__('Show Full Grid')),
		);
	}
}