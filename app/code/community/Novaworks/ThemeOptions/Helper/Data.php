<?php

class Novaworks_ThemeOptions_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function get_menu_config($optionString)
    {
        return Mage::getStoreConfig('themeoptions_general/menu/' . $optionString);
    }
    public function get_newsletter_popup() {
		$newsletter_status	= Mage::getStoreConfig('themeoptions_general/newsletter/newsletter_status');
		if ($newsletter_status == 1) {
			return 'newsletter/popup_subscribe.phtml';
		}
	}
	public function get_jquery_cookie() {
		$newsletter_status	= Mage::getStoreConfig('themeoptions_general/newsletter/newsletter_status');
		if ($newsletter_status == 1){
			return 'js/jquery.cookie.js';
		}
	}
	public function get_fancy_css(){
			$newsletter_status	= Mage::getStoreConfig('themeoptions_general/newsletter/newsletter_status');
			if ($newsletter_status) {
				return 'css/fancybox.css';
			}
	}
	public function get_fancy_js(){
			$newsletter_status	= Mage::getStoreConfig('themeoptions_general/newsletter/newsletter_status');
			if ($newsletter_status) {
				return 'js/jquery.fancybox.pack.js';
			}
	}
}