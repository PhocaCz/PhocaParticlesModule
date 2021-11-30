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
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;

if (!empty($items)) {
	echo '<div class="phModParticles" id="'. $id .'">';

	if ($p['description_top'] != '') {
		echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
	}

	echo '<div class="phModParticlesImageContent">';

	$styleIcon = $p['icon_color'] != '' ? ' style="color: '.strip_tags($p['icon_color']).';"' : '';
	$styleTitle = $p['title_color'] != '' ? ' style="color: '.strip_tags($p['title_color']).';"' : '';
	$boxWidthClass = '';//' pmpw'.$p['image_row_box_size'];
	$flexClass = '';

	switch($p['image_content_size']) {

		case 2:
			$iC = ' pmpw50';
			$cC = ' pmpw50';

		break;

		case 3:
			$iC = ' pmpw60';
			$cC = ' pmpw40';
		break;

		case 4:
			$iC = ' pmpw60';
			$cC = ' pmpw40';
			$flexClass = ' pmpReverse';
		break;

		case 5:
			$iC = ' pmpw50';
			$cC = ' pmpw50';
			$flexClass = ' pmpReverse';
		break;

		case 6:
			$iC = ' pmpw40';
			$cC = ' pmpw60';
			$flexClass = ' pmpReverse';
		break;

		case 1:
		default:
			$iC = ' pmpw40';
			$cC = ' pmpw60';
		break;
	}

	foreach($items as $k => $v) {
        echo '<div class="phModParticlesItem'.$boxWidthClass.$flexClass.'">';

		$linkStartIcon = '';
		$linkStartTitle = '';
		$linkEnd = '';
		if (isset($v->item_link) && $v->item_link != '') {
			$linkStartIcon = '<a href="'.htmlspecialchars($v->item_link).'" '.$styleIcon.' >';
			$linkStartTitle = '<a href="'.htmlspecialchars($v->item_link).'" '.$styleTitle.' >';
			$linkEnd = '</a>';
		}

		if (isset($v->item_image) && $v->item_image != '') {
			echo '<div class="phModParticlesImage'.$iC.'" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.JURI::base() . '/'.htmlspecialchars(strip_tags($v->item_image)).'"/>'. $linkEnd .'</div>';
		}

		if (isset($v->item_content) && $v->item_content != '') {
			echo '<div class="phModParticlesContent'.$cC.'">'.HTMLHelper::_('content.prepare', $v->item_content).'</div>';
		}
		echo '</div>';
	}


	echo '</div>';



	if ($p['description_bottom'] != '') {
		echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
	}

	echo '</div>';
}

