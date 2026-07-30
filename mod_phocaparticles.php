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
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

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
$p['secondary_content'] 			= $params->get( 'secondary_content', '');
$p['main_background_image'] = $params->get( 'main_background_image', '');
$p['main_background_video'] = $params->get( 'main_background_video', '');
$p['main_background_image_gradient'] = $params->get( 'main_background_image_gradient', '');
$p['main_background_image_brightness'] = $params->get( 'main_background_image_brightness', '');

$p['main_label']            = $params->get( 'main_label', '');
$p['main_price'] 			= $params->get( 'main_price', '');
$p['main_price_original']   = $params->get( 'main_price_original', '');
$p['phocacart_product_id']   = $params->get( 'phocacart_product_id', 0);

$p['main_top_code'] 		= $params->get( 'main_top_code', '');
$p['main_bottom_code'] 		= $params->get( 'main_bottom_code', '');


$p['image_row_box_size'] 	= $params->get( 'image_row_box_size', '25');
$p['image_feature_box_size']= $params->get( 'image_feature_box_size', 1);
$p['image_content_size'] 	= $params->get( 'image_content_size', 1);
$p['content_feature_box_size']= $params->get( 'content_feature_box_size', 1);
$p['content_feature_accordion_size']= $params->get( 'content_feature_accordion_size', 2);
$p['image_feature_accordion_size']= $params->get( 'image_feature_accordion_size', 2);
$p['grid_box_type']              = $params->get( 'grid_box_type', 'phGridBoxRow');

$p['custom_css'] 			= $params->get( 'custom_css', '');
$p['button_css'] 			= htmlspecialchars($params->get( 'button_css', 'btn btn-primary'));

$p['enable_animation']      = $params->get( 'enable_animation', 0);

// Animation
$p['main_title_animation']              = $params->get( 'main_title_animation', '');
$p['main_description_animation']        = $params->get( 'main_description_animation', '');
$p['main_content_animation']            = $params->get( 'main_content_animation', '');
$p['main_image_animation']              = $params->get( 'main_image_animation', '');
$p['main_background_image_animation']   = $params->get( 'main_background_image_animation', '');
$p['item_title_animation']              = $params->get( 'item_title_animation', '');
$p['item_description_animation']        = $params->get( 'item_description_animation', '');
$p['item_content_animation']            = $params->get( 'item_content_animation', '');
$p['item_image_animation']              = $params->get( 'item_image_animation', '');
$p['module_id']              = $params->get( 'module_id', '');

$view 						= $app->getInput()->get('view', '');
$option 					= $app->getInput()->get('option', '');
$idCom						= $app->getInput()->get('id', '');

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
if ($p['module_id'] != '') {
    $id = htmlspecialchars($p['module_id']);
}
$idClass = 'phModParticle'.$moduleId;
$idJs = 'pS'.$moduleId;

// Main Background Image
$styleType = str_replace('_', ' ', $p['type']);
$styleType = ucwords($styleType);
$styleType = $styleTypeClass = str_replace(' ', '', $styleType);
//$styleType = '.phModParticles'.htmlspecialchars($styleType);
$styleType = '.'.$idClass.' .phModParticles'.htmlspecialchars($styleType);

$classA = [];
$classA[] = 'phModParticles';
$classA[] = 'phModParticles'. htmlspecialchars($styleTypeClass) . 'Container';
$classA[] = $idClass;
$classA[] = $moduleclass_sfx;

// Background Image - if background image and brightness applied add the class to change font color
$image = $p['main_background_image'];
$video = $p['main_background_video'];

if ($video != '') {
    $classA[] = 'phFontColorLightAuto';
} else if ($image != '') {
    if ($p['main_background_image_brightness'] > 0 && $p['main_background_image_brightness'] < 0.7) {
        $classA[] = 'phFontColorLightAuto';
    } else if ($p['main_background_image_brightness'] > 1.5) {
        $classA[] = 'phFontColorDarkAuto';
    }
}

// Complete Class
$class    = trim(implode(' ', $classA));

// Continue with building background video or image features
if ($video != '') {

    $style[] = $styleType . '{ position: relative; overflow: hidden; isolation: isolate; z-index: 1;} ';

    $style[] =$styleType.' .phModParticlesBackgroundVideo {';

    $style[] = 'position: absolute; top: 50%; left: 50%; width: 100%; height: 100%; z-index: -1;transform: translate(-50%, -50%);object-fit: cover;';

    if (!empty($p['main_background_image_brightness']) && $p['main_background_image_brightness'] !== '0') {
       $style[] = 'filter: brightness('.(float)$p['main_background_image_brightness'].');';
    }

    $style[] = '}';

} else if ($image != '') {

    $style[] = $styleType . '{ position: relative; overflow: hidden; z-index: 1;} ';

    $style[] =$styleType.'::before {';
    if ($p['is_j4']) {
        $imgClean = HTMLHelper::cleanImageURL($image);
        if ($imgClean->url != '') {
           $image =  $imgClean->url;
        }
    }

    $gradient = '';
    if ($p['main_background_image_gradient'] != '') {
        // SECURITY: this value is injected directly into a raw <style>
        // declaration. Strip characters that could close the current
        // rule/selector, while still allowing normal gradient syntax
        // such as linear-gradient(0deg, #fff 0%, #000 100%).
        $gradientSafe = str_replace(['{', '}', '<', '>', ';', '\\'], '', $p['main_background_image_gradient']);
        $gradient = $gradientSafe . ', ';
    }

    // SECURITY: the image path also ends up inside the same raw <style>
    // declaration, inside url(...). Restrict it to characters valid in a
    // relative URL path so a manually-typed value (bypassing the media
    // picker) cannot be used to break out of the CSS declaration.
    $imageSafe = preg_replace('/[^A-Za-z0-9\/_\.\-~%]/', '', $image);

    $style[] = 'content: "";position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;';
    $style[] = 'background-image: '.$gradient."url('".URI::base(true) . '/'.$imageSafe."');";
    $style[] = 'background-repeat: no-repeat;';
	$style[] = 'background-size: cover;';
    $style[] = 'background-position: center;';

    if (!empty($p['main_background_image_brightness']) && $p['main_background_image_brightness'] !== '0') {
       $style[] = 'filter: brightness('.(float)$p['main_background_image_brightness'].');';
    }

    if ($p['main_background_image_animation'] == 'phAnimKenBurnsBg' ) {
       $style[] = 'animation: KenBurnsImg 12s ease-in-out forwards;';
    }

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

// Common CSS (always loaded)
$wa->registerAndUseStyle('mod_phocaparticles.common', 'media/mod_phocaparticles/css/common.css', array('version' => 'auto'));
$wa->registerAndUseStyle('mod_phocaparticles.background', 'media/mod_phocaparticles/css/background.css', array('version' => 'auto'));

// Type-specific CSS
$typeCssMap = [
    'image_feature_accordion' => 'accordion',
    'content_feature_accordion' => 'accordion',
];
$typeCssName = $typeCssMap[$p['type']] ?? $p['type'];
$wa->registerAndUseStyle('mod_phocaparticles.type.' . $typeCssName, 'media/mod_phocaparticles/css/type_' . $typeCssName . '.css', array('version' => 'auto'));

$jsTypes = ['content_feature_accordion', 'image_feature_accordion', 'image_rotate', 'slideshow', 'tab_content', 'image_gallery', 'card_stack'];
if (in_array($p['type'], $jsTypes)) {
    $wa->registerAndUseScript('mod_phocaparticles.particlesjs', 'media/mod_phocaparticles/js/particles.min.js', array('version' => 'auto'));
}

if ($p['enable_animation'] == 1) {
    $wa->registerAndUseStyle('mod_phocaparticles.animationcss', 'media/mod_phocaparticles/css/animation.css', array('version' => 'auto'));
    $wa->registerAndUseScript('mod_phocaparticles.animationjs', 'media/mod_phocaparticles/js/animation.min.js', array('version' => 'auto'));
}

if ($p['custom_css'] != '') {
    $p['custom_css'] = str_replace('{moduleclass}', '.'.$idClass, $p['custom_css']);
	$document->addStyledeclaration($p['custom_css']);
}


/* STYLE */

$p['style_icon'] = $p['icon_color'] != '' ? ' style="color: '.strip_tags($p['icon_color']).';"' : '';
$p['style_title'] = $p['title_color'] != '' ? ' style="color: '.strip_tags($p['title_color']).';"' : '';

/* Sizde of boxes */
$boxSizes = [];
if ($p['type'] == 'image_feature_box') {
    $boxSizes = $p['image_feature_box_size'];
} else if ($p['type'] == 'content_feature_box') {
    $boxSizes = $p['content_feature_box_size'];
} else if ($p['type'] == 'image_content') {
    $boxSizes = $p['image_content_size'];
} else if ($p['type'] == 'image_feature_accordion') {
    $boxSizes = $p['image_feature_accordion_size'];
} else if  ($p['type'] == 'content_feature_accordion') {
    $boxSizes = $p['content_feature_accordion_size'];
}


$p['box_width_class'] = '';
$p['box_flex_class'] = '';

if ($p['type'] == 'image_row') {
    $p['box_width_class'] = ' pmpw'.$p['image_row_box_size'];
} else if ($p['type'] == 'gridbox') {
    $p['box_width_class'] = ' pmpw50';
}
/*
 * ic   image     content
 * cc   content   feature
 */

switch($boxSizes) {

    case 2:
        $p['box_size_ic'] = ' pmpw50';
        $p['box_size_cc'] = ' pmpw50';

    break;

    case 3:
        $p['box_size_ic'] = ' pmpw60';
        $p['box_size_cc'] = ' pmpw40';
    break;

    case 4:
        $p['box_size_ic'] = ' pmpw60';
        $p['box_size_cc'] = ' pmpw40';
        $p['box_flex_class'] = ' pmpReverse';
    break;

    case 5:
        $p['box_size_ic'] = ' pmpw50';
        $p['box_size_cc'] = ' pmpw50';
        $p['box_flex_class'] = ' pmpReverse';
    break;

    case 6:
        $p['box_size_ic'] = ' pmpw40';
        $p['box_size_cc'] = ' pmpw60';
        $p['box_flex_class'] = ' pmpReverse';
    break;

    case 7:
        $p['box_size_ic'] = ' pmpw50';
        $p['box_size_cc'] = ' pmpw25';
    break;
    case 8:
        $p['box_size_ic'] = ' pmpw30';
        $p['box_size_cc'] = ' pmpw35';
    break;

    case 1:
        $p['box_size_ic'] = ' pmpw40';
        $p['box_size_cc'] = ' pmpw60';
    break;

    default:
        $p['box_size_ic'] = '';
        $p['box_size_cc'] = '';
    break;
}

require(ModuleHelper::getLayoutPath('mod_phocaparticles', $p['type'] ));
?>
