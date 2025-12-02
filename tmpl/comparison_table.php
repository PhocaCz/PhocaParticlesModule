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
use Joomla\CMS\Uri\Uri;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

if (!empty($items)) {
	echo '<div class="'.$class .'" id="'. $id .'">';

	if ($p['description_top'] != '') {
		echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
	}

    if ($p['main_top_code'] != '') {
        echo $p['main_top_code'];
    }

	if ($p['main_title'] != '') {
        echo '<div class="phModParticlesItemTitle">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>';
    }

    if ($p['main_description'] != '') {
        echo '<div class="phModParticlesItemDesc">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>';
    }

	echo '<div class="phModParticlesComparisonTable">';


	foreach($items as $k => $v) {

        $titleObject    = PhocaParticlesHelper::getTitleObject($v);
        $linkObject     = PhocaParticlesHelper::getLinkObject($v, $p, $titleObject);
        $boxItemClass   = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';
        $titlePrefix    = (($v->item_title_prefix ?? '') !== '') ? '<span class="phModParticlesTitlePrefix">' . htmlspecialchars($v->item_title_prefix) . '</span>' : '';
        $titleSuffix    = (($v->item_title_suffix ?? '') !== '') ? '<span class="phModParticlesTitleSuffix">' . htmlspecialchars($v->item_title_suffix) . '</span>' : '';


        echo '<div class="card phModParticlesItem'.$boxItemClass.'">';


		if (isset($v->item_icon_class) && $v->item_icon_class != '') {
			echo '<div class="phModParticlesIcon" '.$p['style_icon'].'>'. $linkObject['starticon'] .'<i class="'.htmlspecialchars(strip_tags($v->item_icon_class)).'"></i>'. $linkObject['end'] .'</div>';
        } else if (isset($v->item_image_svg) && $v->item_image_svg != '') {
			echo '<div class="phModParticlesSvg" '.$p['style_icon'].'>'. $linkObject['starticon'] .$v->item_image_svg. $linkObject['end'] .'</div>';
		} else if (isset($v->item_image) && $v->item_image != '') {
			echo '<div class="phModParticlesImage" '.$p['style_icon'].'>'. $linkObject['starticon'] .'<img'.PhocaParticlesHelper::completeValueAttribute($p['item_image_animation'] ).' src="'.URI::base() . '/'.htmlspecialchars(strip_tags($v->item_image)).'" alt="'.$titleObject['alt'].'" />'. $linkObject['end'] .'</div>';
		}
		if ($titleObject['title'] != '') {
			echo '<div class="phModParticlesTitle" '.$p['style_title'] .'>'.$linkObject['starttitle'] .$titlePrefix.PhocaParticlesHelper::completeValueContent( $titleObject['title'], $p['item_title_animation']) .$titleSuffix. $linkObject['end'] . '</div>';
		}

		if (isset($v->item_description) && $v->item_description != '') {
			echo '<div class="phModParticlesDesc">'.PhocaParticlesHelper::completeValueContent($v->item_description, $p['item_description_animation']) .'</div>';
		} else if (isset($v->item_content) && $v->item_content != '') {
			echo '<div class="phModParticlesContent">'. HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($v->item_content, $p['item_content_animation'])) . '</div>';
        }

        if (isset($v->item_button_title) && $v->item_button_title != '') {
			$buttonLink = '';
			if (isset($v->item_button_link) && $v->item_button_link != '') {
				$buttonLink = $v->item_button_link;
			}

			$buttonAttr = '';
			if (isset($v->item_button_attributes) && $v->item_button_attributes != '') {
				$buttonAttr = $v->item_button_attributes;
			}

			echo '<div class="phModParticlesButtonBox"><a class="'.$p['button_css'] .' phModParticlesButton" href="'.$buttonLink.'" '.$buttonAttr.'>'.$v->item_button_title.'</a></div>';
		}


		echo '</div>';
	}


	echo '</div>';

    if ($p['main_bottom_code'] != '') {
        echo $p['main_bottom_code'];
    }

	if ($p['description_bottom'] != '') {
		echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
	}

	echo '</div>';
}

