<?php
class Novaworks_CustomWidgets_Block_Vmenu extends Mage_Core_Block_Template
{
    /**
     * Set default template.
     *
     * @return void
     */
    protected function _construct()
    {
    	echo Mage::app()->getLayout()->createBlock('sidenav/navigation')->setTemplate('codnitive/sidenav/navigation.phtml')->toHtml();
    }
}