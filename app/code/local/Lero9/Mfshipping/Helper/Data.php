<?php
class Lero9_Mfshipping_Helper_Data extends Mage_Core_Helper_Abstract
{

	   protected $client = null;

	   public function connect($wsdl) {
	        if ($this->client != null) {
	            return;
	        }
	        $this->client = new SoapClient($wsdl, array('trace' => "false",'keep_alive'=>true,'exceptions'=>true,'connection_timeout'=>30,'cache_wsdl'=>WSDL_CACHE_BOTH,));
       }
      /**
     * Executes the OrderImport Soap call on our Soap client
     * 
     * @param OrderImport $data
     * @return type
     * @throws Exception
     */
    public function GetRates(GetLTLRating $data) {
        if ($this->client == null) {
            throw new Exception('Api not yet connected');
        }
        return $this->client->GetLTLRating($data);
    }
    
    /**
     * Dump the last request data
     */
    public function dumpLastRequest(){
        $this->client->dumpLastRequest();
    }

}
	 