<?php
function google_fonts() {
$storeId = Mage::app()->getStore()->getStoreId();
$nova_bazien_customfont = '';
$default = array(
					'Din Text Pro Regular',
					'arial',
					'verdana',
					'trebuchet',
					'georgia',
					'times',
					'tahoma',
					'helvetica'
				);
$novaworks_fonts = array(
					Mage::getStoreConfig('themeoptions_theming/theme_fonts/body_font', $storeId),
					Mage::getStoreConfig('themeoptions_theming/theme_fonts/heading_and_product_font', $storeId),
					Mage::getStoreConfig('themeoptions_theming/theme_fonts/sub_heading_font', $storeId),
					Mage::getStoreConfig('themeoptions_theming/theme_fonts/price_font', $storeId),
					Mage::getStoreConfig('themeoptions_theming/theme_fonts/button_font', $storeId),
					Mage::getStoreConfig('themeoptions_theming/theme_fonts/search_font', $storeId),
					Mage::getStoreConfig('themeoptions_theming/theme_fonts/cart_font', $storeId),
					Mage::getStoreConfig('themeoptions_theming/theme_fonts/main_menu_font', $storeId)
					
				);			
foreach($novaworks_fonts as $novaworks_font) {
	
	if(!in_array($novaworks_font, $default)) {

			$nova_bazien_customfont = str_replace(' ', '+', $novaworks_font). ':400,300,100,100italic,300italic,400italic,700,900,900italic,700italic|' . $nova_bazien_customfont;
	}
}
	if($nova_bazien_customfont){	
	 echo '<link rel="stylesheet"  href="http://fonts.googleapis.com/css?family=' . 		substr_replace($nova_bazien_customfont ,"",-1) . '" type="text/css" media="screen" />';
	}
}
?>