<?php
class ARW_ProductTab_ProducttabController extends Mage_Core_Controller_Front_Action
{
	public function productAction()
	{	
		if($this->getRequest()->getPost('ajax_tab_id')){	
			$_POST['ajax_tab_id']=$this->getRequest()->getPost('ajax_tab_id');
			$html='';
			$produtlist=Mage::app()->getLayout()->createBlock('producttab/producttab','arw_product_list')
													->setTemplate('arw/producttab/product.phtml');
			$html .= $produtlist->toHtml();
			$result = array(
				'productlist'   =>  $html, 
			  );
		 }
       	$this->getResponse()->setBody(Zend_Json::encode($result));
	}
}
