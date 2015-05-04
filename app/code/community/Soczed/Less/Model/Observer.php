<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Soczed
 * @package    Soczed_Less
 * @copyright  Copyright (c) 2012 Soczed <magento@soczed.com> (Benoît Leulliette <benoit@soczed.com>)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

set_include_path(get_include_path().PS.Mage::getBaseDir('lib').DS.'Soczed'.DS.'less');
require_once('lessc.inc.php');

class Soczed_Less_Model_Observer
{
    protected function _getHelper()
    {
        return Mage::helper('less');
    }
    
    protected function _getConfigHelper()
    {
        return Mage::helper('less/config');
    }
    
    protected function _checkWritableFile($file)
    {
        $pathinfo = pathinfo($file);
        
        if (empty($pathinfo['dirname']) || !is_writable($pathinfo['dirname'])) {
            return $this->_getHelper()->__('Directory is not writable');
        }
        if (is_file($file) && !is_writable($file)) {
            return $this->_getHelper()->__('File is not writable');
        }
        
        return true;
    }
    
    protected function _getLessVariables($file)
    {
        // Base variables
        // @todo complete this array with any variable that could be useful
        $variables = array();
        
        // Get additional variables
        $response = new Varien_Object(array('less_variables' => array()));
        
        Mage::dispatchEvent(
            'soczed_less_additional_variables',
            array(
                'response'  => $response,
                'file_name' => $file,
            )
        );
        
        if (is_array($additional = $response->getLessVariables())) {
            $variables = array_merge($variables, $additional);
        }
        
        return $variables;
    }
    
    protected function _getLessFunctions($file)
    {
        // Base functions
        // @todo complete this array with any function that could be useful
        $functions = array();
        
        // Get additional functions
        $response = new Varien_Object(array('less_functions' => array()));
        
        Mage::dispatchEvent(
            'soczed_less_additional_functions',
            array(
                'response'  => $response,
                'file_name' => $file,
            )
        );
        
        if (is_array($additional = $response->getLessFunctions())) {
            $functions = array_merge($functions, $additional);
        }
        
        return $functions;
    }
    
    
    public function beforeLayoutRender($observer)
    {
    	$storeId = Mage::app()->getStore()->getStoreId();
        if (!$this->_getConfigHelper()->isEnabled()) {
            return;
        }
        
        $layout = Mage::getSingleton('core/layout');
        
        if (($head = $layout->getBlock('head'))
            && ($head instanceof Mage_Page_Block_Html_Head)) {
            $baseJsDir     = Mage::getBaseDir() . DS . 'js' . DS;
            $designPackage = Mage::getDesign();
            $newItems      = $head->getData('items');

            $body_font  = Mage::getStoreConfig('themeoptions_theming/theme_fonts/body_font', $storeId);
            $body_font_size  = Mage::getStoreConfig('themeoptions_theming/theme_fonts/body_font_size', $storeId);

            $heading_and_product_font  = Mage::getStoreConfig('themeoptions_theming/theme_fonts/heading_font', $storeId);
            $globalVars    = 
            array(
            "body_font" => $body_font,
            "body_font_size" => $body_font_size,

            "heading_and_product_font"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/heading_and_product_font', $storeId),
            "heading_and_product_weight"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/heading_and_product_weight', $storeId),
            "heading_and_product_uppercase"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/heading_and_product_uppercase', $storeId),
            "sub_heading_font"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/sub_heading_font', $storeId),

            "price_font"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/price_font', $storeId),

            "button_font"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/button_font', $storeId),
            "button_font_weight"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/button_font_weight', $storeId),
            "button_font_uppercase"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/button_font_uppercase', $storeId),

            "search_font"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/search_font', $storeId),
            "search_font_weight"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/search_font_weight', $storeId),
            "search_font_size"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/search_font_size', $storeId),
            "search_font_uppercase"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/search_font_uppercase', $storeId),

            "cart_font"            => Mage::getStoreConfig('themeoptions_theming/theme_fonts/cart_font', $storeId),
            "cart_font_weight"     => Mage::getStoreConfig('themeoptions_theming/theme_fonts/cart_font_weight', $storeId),
            "cart_font_size"       => Mage::getStoreConfig('themeoptions_theming/theme_fonts/cart_font_size', $storeId),
            "cart_font_uppercase"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/cart_font_uppercase', $storeId),

            "main_menu_font"       => Mage::getStoreConfig('themeoptions_theming/theme_fonts/main_menu_font', $storeId),
            "main_menu_weight"     => Mage::getStoreConfig('themeoptions_theming/theme_fonts/main_menu_weight', $storeId),
            "main_menu_size"       => Mage::getStoreConfig('themeoptions_theming/theme_fonts/main_menu_size', $storeId),
            "main_menu_uppercase"  => Mage::getStoreConfig('themeoptions_theming/theme_fonts/main_menu_uppercase', $storeId),

            "body_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/body_background_color', $storeId),
            "body_text_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/body_text_color', $storeId),
            "heading_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/heading_color', $storeId),
            "light_text_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/light_text_color', $storeId),
            "other_link_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/other_link_color', $storeId),
            "links_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/links_color_hover', $storeId),
            "selection_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/selection_color', $storeId),
            "selection_bg_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/selection_bg_color', $storeId),

            "main_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/main_background_color', $storeId),

            "main_border_size"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/main_border_size', $storeId),
            "main_border_style"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/main_border_style', $storeId),
            "main_border_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/main_border_color', $storeId),

            "content_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/content_background_color', $storeId),

            "headings_border_size"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/headings_border_size', $storeId),
            "headings_border_style"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/headings_border_style', $storeId),
            "headings_border_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/headings_border_color', $storeId),

            "sorter_border_size"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/sorter_border_size', $storeId),
            "sorter_border_style"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/sorter_border_style', $storeId),
            "sorter_border_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/sorter_border_color', $storeId),

            "left_column_heading_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/left_column_heading_background_color', $storeId),

            "left_column_heading_title_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/left_column_heading_title_color', $storeId),

            "left_column_heading_border_bottom_size"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/left_column_heading_border_bottom_size', $storeId),
            "left_column_heading_border_bottom_style"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/left_column_heading_border_bottom_style', $storeId),
            "left_column_heading_border_bottom_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/left_column_heading_border_bottom_color', $storeId),

            "left_column_box_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/left_column_box_background_color', $storeId),
            "left_column_link_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/left_column_link_color', $storeId),
            "left_column_link_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/left_column_link_color_hover', $storeId),

            "right_column_heading_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/right_column_heading_background_color', $storeId),

            "right_column_heading_title_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/right_column_heading_title_color', $storeId),

            "right_column_heading_border_bottom_size"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/right_column_heading_border_bottom_size', $storeId),
            "right_column_heading_border_bottom_style"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/right_column_heading_border_bottom_style', $storeId),
            "right_column_heading_border_bottom_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/right_column_heading_border_bottom_color', $storeId),

            "right_column_box_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/right_column_box_background_color', $storeId),
            "right_column_link_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/right_column_link_color', $storeId),
            "right_column_link_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/right_column_link_color_hover', $storeId),

            "category_box_heading_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/category_box_heading_background_color', $storeId),

            "category_box_heading_title_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/category_box_heading_title_color', $storeId),

            "category_box_heading_border_bottom_size"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/category_box_heading_border_bottom_size', $storeId),
            "category_box_heading_border_bottom_style"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/category_box_heading_border_bottom_style', $storeId),
            "category_box_heading_border_bottom_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/category_box_heading_border_bottom_color', $storeId),

            "category_box_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/category_box_background_color', $storeId),
            "category_box_background_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/category_box_background_color_hover', $storeId),
            "category_box_link_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/category_box_link_color', $storeId),
            "category_box_link_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/category_box_link_color_hover', $storeId),

            "category_box_separator_size"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/category_box_separator_size', $storeId),
            "category_box_separator_style"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/category_box_separator_style', $storeId),
            "category_box_separator_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/category_box_separator_color', $storeId),

            "filter_box_heading_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/filter_box_heading_background_color', $storeId),

            "filter_box_heading_title_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/filter_box_heading_title_color', $storeId),

            "filter_box_heading_border_bottom_size"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/filter_box_heading_border_bottom_size', $storeId),
            "filter_box_heading_border_bottom_style"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/filter_box_heading_border_bottom_style', $storeId),
            "filter_box_heading_border_bottom_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/filter_box_heading_border_bottom_color', $storeId),

            "filter_box_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/filter_box_background_color', $storeId),
            "filter_box_link_color"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/filter_box_link_color', $storeId),
            "filter_box_link_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/general_styles/filter_box_link_color_hover', $storeId),

            "header_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_background_color', $storeId),
            "header_fixed_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_fixed_background_color', $storeId),

            "header_top_bar_backbround_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_top_bar_backbround_color', $storeId),

            "header_top_bar_border_top_size"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_top_bar_border_top_size', $storeId),
            "header_top_bar_border_top_style"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_top_bar_border_top_style', $storeId),
            "header_top_bar_border_top_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_top_bar_border_top_color', $storeId),

            "header_top_bar_text_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_top_bar_text_color', $storeId),

            "header_top_bar_link_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_top_bar_link_color', $storeId),
            "header_top_bar_link_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_top_bar_link_color_hover', $storeId),

            "header_top_bar_separator_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_top_bar_separator_color', $storeId),

            "header_top_bar_dropdowns_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_top_bar_dropdowns_background_color', $storeId),
            "header_top_bar_dropdowns_background_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_top_bar_dropdowns_background_color_hover', $storeId),

            "header_top_bar_dropdowns_link_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_top_bar_dropdowns_link_color', $storeId),
            "header_top_bar_dropdowns_link_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_top_bar_dropdowns_link_color_hover', $storeId),

            "header_search_bar_backbround_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_search_bar_backbround_color', $storeId),
            "header_search_bar_border_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_search_bar_border_color', $storeId),
            "header_search_bar_border_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_search_bar_border_color_hover', $storeId),
            "header_search_bar_text_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_search_bar_text_color', $storeId),

            "header_cart_conten_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_cart_conten_background_color', $storeId),
            "header_cart_conten_text_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_cart_conten_text_color', $storeId),
            "header_cart_conten_text_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_cart_conten_text_color_hover', $storeId),

            "header_cart_section_text_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_cart_section_text_color', $storeId),
            "header_cart_section_active_color"  => Mage::getStoreConfig('themeoptions_colors_styles/header_style/header_cart_section_active_color', $storeId),

            "main_menu_bar_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/main_menu_bar_background_color', $storeId),

            "main_menu_bar_separator_size"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/main_menu_bar_separator_size', $storeId),
            "main_menu_bar_separator_style"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/main_menu_bar_separator_style', $storeId),
            "main_menu_bar_separator_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/main_menu_bar_separator_color', $storeId),

            "main_menu_bar_border_top_size"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/main_menu_bar_border_top_size', $storeId),
            "main_menu_bar_border_top_style"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/main_menu_bar_border_top_style', $storeId),
            "main_menu_bar_border_top_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/main_menu_bar_border_top_color', $storeId),

            "main_menu_bar_border_bottom_size"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/main_menu_bar_border_bottom_size', $storeId),
            "main_menu_bar_border_bottom_style"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/main_menu_bar_border_bottom_style', $storeId),
            "main_menu_bar_border_bottom_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/main_menu_bar_border_bottom_color', $storeId),

            "home_page_link_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/home_page_link_background_color', $storeId),
            "home_page_link_background_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/home_page_link_background_color_hover', $storeId),
            "home_page_link_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/home_page_link_color', $storeId),
            "home_page_link_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/home_page_link_color_hover', $storeId),

            "categories_section_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/categories_section_background_color', $storeId),
            "categories_section_background_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/categories_section_background_color_hover', $storeId),
            "categories_section_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/categories_section_color', $storeId),
            "categories_section_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/categories_section_color_hover', $storeId),

            "block_menu_link_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/block_menu_link_background_color', $storeId),
            "block_menu_link_background_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/block_menu_link_background_color_hover', $storeId),
            "block_menu_link_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/block_menu_link_color', $storeId),
            "block_menu_link_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/block_menu_link_color_hover', $storeId),

            "sub_menu_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/sub_menu_background_color', $storeId),
            "sub_menu_background_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/sub_menu_background_color_hover', $storeId),
            "sub_menu_heading_background_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/sub_menu_heading_background_color', $storeId),
            "sub_menu_heading_text_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/sub_menu_heading_text_color', $storeId),
            "sub_menu_text_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/sub_menu_text_color', $storeId),
            
            "sub_menu_link_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/sub_menu_link_color', $storeId),
            "sub_menu_link_color_hover"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/sub_menu_link_color_hover', $storeId),

            "sub_menu_separator_size"   => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/sub_menu_separator_size', $storeId),
            "sub_menu_separator_style"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/sub_menu_separator_style', $storeId),
            "sub_menu_separator_color"  => Mage::getStoreConfig('themeoptions_colors_styles/main_menu_style/sub_menu_separator_color', $storeId),

            "price_color"       => Mage::getStoreConfig('themeoptions_colors_styles/price_style/price_color', $storeId),
            "old_price_color"   => Mage::getStoreConfig('themeoptions_colors_styles/price_style/old_price_color', $storeId),
            "new_price_color"   => Mage::getStoreConfig('themeoptions_colors_styles/price_style/new_price_color', $storeId),
            "tex_price_color"   => Mage::getStoreConfig('themeoptions_colors_styles/price_style/tex_price_color', $storeId),

            "button_border_radius"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/button_border_radius', $storeId),

            "buttons_background_1"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_background_1', $storeId),
            "buttons_background_hover_1"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_background_hover_1', $storeId),
            "buttons_text_color_1"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_text_color_1', $storeId),
            "buttons_text_color_hover_1"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_text_color_hover_1', $storeId),

            "buttons_background_2"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_background_2', $storeId),
            "buttons_background_hover_2"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_background_hover_2', $storeId),
            "buttons_text_color_2"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_text_color_2', $storeId),
            "buttons_text_color_hover_2"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_text_color_hover_2', $storeId),

            "buttons_background_3"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_background_3', $storeId),
            "buttons_background_hover_3"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_background_hover_3', $storeId),
            "buttons_text_color_3"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_text_color_3', $storeId),
            "buttons_text_color_hover_3"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_text_color_hover_3', $storeId),

            "buttons_background_4"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_background_4', $storeId),
            "buttons_background_hover_4"   => Mage::getStoreConfig('themeoptions_colors_styles/buttons_style/buttons_background_hover_4', $storeId),

            "product_box_background_color_hover"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/product_box_background_color_hover', $storeId),

            "product_box_new_background"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/product_box_new_background', $storeId),
            "product_box_new_text"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/product_box_new_text', $storeId),
            "product_box_sale_background"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/product_box_sale_background', $storeId),
            "product_box_sale_text"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/product_box_sale_text', $storeId),

            "menu_box_new_background"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/menu_box_new_background', $storeId),
            "menu_box_new_text"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/menu_box_new_text', $storeId),
            "menu_box_hot_background"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/menu_box_hot_background', $storeId),
            "menu_box_hot_text"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/menu_box_hot_text', $storeId),

            "product_page_tabs_background"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/product_page_tabs_background', $storeId),
            "product_page_tabs_selected"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/product_page_tabs_selected', $storeId),
            "product_page_tabs_text"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/product_page_tabs_text', $storeId),
            "product_page_tabs_text_hover"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/product_page_tabs_text_hover', $storeId),

            "slider_home_page_tparrows"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/slider_home_page_tparrows', $storeId),
            "slider_home_page_tparrows_hover"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/slider_home_page_tparrows_hover', $storeId),
            "slider_home_page_tparrows_active"   => Mage::getStoreConfig('themeoptions_colors_styles/midsection_style/slider_home_page_tparrows_active', $storeId),

            "footer_a_block_background"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_a_block_background', $storeId),
            "footer_a_block_titles_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_a_block_titles_color', $storeId),
            "footer_a_block_titles_color_hover"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_a_block_titles_color_hover', $storeId),
            "footer_a_block_subtitles_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_a_block_subtitles_color', $storeId),

            "feature_box_1_icon_background_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/feature_box_1_icon_background_color', $storeId),
            "feature_box_1_icon_background_color_hover"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/feature_box_1_icon_background_color_hover', $storeId),

            "feature_box_2_icon_background_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/feature_box_2_icon_background_color', $storeId),
            "feature_box_2_icon_background_color_hover"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/feature_box_2_icon_background_color_hover', $storeId),

            "feature_box_3_icon_background_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/feature_box_3_icon_background_color', $storeId),
            "feature_box_3_icon_background_color_hover"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/feature_box_3_icon_background_color_hover', $storeId),

            "feature_box_4_icon_background_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/feature_box_4_icon_background_color', $storeId),
            "feature_box_4_icon_background_color_hover"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/feature_box_4_icon_background_color_hover', $storeId),

            "footer_b_block_background"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_b_block_background', $storeId),
            "footer_b_block_titles"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_b_block_titles', $storeId),

            "footer_b_block_border_bottom_size"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_b_block_border_bottom_size', $storeId),
            "footer_b_block_border_bottom_style"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_b_block_border_bottom_style', $storeId),
            "footer_b_block_border_bottom_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_b_block_border_bottom_color', $storeId),

            "footer_b_block_text_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_b_block_text_color', $storeId),
            "footer_b_block_link_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_b_block_link_color', $storeId),
            "footer_b_block_link_color_hover"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_b_block_link_color_hover', $storeId),
            "footer_b_block_background_icon_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_b_block_background_icon_color', $storeId),

            "footer_b_block_border_top_size"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_b_block_border_top_size', $storeId),
            "footer_b_block_border_top_style"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_b_block_border_top_style', $storeId),
            "footer_b_block_border_top_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_b_block_border_top_color', $storeId),

            "footer_c_block_background"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_c_block_background', $storeId),
            "footer_c_block_titles"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_c_block_titles', $storeId),

            "footer_c_border_bottom_size"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_c_border_bottom_size', $storeId),
            "footer_c_border_bottom_style"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_c_border_bottom_style', $storeId),
            "footer_c_border_bottom_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_c_border_bottom_color', $storeId),

            "footer_c_block_link_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_c_block_link_color', $storeId),
            "footer_c_block_link_color_hover"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_c_block_link_color_hover', $storeId),

            "footer_c_block_border_top_size"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_c_block_border_top_size', $storeId),
            "footer_c_block_border_top_style"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_c_block_border_top_style', $storeId),
            "footer_c_block_border_top_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_c_block_border_top_color', $storeId),

            "footer_d_payment_background"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_d_payment_background', $storeId),

            "footer_d_payment_text_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_d_payment_text_color', $storeId),
            "footer_d_payment_link_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_d_payment_link_color', $storeId),
            "footer_d_payment_link_color_hover"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_d_payment_link_color_hover', $storeId),

            "footer_d_border_top_size"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_d_border_top_size', $storeId),
            "footer_d_border_top_style"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_d_border_top_style', $storeId),
            "footer_d_border_top_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_d_border_top_color', $storeId),

            "footer_e_block_background"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_e_block_background', $storeId),

            "footer_e_block_text_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_e_block_text_color', $storeId),
            "footer_e_block_link_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_e_block_link_color', $storeId),
            "footer_e_block_link_color_hover"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_e_block_link_color_hover', $storeId),

            "footer_e_border_top_size"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_e_border_top_size', $storeId),
            "footer_e_border_top_style"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_e_border_top_style', $storeId),
            "footer_e_border_top_color"   => Mage::getStoreConfig('themeoptions_colors_styles/footer_color_style/footer_e_border_top_color', $storeId),


            );
/*
            echo "<pre>";
            print_r($globalVars);
            echo "<pre>";
            die();
*/
            // Cache by file path
            $filesCollection = Mage::getModel('less/file')
                ->getCollection()
                ->addFilter('store_id',$storeId)
                ->load();

            $filesIds = array_flip($filesCollection->toOptionHash());
            foreach ($newItems as $key => $item) {
                if (in_array($item['type'], array('js_css', 'skin_css'))) {
                    // CSS file
                    if (substr($item['name'], -5) == '.less') {
                        // LESS file
                        if ($item['type'] == 'js_css') {
                            $lessFile = $baseJsDir . $item['name'];
                        } else {
                            $lessFile = $designPackage->getFilename($item['name'], array('_type' => 'skin'));
                        }
                        $baseFile = ltrim(str_replace(Mage::getBaseDir(), '', $lessFile), DS);
                        $cssFile  = substr($lessFile, 0, -11) . 'custom_designs/custom_css_store_id_'.$storeId.'.css';             
                        try {
                            // Init file config
                            if (isset($filesIds[$baseFile])) {
                                $isNewModel      = false;
                                $model           = $filesCollection->getItemById($filesIds[$baseFile]);
                                $oldCache        = false;//$model->getCache();
                                $forceRebuild    = (bool)$model->getForceRebuild();
                                $customVars      = $model->getCustomVariables();
                                $useGlobalVars   = (bool)$model->getUseGlobalVariables();
                                $forceGlobalVars = (bool)$model->getForceGlobalVariables();
                            } else {
                                $isNewModel      = true;
                                $model           = null;
                                $oldCache        = null;
                                $forceRebuild    = false;
                                $customVars      = array();
                                $useGlobalVars   = true;
                                $forceGlobalVars = false;
                            }
                            
                            // Get all needed variables for current file
                            if (is_array($customVars)) {
                                $oldVars    = $customVars;
                                $customVars = array();
                                
                                foreach ($oldVars as $oldVar) {
                                    $customVars[$oldVar['code']] = $oldVar['value'];
                                }
                            } else {
                                $customVars = array();
                            }
                            if ($useGlobalVars) {
                                $variables  = array_merge(
                                    ($forceGlobalVars  ? $customVars : $globalVars),
                                    ($forceGlobalVars ? $globalVars : $customVars)
                                );
                            } else {
                                $variables = $customVars;
                            }
                            $variables = array_merge($variables, $this->_getLessVariables($item['name']));
                            
                            // Compile if needed (depends on cache and rebuild flag)
                            $oldCache = (is_array($oldCache) ? $oldCache : $lessFile);
                            
                            try {
                                $newCache = lessc::cexecute(
                                    $oldCache,
                                    $forceRebuild,
                                    $variables,
                                    $this->_getLessFunctions($item['name'])
                                );
                            } catch (Exception $e) {
                                if ($this->_getConfigHelper()->getShowErrors()) {
                                    if (!is_string($result = $this->_checkWritableFile($cssFile))) {
                                        file_put_contents($cssFile, "\n/* ".$e->getMessage()." */\n", FILE_APPEND);
                                    }
                                }
                                throw $e;
                            }
                            if (!is_array($oldCache) || ($newCache['updated'] > $oldCache['updated'])) {
                                if (!is_string($result = $this->_checkWritableFile($cssFile))) {
                                    file_put_contents($cssFile, $newCache['compiled']);
                                } else {
                                    Mage::throwException($result);
                                }
                                if ($isNewModel) {
                                    $model = Mage::getModel('less/file')->setPath($baseFile);
                                }
                                // Won't be further needed and takes most of the place
                                unset($newCache['compiled']); 
                                $model->setCache($newCache)->save();
                            }
                        } catch (Exception $e) {
                            Mage::logException($e);
                        }
                        
                        // Force adding the CSS file instead of Less one
                        $newItems[$key]['name'] = substr($item['name'], 0, -11) . 'custom_designs/custom_css_store_id_'.$storeId.'.css';  
                    }
                }
            }
            
            // Replace old items with parsed ones
            $head->setData('items', $newItems);
        }
    }
}
