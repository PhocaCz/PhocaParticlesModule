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


if (!empty($items)) {
	echo '<div class="phModParticles" id="'. $id .'">';
	echo '<div class="phModParticlesCards">';
	
	$styleIcon = $p['icon_color'] != '' ? ' style="color: '.strip_tags($p['icon_color']).';"' : '';
	$styleTitle = $p['title_color'] != '' ? ' style="color: '.strip_tags($p['title_color']).';"' : '';
	
	foreach($items as $k => $v) {
        echo '<div class="phModParticlesItem">';
		echo '<div class="phModParticlesIcon" '.$styleIcon.'><i class="'.htmlspecialchars(strip_tags($v->item_icon_class)).'"></i></div>';
        echo '<div class="phModParticlesTitle" '.$styleTitle.'>'.$v->item_title.'</div>';
		echo '<div class="phModParticlesDesc">'.$v->item_description.'</div>';
		echo '</div>';
	}

	echo '</div>';
	echo '</div>';
}

