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

	echo '<div class="phModParticlesFeatureRow">';

	$styleIcon = $p['icon_color'] != '' ? ' style="color: '.strip_tags($p['icon_color']).';"' : '';
	$styleTitle = $p['title_color'] != '' ? ' style="color: '.strip_tags($p['title_color']).';"' : '';

	foreach($items as $k => $v) {

        $title = '';
        $titleAlt= '';
        if (isset($v->item_title) && $v->item_title != '') {
            $title = $v->item_title;
            $titleAlt = htmlspecialchars($title);
        }

        echo '<div class="phModParticlesItem">';

		$linkStartIcon = '';
		$linkStartTitle = '';
		$linkEnd = '';
		if (isset($v->item_link) && $v->item_link != '') {
			$linkStartIcon = '<a href="'.htmlspecialchars($v->item_link).'" '.$styleIcon.' >';
			$linkStartTitle = '<a href="'.htmlspecialchars($v->item_link).'" '.$styleTitle.' >';
			$linkEnd = '</a>';
		}

		if (isset($v->item_icon_class) && $v->item_icon_class != '') {
			echo '<div class="phModParticlesIcon" '.$styleIcon.'>'. $linkStartIcon .'<i class="'.htmlspecialchars(strip_tags($v->item_icon_class)).'"></i>'. $linkEnd .'</div>';
        }
		if ($title != '') {
			echo '<div class="phModParticlesTitle" '.$styleTitle.'>'. $linkStartTitle . $title. $linkEnd . '</div>';
		}
		if (isset($v->item_description) && $v->item_description != '') {
			echo '<div class="phModParticlesDesc">'.$v->item_description.'</div>';
		}
		echo '</div>';
	}

	echo '</div>';

	if ($p['description_bottom'] != '') {
		echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
	}

	echo '</div>';
}

