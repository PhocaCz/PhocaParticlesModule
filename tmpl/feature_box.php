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

if (!empty($items)) {
	echo '<div class="'.$class .'" id="'. $id .'">';

	if ($p['description_top'] != '') {
		echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
	}

    if ($p['main_top_code'] != '') {
        echo $p['main_top_code'];
    }

	echo '<div class="phModParticlesFeatureBox">';

	$styleIcon = $p['icon_color'] != '' ? ' style="color: '.strip_tags($p['icon_color']).';"' : '';
	$styleTitle = $p['title_color'] != '' ? ' style="color: '.strip_tags($p['title_color']).';"' : '';



	foreach($items as $k => $v) {

        $title = '';
        $titleAlt= '';
        if (isset($v->item_title) && $v->item_title != '') {
            $title = $v->item_title;
            $titleAlt = htmlspecialchars($title);
        }

        $boxItemClass = '';
        if (isset($v->item_class) && $v->item_class != '') {
            $boxItemClass = ' ' . htmlspecialchars($v->item_class);
        }

        echo '<div class="phModParticlesItem'.$boxItemClass.'">';

		$linkStartIcon = '';
		$linkStartTitle = '';
		$linkEnd = '';
        $linkAttr = '';

        if (isset($v->item_link_attributes) && $v->item_link_attributes != '') {
            $linkAttr = ' '.$v->item_link_attributes;
        }

		if (isset($v->item_link) && $v->item_link != '') {
			$linkStartIcon = '<a href="'.htmlspecialchars($v->item_link).'"'.$styleIcon.$linkAttr.' aria-label="'.$titleAlt.'">';
			$linkStartTitle = '<a href="'.htmlspecialchars($v->item_link).'"'.$styleTitle.$linkAttr.'>';
			$linkEnd = '</a>';
		}



		if (isset($v->item_icon_class) && $v->item_icon_class != '') {
			echo '<div class="phModParticlesIcon" '.$styleIcon.'>'. $linkStartIcon .'<i class="'.htmlspecialchars(strip_tags($v->item_icon_class)).'"></i>'. $linkEnd .'</div>';
        } else if (isset($v->item_image_svg) && $v->item_image_svg != '') {
			echo '<div class="phModParticlesSvg" '.$styleIcon.'>'. $linkStartIcon .$v->item_image_svg. $linkEnd .'</div>';
		} else if (isset($v->item_image) && $v->item_image != '') {
			echo '<div class="phModParticlesImage" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.URI::base() . '/'.htmlspecialchars(strip_tags($v->item_image)).'" alt="'.$titleAlt.'" />'. $linkEnd .'</div>';
		}
		if ($title != '') {
			echo '<div class="phModParticlesTitle" '.$styleTitle.'>'. $linkStartTitle . $title. $linkEnd . '</div>';
		}
		if (isset($v->item_description) && $v->item_description != '') {
			echo '<div class="phModParticlesDesc">'.$v->item_description.'</div>';
		}


		if (isset($v->button_title) && $v->button_title != '') {
			$buttonLink = '';
			if (isset($v->button_link) && $v->button_link != '') {
				$buttonLink = $v->button_link;
			}

			$buttonAttr = '';
			if (isset($v->button_attributes) && $v->button_attributes != '') {
				$buttonAttr = $v->button_attributes;
			}

			echo '<div class="phModParticlesButtonBox"><a class="phModParticlesButton" href="'.$buttonLink.'" '.$buttonAttr.'>'.$v->button_title.'</a></div>';
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

