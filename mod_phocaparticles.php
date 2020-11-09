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
defined('_JEXEC') or die('Restricted access');// no direct access

$app 						= JFactory::getApplication();
$document 					= JFactory::getDocument();
$p 							= array();
$p['type'] 	    			= $params->get( 'type', 'feature_box');
$p['title_color'] 	    	= $params->get( 'title_color', '');
$p['icon_color'] 	    	= $params->get( 'icon_color', '');
$p['display_view'] 			= $params->get( 'display_view', '');
$p['display_option'] 		= $params->get( 'display_option', '');
$p['display_id'] 			= $params->get( 'display_id', '');
$p['description_top'] 		= $params->get( 'description_top', '');
$p['description_bottom'] 	= $params->get( 'description_bottom', '');

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


$items = (array)$params->get('items');
JHTML::stylesheet( 'media/mod_phocaparticles/css/style.css' );

$rand = rand ( 10000 , 99999 );
$id = 'ph-mod-phoca-particles-'.$rand;
$idJs = 'pS'.$rand;

require(JModuleHelper::getLayoutPath('mod_phocaparticles', $p['type'] ));
?>
