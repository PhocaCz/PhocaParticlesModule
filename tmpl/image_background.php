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

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

$document = Factory::getDocument();

if (!empty($items)) {
	echo '<div class="phModParticles" id="'. $id .'">';

    if ($p['description_top'] != '') {
		echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
	}


    $style = array();

    $styleIcon = $p['icon_color'] != '' ? ' style="color: '.strip_tags($p['icon_color']).';"' : '';
	$styleTitle = $p['title_color'] != '' ? ' style="color: '.strip_tags($p['title_color']).';"' : '';

    foreach($items as $k => $v) {

        $style[] = '.phModParticlesImageBackground {';
        $image = '';
        if (isset($v->item_image) && $v->item_image != '') {
            $imgClean = HTMLHelper::cleanImageURL($v->item_image);

            if ($imgClean->url != '') {
               $image =  $imgClean->url;
               $style[] = 'background-image: url('.JURI::base(true) . '/'.$image.');';

            }

        }
        $style[] = '}';

        if (!empty($style)) {
             $document->addStyledeclaration(implode("\n",  $style));
        }

        echo '<div class="phModParticlesImageBackground">';
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
        } else if (isset($v->item_image_svg) && $v->item_image_svg != '') {
			echo '<div class="phModParticlesSvg" '.$styleIcon.'>'. $linkStartIcon .$v->item_image_svg. $linkEnd .'</div>';
		}

        // Image in this view is the background image
        /*else if (isset($v->item_image) && $v->item_image != '') {

            //echo '<div class="phModParticlesImage" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.JURI::base() . '/'.htmlspecialchars(strip_tags($v->item_image)).'"/>'. $linkEnd .'</div>';
		}*/

        if (isset($v->item_title) && $v->item_title != '') {
			echo '<div class="phModParticlesTitle" '.$styleTitle.'>'. $linkStartTitle . $v->item_title. $linkEnd . '</div>';
		}

        if (isset($v->item_description) && $v->item_description != '') {
			echo '<div class="phModParticlesDesc">'.$v->item_description.'</div>';
		}

		if (isset($v->item_content) && $v->item_content != '') {
			echo '<div class="phModParticlesContent">'.HTMLHelper::_('content.prepare', $v->item_content).'</div>';
		}

        if (isset($v->button_title) && $v->item_title != '') {
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
        echo '</div>';
	}

	if ($p['description_bottom'] != '') {
		echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
	}

	echo '</div>';
}
