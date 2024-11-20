<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Version;

defined('_JEXEC') or die('Restricted access');// no direct access



$app 						= Factory::getApplication();
$document 					= Factory::getDocument();
$p 							= array();

$moduleclass_sfx 			= htmlspecialchars((string)$params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8');
$version 			= new Version();
$p['is_j4'] 		= $version->isCompatible('4.0.0-alpha');


$p['type'] 	    			= $params->get( 'type', 'feature_box');
$p['title_color'] 	    	= $params->get( 'title_color', '');
$p['icon_color'] 	    	= $params->get( 'icon_color', '');
$p['display_view'] 			= $params->get( 'display_view', '');
$p['display_option'] 		= $params->get( 'display_option', '');
$p['display_id'] 			= $params->get( 'display_id', '');
$p['description_top'] 		= $params->get( 'description_top', '');
$p['description_bottom'] 	= $params->get( 'description_bottom', '');


// MAIN
$p['main_title'] 			= $params->get( 'main_title', '');
$p['main_icon_class'] 		= $params->get( 'main_icon_class', '');
$p['main_image_svg'] 		= $params->get( 'main_image_svg', '');
$p['main_image'] 			= $params->get( 'main_image', '');
$p['main_video']            = $params->get( 'main_video', '');
$p['main_video_file']            = $params->get( 'main_video_file', '');
$p['main_video_file_thumbnail']            = $params->get( 'main_video_file_thumbnail', '');
$p['main_video_width']            = $params->get( 'main_video_width', '560');
$p['main_video_height']            = $params->get( 'main_video_height', '315');
$p['image_empty_space']     = $params->get( 'image_empty_space', 0);
$p['main_description'] 		= $params->get( 'main_description', '');
$p['main_link'] 			= $params->get( 'main_link', '');
$p['main_link_attributes'] 	= $params->get( 'main_link_attributes', '');
$p['main_button_title'] 	= $params->get( 'main_button_title', '');
$p['main_button_link'] 		= $params->get( 'main_button_link', '');
$p['main_button_attributes'] = $params->get( 'main_button_attributes', '');
$p['main_content'] 			= $params->get( 'main_content', '');
$p['main_background_image'] = $params->get( 'main_background_image', '');
$p['main_background_image_gradient'] = $params->get( 'main_background_image_gradient', '');
$p['main_label']            = $params->get( 'main_label', '');
$p['main_price'] 			= $params->get( 'main_price', '');
$p['main_price_original']   = $params->get( 'main_price_original', '');
$p['phocacart_product_id']   = $params->get( 'phocacart_product_id', 0);

$p['main_top_code'] 		= $params->get( 'main_top_code', '');
$p['main_bottom_code'] 		= $params->get( 'main_bottom_code', '');


$p['image_row_box_size'] 	= $params->get( 'image_row_box_size', '25');
$p['image_feature_box_size']= $params->get( 'image_feature_box_size', 1);
$p['image_content_size'] 	= $params->get( 'image_content_size', 1);


$p['custom_css'] 			= $params->get( 'custom_css', '');


$view 						= $app->input->get('view', '');
$option 					= $app->input->get('option', '');
$idCom						= $app->input->get('id', '');

$optionA 	= array_map('trim', explode(',', $p['display_option']));// Remove spaces
$viewA 		= array_map('trim', explode(',', $p['display_view']));
$idA 		= array_map('trim', explode(',', $p['display_id']));
$optionA	= array_filter($optionA);// Remove empty values from array
$viewA 		= array_filter($viewA);
$idA 		= array_filter($idA);

if (empty($optionA) && empty($viewA) && empty($idA)) {
	// OK - all parameters are not set
} else if (!empty($optionA) && in_array($option, $optionA) && empty($viewA) && empty($idA)) {
	// OK - only option is set and it meets the criteria
} else if (!empty($optionA) && in_array($option, $optionA) && !empty($viewA) && in_array($view, $viewA) && empty($idA)) {
	// OK - option and view is set and it meets the criteria
} else if (!empty($optionA) && in_array($option, $optionA) && !empty($viewA) && in_array($view, $viewA) && !empty($idA) && in_array($idCom, $idA) ) {
	// OK - option and view and ID is set and it meets the criteria
} else {
	return '';
}

// Phoca Cart
if ((int)$p['phocacart_product_id'] > 0) {

    if (ComponentHelper::isEnabled('com_phocacart', true)) {
        JLoader::registerPrefix('Phocacart', JPATH_ADMINISTRATOR . '/components/com_phocacart/libraries/phocacart');
        $v			= PhocacartProduct::getProduct($p['phocacart_product_id']);


        if (isset($v->title) && $v->title != '') {
            $p['main_title'] = $v->title;
        }

        if (isset($v->description_long) && $v->description_long != '') {
            $p['main_content'] = $v->description_long;
        }

        $price 				= new PhocacartPrice;
        if (isset($v->price) && $v->price != '' && $v->price > 0) {
            $p['main_price'] = $price->getPriceFormat($v->price);
        }
        if (isset($v->price_original) && $v->price_original != '' && $v->price_original > 0) {
            $p['main_price_original'] = $price->getPriceFormat($v->price_original);
        }

        if (isset($v->id) && isset($v->catid) && isset($v->alias) && isset($v->catalias)) {
            $link = JRoute::_(PhocacartRoute::getItemRoute($v->id, $v->catid, $v->alias, $v->catalias));
            $p['main_button_link'] = $link;
        }

        if ($p['main_button_title'] == '') {
            $p['main_button_title'] = Text::_('MOD_PHOCAPARTICLES_PHOCACART_BUY_NOW');
        }

        if (isset($v->image) && $v->image != '') {
            $pathItem 	= PhocacartPath::getPath('productimage');
            $image      = PhocacartImage::getImageDisplay($v->image, array(), $pathItem, 0, 0, 0, 'large', '', array());
            if (isset($image['image']->rel) && $image['image']->rel != '') {
                $p['main_image'] = $image['image']->rel;
            }
        }
        if (isset($v->id)) {
            $labels     = PhocacartTag::getTagLabels($v->id);

            if (isset($labels[0]->title) && $labels[0]->title) {
                $p['main_label'] = $labels[0]->title;
            }
        }
    }
}

// Random ID changes each reload, add something more constant, use the same way like Joomla core modules
if (isset($module->id) && $module->id > 0) {
    $moduleId = $module->id;
} else {
    $moduleId = rand ( 10000 , 99999 );
}

$id = 'ph-mod-phoca-particles-'.$moduleId;
$idClass = 'phModParticle'.$moduleId;
$idJs = 'pS'.$moduleId;

$classA = [];
$classA[] = 'phModParticles';
$classA[] = $idClass;
$classA[] = $moduleclass_sfx;
$class    = trim(implode(' ', $classA));

// Main Background Image
$styleType = str_replace('_', ' ', $p['type']);
$styleType = ucwords($styleType);
$styleType = str_replace(' ', '', $styleType);
//$styleType = '.phModParticles'.htmlspecialchars($styleType);
$styleType = '.'.$idClass.' .phModParticles'.htmlspecialchars($styleType);


// Background Image
$image = $p['main_background_image'];
if ($image != '') {
    $style[] = $styleType.' {';
    if ($p['is_j4']) {
        $imgClean = HTMLHelper::cleanImageURL($image);
        if ($imgClean->url != '') {
           $image =  $imgClean->url;
        }
    }

    $gradient = '';
    if ($p['main_background_image_gradient'] != '') {
        $gradient = $p['main_background_image_gradient'] . ', ';
    }

    $style[] = 'background-image: '.$gradient.'url('.URI::base(true) . '/'.$image.');';
    $style[] = 'background-repeat: no-repeat;';
	$style[] = 'background-size: cover;';
    $style[] = '}';
}


if (!empty($style)) {
     $document->addStyledeclaration(implode("\n",  $style));
}

$i = 0;
$items = array();
$itemsA = (array)$params->get('items');
if (!empty($itemsA)) {
    foreach($itemsA as $k => $v) {
        $items[$i] = $v;
        $i++;
    }
}

//JHTML::stylesheet( 'media/mod_phocaparticles/css/style.css' );
$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('mod_phocaparticles', 'media/mod_phocaparticles/css/style.css', array('version' => 'auto'));

if ($p['custom_css'] != '') {
    $p['custom_css'] = str_replace('{moduleclass}', '.'.$idClass, $p['custom_css']);
	$document->addStyledeclaration($p['custom_css']);
}

require(ModuleHelper::getLayoutPath('mod_phocaparticles', $p['type'] ));
?>
