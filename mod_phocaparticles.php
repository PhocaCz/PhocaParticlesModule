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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Version;

defined('_JEXEC') or die('Restricted access');// no direct access




$app 						= JFactory::getApplication();
$document 					= JFactory::getDocument();
$p 							= array();

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
$p['main_description'] 		= $params->get( 'main_description', '');
$p['main_link'] 			= $params->get( 'main_link', '');
$p['main_link_attributes'] 	= $params->get( 'main_link_attributes', '');
$p['main_button_title'] 	= $params->get( 'main_button_title', '');
$p['main_button_link'] 		= $params->get( 'main_button_link', '');
$p['main_button_attributes'] = $params->get( 'main_button_attributes', '');
$p['main_content'] 			= $params->get( 'main_content', '');
$p['main_background_image'] = $params->get( 'main_background_image', '');
$p['main_label']            = $params->get( 'main_label', '');
$p['main_price'] 			= $params->get( 'main_price', '');
$p['main_price_original']   = $params->get( 'main_price_original', '');


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

// Main Background Image
$styleType = str_replace('_', ' ', $p['type']);
$styleType = ucwords($styleType);
$styleType = str_replace(' ', '', $styleType);
$styleType = '.phModParticles'.htmlspecialchars($styleType);


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
    $style[] = 'background-image: url('.JURI::base(true) . '/'.$image.');';
    $style[] = 'background-repeat: no-repeat;';
	$style[] = 'background-size: cover;';
    $style[] = '}';
}


if (!empty($style)) {
     $document->addStyledeclaration(implode("\n",  $style));
}


$items = (array)$params->get('items');
JHTML::stylesheet( 'media/mod_phocaparticles/css/style.css' );


if ($p['custom_css'] != '') {
	$document->addStyledeclaration($p['custom_css']);
}

$rand = rand ( 10000 , 99999 );
$id = 'ph-mod-phoca-particles-'.$rand;
$idJs = 'pS'.$rand;

require(JModuleHelper::getLayoutPath('mod_phocaparticles', $p['type'] ));
?>
