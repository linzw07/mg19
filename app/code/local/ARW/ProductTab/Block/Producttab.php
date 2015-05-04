<?php
class ARW_ProductTab_Block_Producttab extends Mage_Catalog_Block_Product_Abstract implements Mage_Widget_Block_Interface 
{
	public function getConfig($name)
	{
		switch($name){
			case "tab_identifier" : 
				$tab_identifiers = array();
				$tab_identifiers = explode(',',$this->getData('tab_identifier'));
				return $tab_identifiers;
				break;
			case "identifier" :
				return $this->getData('identifier');
				break;
			default:
				return '';
		}
	}
	public function getIdByIdentifier()
	{
		$tabIds=array();
		$array_identifiers=$this->getConfig('tab_identifier');
		foreach($array_identifiers as  $identifier){
			$collection=Mage::getModel('producttab/tab')->getCollection()
																->addFieldToFilter('arw_identifier',$identifier)
																->getFirstItem()
																->getData();
			$tabIds[]=$collection['arw_tab_id'];
		}
		/* var_dump($array_identifiers); */
			return $tabIds;
	}
	public function getFilterStore()
	{
		$collection=Mage::getModel('producttab/tab')->getCollection()
																	 ->addStoreFilter(Mage::app()->getStore(true)->getId());
		return $collection;
		}
	public function getArrayTabsFilterStore()
	{
		$tabsIdArray=array();
		$collection=$this->getFilterStore()->getData();
		foreach($collection as $con)
		{
			$tabsIdArray[]=$con['arw_tab_id'];
			}
		if($tabs=$this->getIdByIdentifier())
		{
			$tabsFilterStore =array_merge(array_intersect($tabsIdArray,$tabs),array());
		}else
		{
			$tabsFilterStore=$tabsIdArray;
		}
		return $tabsFilterStore;
	}
	public function getTabs()
		{
			
			$collection=Mage::getModel('producttab/tab')->getCollection();
			$tabsFilterStore = $this->getArrayTabsFilterStore(); 
			$collection->addFieldToFilter('arw_tab_id',array('in'=>$tabsFilterStore));	
			$collection->setOrder('arw_tab_id','ASC');
			$collection->getData();
			return $collection;
			
		}
	public function getPagerHtml()
    {
            if (!$this->_pager) {
                $this->_pager = $this->getLayout()
                    ->createBlock('producttab/producttab', 'first.productlist')
					->setTemplate('arw/producttab/productfirst.phtml');
                $this->_pager->setCollection($this->_getProductFirstCollection());
				$this->_pager->setIdentifier($this->getData('identifier'));	
				$this->_pager->setFirst($this->getTabFirst());	
            }
            if ($this->_pager instanceof Mage_Core_Block_Abstract) {
                return $this->_pager->toHtml();
            }
        return '';
    }

	public function getTabFirst()
	{
		$collection=Mage::getModel('producttab/tab');
		$tabsFilterStore = $this->getArrayTabsFilterStore(); 
		$tabsFilterStorefirst=$tabsFilterStore[0];		
		$collection->load($tabsFilterStorefirst); 
		return $collection->getData();
	}
	public function getTabslider()
	{
			if($id= $this->getRequest()->getParam('ajax_tab_id')){
			$collection=Mage::getModel('producttab/tab')->load($id)->getData();
			return $collection;
		}
	}
	public function getLoadedProductCollection($data) {
        if (!$this->_productCollection){
            $product_type = $data['product_type'];
			$tab_id	=$data['arw_tab_id'];
            $collection = null;
			$Ids=$this->getArWCatIds($data);
            switch ($product_type) {
                case ARW_ProductTab_Model_Product_Type::NONE:
					//$productdata=$data['product_data'];
                    $collection = $this->getNoneCollection($Ids,$tab_id,$data['product_sort_type']);
                    break;
                case ARW_ProductTab_Model_Product_Type::RANDOM:
                    $collection = $this->getRandomCollection($Ids,$tab_id);
                    break;
                case ARW_ProductTab_Model_Product_Type::BESTSELL:
                    $collection = $this->getBestSellerCollection($Ids,$tab_id);
                    break;
                case ARW_ProductTab_Model_Product_Type::TOPRATED:
                    $collection = $this->getTopRateCollection($Ids,$tab_id);
                    break;
				case ARW_ProductTab_Model_Product_Type::MOSTREVIEWED:
                    $collection = $this->getMostViewedCollection($Ids,$tab_id);
                    break;
				case ARW_ProductTab_Model_Product_Type::RECENTLYADDED:
                    $collection = $this->getRecentlyAddedCollection($Ids,$tab_id);
                    break;
				
				case ARW_ProductTab_Model_Product_Type::NEWADD:
                    $collection = $this->getNewCollection($Ids,$tab_id);
                    break; 	
				case ARW_ProductTab_Model_Product_Type::LASTORDERS:
                    $collection = $this->getLastOrderedCollection($Ids,$tab_id);
                    break;
				case ARW_ProductTab_Model_Product_Type::DISCOUNT:
                    $collection = $this->getDiscountCollection($Ids,$tab_id);
					break;
				case ARW_ProductTab_Model_Product_Type::CURRENTCATEGORY:
					if($Ids){
						$collection=$this->getLoadCurrentCatCollection($Ids,$data['current_category_type'],$tab_id);
					}else{	
						$collection = $this->getNoneCollection($Ids,$tab_id);
					}
					break;
            }
            Mage::dispatchEvent('catalog_block_product_list_collection', array(
                'collection' => $collection
            ));
            $this->_productCollection = $collection;
        }
        return $this->_productCollection;
    }
	protected function getLoadCurrentCatCollection($Ids,$current_type,$tab_id){
		if(!$this->_productsCollection){
		 switch ($current_type) {
                case ARW_ProductTab_Model_Category_Current_Type::RANDOM:
                    $collection = $this->getRandomCollection($Ids,$tab_id);
                    break;
                case ARW_ProductTab_Model_Category_Current_Type::BESTSELL:
                    $collection = $this->getBestSellerCollection($Ids,$tab_id);
                    break;
                case ARW_ProductTab_Model_Category_Current_Type::TOPRATED:
                    $collection = $this->getTopRateCollection($Ids,$tab_id);
                    break;
				case ARW_ProductTab_Model_Category_Current_Type::MOSTREVIEWED:
                    $collection = $this->getMostViewedCollection($Ids,$tab_id);
                    break;
				case ARW_ProductTab_Model_Category_Current_Type::RECENTLYADDED:
                    $collection = $this->getRecentlyAddedCollection($Ids,$tab_id);
                    break;
				
				case ARW_ProductTab_Model_Category_Current_Type::NEWADD:
                    $collection = $this->getNewCollection($Ids,$tab_id);
                    break; 	
				case ARW_ProductTab_Model_Category_Current_Type::LASTORDERS:
                    $collection = $this->getLastOrderedCollection($Ids,$tab_id);
                    break;
				case ARW_ProductTab_Model_Category_Current_Type::DISCOUNT:
                    $collection = $this->getDiscountCollection($Ids,$tab_id);
					break;
            }
			 $this->_productsCollection = $collection;
		}
			return $this->_productsCollection;
	}
	public function _getProductCollection()
    {	
	if($this->getRequest()->getParam('ajax_tab_id')){
			$id= $this->getRequest()->getParam('ajax_tab_id');
			$data=$this->loadTableDataById($id);
			$collection=$this->getLoadedProductCollection($data);
			return $collection;
		}
	
	}
	public function _getProductFirstCollection()
    {	
			$tab=$this->getTabFirst();
			$id  = $tab['arw_tab_id'];
			$data=$this->loadTableDataById($id);
			$collection=$this->getLoadedProductCollection($data);
			return $collection;
	}
	public function loadTableDataById($id)
	{
		$collection=Mage::getModel('producttab/product')->getCollection()
														->addFieldToFilter('arw_tab_id',$id)
														->getFirstItem();
		return $collection->getData();
	}
	public function getLimitProduct($id)
    {	
		$collection=Mage::getModel('producttab/tab')->load($id)->getData();
		if($collection['arw_use_default']&&$collection['arw_use_default']==1){
			$limit=Mage::helper('producttab')->getCf('limit');	
		}else{
			$limit=$collection['arw_limit'];
		}
		return $limit ;
	}
	public function getNameTypeProduct($id)
	{
		$name='';
		$tableProduct=$this->loadTableDataById($id);
		if($tableProduct['product_type']==ARW_ProductTab_Model_Product_Type::CURRENTCATEGORY)
		{
			$type_product=Mage::getModel('producttab/category_current_type')->toOptionArray();
			foreach($type_product as $val=>$lab)
			{
				if($lab['value']==$tableProduct['current_category_type'])
				{
					$name=$lab['label'];
					break;
				}
			}
		}else{
			$type_product=Mage::getModel('producttab/product_type')->toOptionArray();
			foreach($type_product as $val=>$lab)
			{
				if($lab['value']==$tableProduct['product_type'])
				{
					$name=$lab['label'];
					break;
				}
			}
		}
		$name=strtolower($name);
		$name=str_replace(' ','_',$name);
		return $name;
	}
	protected function getArWCatIds($data){
		if($data['product_type']==ARW_ProductTab_Model_Product_Type::CURRENTCATEGORY){
				if(Mage::registry('current_category')&&Mage::registry('current_category')->getId()){
					$Ids=array();
					if(empty($Ids)){
					$Ids[]=Mage::registry('current_category')->getId();	
					 } 
				}
			}else{
					$Ids=array();
					$Ids=explode(',',$data['product_data']);
	}
	return $Ids;
}	
	public function getNoneCollection($Ids,$tab_id,$sort)
    {	
        if (is_null($this->_productCollection)) {
			$productIds = array();
			$productIds=$Ids;
			$result = array_unique($productIds);				
			$collection = Mage::getResourceModel('catalog/product_collection');
            $attributes = Mage::getSingleton('catalog/config')->getProductAttributes();
            $collection->addAttributeToSelect($attributes)
                ->addMinimalPrice()
                ->addFinalPrice() 
                ->addTaxPercents()
                ->addStoreFilter();

            $collection->addIdFilter($result);
			switch($sort){
				case ARW_ProductTab_Model_Product_Productsort::NEWFIRST:
					$collection->getSelect()->order('entity_id desc');
					break;
				case ARW_ProductTab_Model_Product_Productsort::OLDFIRST:
					$collection->getSelect()->order('entity_id asc');
					break;
				case ARW_ProductTab_Model_Product_Productsort::RANDOM:
					$collection->getSelect()->order('RAND()');
					break;
			}
            Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
            Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
			$collection->setPage(1, $this->getLimitProduct($tab_id)); 
			$collection->load();
            $this->_productCollection = $collection;
			
        }
        return $this->_productCollection;
    }
	  protected function getRandomCollection($Ids,$tab_id){
        /* $catIds = explode(',', $Ids); */
		$catIds=$Ids;
        $catProIds = $this->getProductIdsByCategories($Ids);
        $collection = Mage::getResourceModel('catalog/product_collection');
        Mage::getModel('catalog/layer')->prepareProductCollection($collection);
        $collection->getSelect()->order('RAND()');
        $collection->addStoreFilter();
        if (count($catProIds)) $collection->addIdFilter($catProIds);
        $collection->setPage(1,$this->getLimitProduct($tab_id));
        return $collection;
    }
	   protected function getMostViewedCollection($Ids,$tab_id) {
        $ids = Mage::getResourceModel('reports/product_collection')->addViewsCount()->load()->getLoadedIds();
        $catIds = $Ids;
        if(!empty($catIds)) {
          /*   $catIds = explode(',', $catIds); */
            $arr_productids = array_intersect($ids, $this->getProductIdsByCategories($catIds));
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addMinimalPrice()
				->addFinalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addIdFilter($arr_productids);
            $products->getSelect()->order(sprintf('FIELD(e.entity_id, %s)', implode(',', $arr_productids)));
        } else {
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addMinimalPrice()
                ->addFinalPrice() 
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addIdFilter($ids);
            $products->getSelect()->order(sprintf('FIELD(e.entity_id, %s)', implode(',', $ids)));
        }
       $products->setPage(1, $this->getLimitProduct($tab_id)); 
        $products->load();
        return $products;
    }
	  protected function getBestSellerCollection($Ids,$tab_id) {
        $catIds = $Ids;
        if(!empty($catIds)) {
           /*  $catIds = explode(',', $catIds); */
            $ctf = array();
            foreach ($catIds as $cat){
                $ctf[]['finset'] = $cat;
            }
            $products = Mage::getModel('catalog/product')->getCollection();
            $products->addAttributeToSelect('*')->addStoreFilter();
            $products->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
                     ->addAttributeToFilter('category_id', array($ctf));
        } else {
            $products = Mage::getModel('catalog/product')->getCollection();
            $products->addAttributeToSelect('*')->addStoreFilter();
        }
        $orderItems = Mage::getSingleton('core/resource')->getTableName('sales/order_item');
        $orderMain =  Mage::getSingleton('core/resource')->getTableName('sales/order');
        $products
			->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
			->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
			->getSelect()
            ->join(array('items' => $orderItems), "items.product_id = e.entity_id", array('count' => 'SUM(items.qty_ordered)'))
            ->join(array('trus' => $orderMain), "items.order_id = trus.entity_id", array())
            ->where('trus.status = ?', 'complete')
            ->group('e.entity_id')
            ->order('count DESC');
        $products->setPage(1, $this->getLimitProduct($tab_id)); 
        $products->load();
        return $products;
    }
	protected function getTopRateCollection($Ids,$tab_id) {
		$catIds = $Ids;
        if(!empty($catIds)) {
            $ctf = array();
            foreach ($catIds as $cat){
                $ctf[]['finset'] = $cat;
            }
            $products = Mage::getModel('catalog/product')->getCollection();
            $products->addAttributeToSelect('*')->addStoreFilter();
            $products->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
                     ->addAttributeToFilter('category_id', array($ctf));
        } else {
            $products = Mage::getModel('catalog/product')->getCollection();
            $products->addAttributeToSelect('*')->addStoreFilter();
        }
        $rating_summary = Mage::getSingleton('core/resource')->getTableName('review/review_aggregate');
        $products
			->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
			->getSelect()
            ->join(array('rat' => $rating_summary), "rat.entity_pk_value = e.entity_id", array())
         //   ->where('rat.status = ?', 'complete')
            ->group('e.entity_id')
            ->order('rating_summary DESC');
         $products->setPage(1, $this->getLimitProduct($tab_id)); 
        $products->load();
        return $products;
	}
	 protected function getRecentlyAddedCollection($Ids,$tab_id) {
        $catIds = $Ids;
        if(!empty($catIds)) {
           /*  $catIds = explode(',', $catIds); */
            $arr_productids = $this->getProductIdsByCategories($catIds);
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addMinimalPrice()
                ->addFinalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addIdFilter($arr_productids)
				->addAttributeToSort('created_at', 'desc');
        }
         $products->setPage(1, $this->getLimitProduct($tab_id)); 
        $products->load();
        return $products;
    }
	 protected function getNewCollection($Ids,$tab_id){
        $todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		$catids = $Ids;
        if(!empty($catIds)) {
            $arr_productids = $this->getProductIdsByCategories($catIds);
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('*')
                ->addMinimalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addIdFilter($arr_productids)
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addAttributeToFilter('news_from_date', array('date' => true, 'to' => $todayDate))
                ->addAttributeToFilter(array(
                    array('attribute' => 'news_to_date', 'date' => true, 'from' => $todayDate),
                    array('attribute' => 'news_to_date', 'is' => new Zend_Db_Expr('null'))),
                    '',
                    'left')
                ->addAttributeToSort('news_from_date', 'desc');
        } else {
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('*')
                ->addMinimalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addAttributeToFilter('news_from_date', array('date' => true, 'to' => $todayDate))
                ->addAttributeToFilter(array(
                    array('attribute' => 'news_to_date', 'date' => true, 'from' => $todayDate),
                    array('attribute' => 'news_to_date', 'is' => new Zend_Db_Expr('null'))),
                    '',
                    'left')
                ->addAttributeToSort('news_from_date', 'desc');
        }
         $products->setPage(1, $this->getLimitProduct($tab_id)); 
        $products->load();
        return $products;
    }
	protected function getLastOrderedCollection($Ids,$tab_id)
	{
			$storeId = Mage::app()->getStore()->getId();
         	$itemsCollection = Mage::getResourceModel('sales/order_item_collection') 
                            ->join('order', 'order_id=entity_id') 
                            ->addFieldToFilter('main_table.store_id', array('eq'=>$storeId))
                            ->setOrder('main_table.created_at','desc');
	        $itemsCollection->getSelect()->group(`main_table`.'product_id');

	        $prod = array();        
	        if(sizeof($itemsCollection)>0)
	        {
	            foreach ($itemsCollection as $item) {
	                //$product = Mage::getModel('catalog/product')->load($item->getProductId());
	                $prod[] =$item->getProductId(); 
	            }    
	        }
			
			$catIds = $Ids;
			if(!empty($catIds)){
			/* $catIds = explode(',',$catids); */
			$arr_productids = array_intersect($prod, $this->getProductIdsByCategories($catIds));
		/*  var_dump($arr_productids);die(); */
			$products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
				->addIdFilter($arr_productids)
                ->addMinimalPrice()
                ->addFinalPrice() 
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);	
			$products->getSelect()->order(sprintf('FIELD(e.entity_id, %s)', implode(',', $arr_productids)));
			}
			$products->setPage(1, $this->getLimitProduct($tab_id)); 
			$products->load();
			return $products;
	}
	 protected function getDiscountCollection($Ids,$tab_id){
        $catIds = $Ids;
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('*')
            ->addMinimalPrice()
            ->addUrlRewrite()
            ->addTaxPercents()
            ->addStoreFilter()
            ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);

        $resource = Mage::getSingleton('core/resource');
        $connection = $resource->getConnection('core_read');
        $tableName = $resource->getTableName('catalogrule/rule_product');
        $tableAlias = 'catalogrule_product_idx';
        $subSelect  = $connection->select()->from($tableName, array('product_id', 'customer_group_id'));
        $conditions = array(
            "{$tableAlias}.product_id = e.entity_id",
            $connection->quoteInto("{$tableAlias}.customer_group_id = ?", $this->_customerGroupId)
        );
        $collection->getSelect()->join(
            array($tableAlias => $subSelect),
            join(' AND ', $conditions),
            array()
        );

        if (!empty($catIds)){
            $catProIds = $this->getProductIdsByCategories($catIds);
            if (count($catProIds)) $collection->addIdFilter($catProIds);
        }

		$collection->setPage(1, $this->getLimitProduct($tab_id)); 
        $collection->load();
        return $collection;
    }
	 public function getProductsByCategory($catId) {
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->addStoreFilter();

        if($catId) {
            $category = Mage::getModel('catalog/category')->load($catId);
            if($category->getId()) {
                $collection->addCategoryFilter($category);
            }
        }
        return $collection;
    }
	
    public function getProductIdsByCategories($catIds) {
        $productIds = array();
        if(is_array($catIds) && count($catIds)) {
            foreach($catIds as $catId) {
                if (is_numeric($catId)) {
                    $productIdArr = $this->getProductsByCategory($catId);
                    if(count($productIdArr)) {
                        foreach($productIdArr as $product) {
                            $productIds[] = $product->getId();
                        }
                    }
                }
            }
        }
        $productIds = array_unique($productIds);
        return $productIds;
    }

	  public function getSendUrl()
    {
        $url = $this->getUrl('producttab/producttab/product');
        if (isset($_SERVER['HTTPS']) && 'off' != $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "")
        {
            $url = str_replace('http:', 'https:', $url);
        }
        return $url;
    }
    
}