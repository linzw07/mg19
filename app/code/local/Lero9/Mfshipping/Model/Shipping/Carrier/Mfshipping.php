<?php  
    class Lero9_Mfshipping_Model_Shipping_Carrier_Mfshipping     
		extends Mage_Shipping_Model_Carrier_Abstract
		implements Mage_Shipping_Model_Carrier_Interface
	{  
        protected $_code = 'mfshipping';  

        const USA_COUNTRY_ID = 'US';
 
        /**
         * Tracking link for mainfreight
         */
        const TRACKING_LINK = "";
        /**
         * Rate service WSDL location
         */
        const RATE_SERVICE_WSDL = 'http://webservicesuat.mainfreightusa.com/MainfreightRating/Service.svc?wsdl';

        /**
         * Rate request data
         *
         * @var Mage_Shipping_Model_Rate_Request|null
         */
        protected $_request = null;

        /**
         * Raw rate request data
         *
         * @var Varien_Object|null
         */
        protected $_rawRequest = null;

        /**
         * Rate result data
         *
         * @var Mage_Shipping_Model_Rate_Result|null
         */
        protected $_result = null;

        /**
         * Path to wsdl file of rate service
         *
         * @var string
         */
        protected $_rateServiceWsdl;

        /**
         * Flag for check carriers for activity
         *
         * @var string
         */
        protected $_activeFlag = 'active';

        protected $motorClasses = "Code50";

        /**
         * Soap helper class
         * 
         * @var Lero9_MfShipping_Helper_Api
         */
        protected $_soapHelper = null;


        public function __construct()
        {
            parent::__construct();
            $this->_rateServiceWsdl = self::RATE_SERVICE_WSDL;
            $this->_soapHelper = Mage::helper('mfshipping');
        }
        /**
         * Create soap client with selected wsdl
         *
         * @param string $wsdl
         * @param bool|int $trace
         * @return SoapClient
         */
        protected function _createSoapClient()
        {
           $client = new SoapClient($this->_rateServiceWsdl, array('trace' => "false",'keep_alive'=>true,'exceptions'=>true,'connection_timeout'=>30,'cache_wsdl'=>WSDL_CACHE_BOTH,));
            return $client;
        }

        /**
         * Create rate soap client
         *
         * @return SoapClient
         */
        protected function _createRateSoapClient()
        {
            return $this->_soapHelper->connect($this->_rateServiceWsdl);
        }


        /**
         * Prepare and set request to this instance
         *
         * @param Mage_Shipping_Model_Rate_Request $request
         * @return Mage_Usa_Model_Shipping_Carrier_Fedex
         */
        public function setRequest(Mage_Shipping_Model_Rate_Request $request)
        {
            $this->_request = $request;
            $r = new Varien_Object();

            // API connection parameters
            $r->setSubscriptionkey($this->getConfigData('subscriptionkey'));
            $r->setTitle($this->getConfigData('title'));
            $r->setEnvironment($this->getConfigData('environment'));
            $r->setFeetypes($this->getConfigData('feetypes'));
            $r->setFeetypesfee($this->getConfigData('feetypesfee'));
            $r->setServicelevels($this->getConfigData('servicelevels'));
            $r->setRoutingtypes($this->getConfigData('routingtypes'));
            $r->setQuoteresultsources($this->getConfigData('quoteresultsources'));
            $r->setMotorclasses($this->getConfigData('motorclasses'));
            $r->setAccessorials($this->getConfigData('accessorials'));
            $r->setRatetypes($this->getConfigData('ratetypes'));
            $r->setJobtypes($this->getConfigData('jobtypes'));
            $r->setTransportmodes($this->getConfigData('transportmodes'));
            $r->setNfms($this->getConfigData('nfms'));

            if ($request->getOrigCity()) {
                $r->setOrigCity($request->getOrigCity());
            } else {
                $r->setOrigCity($this->getConfigData('origincity'));
            }

            if ($request->getOrigState()) {
                $r->setOrigState($request->getOrigState());
            } else {
                $r->setOrigState($this->getConfigData('originstate'));
            }

            if ($request->getOrigCountry()) {
                $origCountry = $request->getOrigCountry();
            } else {
                $origCountry = self::USA_COUNTRY_ID;
            }
            $r->setOrigCountry($origCountry);
            if ($request->getOrigPostcode()) {
                $r->setOrigPostcode($request->getOrigPostcode());
                echo "1111";
            } else {
                $r->setOrigPostcode($this->getConfigData('originzip'));
            }
            if ($request->getDestCountryId()) {
                $destCountry = $request->getDestCountryId();
            } else {
                $destCountry = self::USA_COUNTRY_ID;
            }
            $r->setDestCountry($destCountry);

            if ($request->getDestRegionCode()) {
                $r->setDestRegionCode($request->getDestRegionCode());
            }

            if ($request->getDestPostcode()) {
                $r->setDestPostal($request->getDestPostcode());
            }
            // TODO - deal with weight and packages
            $r->setWeight($request->getPackageWeight());
            $r->setValue($request->getPackagePhysicalValue());
            $r->setValueWithDiscount($request->getPackageValueWithDiscount());
            $r->setIsReturn($request->getIsReturn());
            $r->setBaseSubtotalInclTax($request->getBaseSubtotalInclTax());
            
            $this->_rawRequest = $r;

            return $this;
        }
      
   

        /** 
        * Collect rates for this shipping method based on information in $request 
        * 
        * @param Mage_Shipping_Model_Rate_Request $data 
        * @return Mage_Shipping_Model_Rate_Result 
        */  
        public function collectRates(Mage_Shipping_Model_Rate_Request $request){  

            if (!$this->getConfigFlag($this->_activeFlag)) {
                return false;
            }

            $client = $this->_createSoapClient();
          //  $this->setRequest($request);
          //  $this->_getQuotes();

 
            $result = Mage::getModel('shipping/rate_result');  
            $method = Mage::getModel('shipping/rate_result_method');  
            $method->setCarrier($this->_code);  
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethod($this->_code);  
            $method->setMethodTitle($this->getConfigData('name'));
		    $method->setPrice('20.00');
			$method->setCost('30.00');
            $result->append($method);  
             return $result;  
        }  

    /**
     * Processing additional validation to check if carrier applicable.
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Carrier_Abstract|Mage_Shipping_Model_Rate_Result_Error|boolean
     */
        // public function proccessAdditionalValidation(Mage_Shipping_Model_Rate_Request $request)
        // {
        //     //Skip by item validation if there is no items in request
        //     if(!count($this->getAllItems($request))) {
        //         return $this;
        //     }

        //     $minAllowedWeight   = (float) $this->getConfigData('min_package_weight');
        //     $errorMsg           = '';
        //     $configErrorMsg     = $this->getConfigData('specificerrmsg');
        //     $defaultErrorMsg    = Mage::helper('shipping')->__('The mfshipping  module is not available.');

        //     // check if our overall weight is below threshold for this extension
        //     if ($request->getPackageWeight() < $minAllowedWeight) {
        //         $this->log('Order weight ('.$request->getPackageWeight().' LB) is below Mainfreight threshold ('.$minAllowedWeight.' LB) - no rates will be retrieved', Zend_Log::DEBUG);
        //         $errorMsg = ($configErrorMsg) ? $configErrorMsg : $defaultErrorMsg;
        //     }

        //     if ($errorMsg) {
        //         $error = Mage::getModel('shipping/rate_result_error');
        //         $error->setCarrier($this->_code);
        //         $error->setCarrierTitle($this->getConfigData('title'));
        //         $error->setErrorMessage($errorMsg);
        //         return $error;
        //     } elseif ($errorMsg) {
        //         return false;
        //     }
        //     return $this;
        // }


        protected function _prepareAccessorialIn()
        {
            $r = $this->_request;
            $AccessorialIn[] = array(
                "AccessorialType" => $r->getAccessorials(),
            );
            return $AccessorialIn;
        }
        protected function _prepareFee()
        {
            $r = $this->_request;
            $fee[] = array(
                "FeeType"=>"Insurance",
                "Amount" => 56,
                );
            return $fee;
        }

        protected function _prepareMotorclass($itemLength,$itemWidth,$itemHeight,$itemPackageWeight)
        {
           
        }

        protected function _getRequestID()
        {
            return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

                // 16 bits for "time_mid"
                mt_rand( 0, 0xffff ),

                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand( 0, 0x0fff ) | 0x4000,

                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand( 0, 0x3fff ) | 0x8000,

                // 48 bits for "node"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
            );
        }
        public function _prepareShipmentLine()
        {
       
        $r = $this->_request;
        $shipmentLines = array();


        foreach($r->getAllItems() as $quoteItem){
            
            $item = $quoteItem->getProduct();
            $stockItem = $quoteItem->getProduct()->getStockItem();
            // skip anything that's a virtual item or non-simple
            if ($quoteItem->getIsVirtual() || $quoteItem->getProductType() == 'configurable' || $quoteItem->getProductType() == 'bundle') {
                continue;
            }
            $itemWeight = (float)$item->getWeight();
            
            $itemPackage = $itemPackageWeight = $itemCommodityClass = null;

            $itemWidth = $itemHeight = $itemLength = null;
            if (!$itemLength = $item->getLength()) {
                $itemLength = $item->getAttributeText('length');
            }  
            if (!$itemHeight = $item->getHeight()) {              
                $itemHeight = "111";//$item->getAttributeText('height'); echo "bbbbbbb";
            }
            if (!$itemWidth = $item->getWidth()) {
                $itemWidth = $item->getAttributeText('width');
            }
            $qtyMultiplier = 1;
            if ($parentItem = $quoteItem->getParentItem()) {
                $qtyMultiplier = $parentItem->getQty();
            }

            $itemPackageWeight = $itemWeight * $quoteItem->getQty() * $qtyMultiplier;
            // prepare line item
            $shipmentLines[] = array(
                "Pieces" => 2,
                "Length" => '100',
                "Width" =>  '333',
                "Height" => '122',
                "Weight" => '212',
                "NMFC" => $r->getNfms(),
                "MotorClass" => 'Code50',
                );
            }
            
            return $shipmentLines;
        }

        /**
         * Forming request for rate estimation
         *
         * @return array
         */
        protected function _formRateRequest()
        {
            $r = $this->_rawRequest;

            $shipmentDate = "2015-11-06";//date("Y-m-d");
            $ratesRequest = array(
                'subscriptionKey' => $r->getSubscriptionkey(),
                'shipment' => array(
                    "Accessorials" => $this->_prepareAccessorialIn(),
                    "CustomerCode" => null,
                    "DestinationCity" =>null,
                    "DestinationCode" =>null,
                    "DestinationCountry"=> $r->getDestCountry(),
                    "DestinationSite" =>null,
                    "DestinationState" => $r->getDestRegionCode(),
                    "DestinationZip" => $r->getDestPostal(),

                    "Environment" => $r->getEnvironment(),
                    "Fees" => $this->_prepareFee(),
                    "OriginCity" => $r->getOrigCity(),
                    "OriginCode" =>null, 
                    "OriginCountry" => $r->getOrigCountry(),
                    "OriginSite" =>null,
                    "OriginState" =>  $r->getOrigState(),
                    "OriginZip" =>  '98104',//$r->getOrigPostal(),
                    "RequestID" => $this->_getRequestID(),
                    "RoutingType" => $r->getRoutingtypes(),
                    "ServiceLevel" => $r->getServicelevels(),
                    "ShipmentDate" => $shipmentDate,
                    "ShipmentLines" => $this->_prepareShipmentLine(),
                    "TransportMode" => $r->getTransportmodes(),
                ),
            );

            return $ratesRequest;
        }


        /**
         * Makes remote request to the carrier and returns a response
         *
         * @return mixed
         */
        protected function _doRatesRequest()
        {
            $client = $this->_createSoapClient();
            $ratesRequest = $this->_formRateRequest();
         

            $response = $client->RateShipment($ratesRequest);
            print_r($response);
   die("11111222");
                //$_lastReq = $this->_soapHelper->getLastRequest();
                // $this->log($_lastReq, Zend_Log::DEBUG);
                // $this->_setCachedQuotes($requestString, serialize($response));
                // $debugData['result'] = $response;

                return $response;
        }
        /**
         * Do remote request for and handle errors
         *
         * @return Mage_Shipping_Model_Rate_Result
         */
        protected function _getQuotes()
        {
            $this->_result = Mage::getModel('shipping/rate_result');
            $response = $this->_doRatesRequest();
            $preparedGeneral = $this->_prepareRateResponse($response);
            if (!$preparedGeneral->getError() || ($this->_result->getError() && $preparedGeneral->getError())) {
                 $this->_result->append($preparedGeneral);
            }
            return $this->_result;
        }
		/**
		 * Get allowed shipping methods
		 *
		 * @return array
		 */
		public function getAllowedMethods()
		{
			return array($this->_code=>$this->getConfigData('name'));
		}
    }  
