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


echo '<div class="phModParticles" id="'. $id .'">';

if ($p['description_top'] != '') {
    echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
}

echo '<div class="phModParticlesImageFeatureBox">';

$styleIcon = $p['icon_color'] != '' ? ' style="color: '.strip_tags($p['icon_color']).';"' : '';
$styleTitle = $p['title_color'] != '' ? ' style="color: '.strip_tags($p['title_color']).';"' : '';
$boxWidthClass = '';//' pmpw'.$p['image_row_box_size'];
$flexClass = '';

switch($p['image_feature_box_size']) {

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


$linkStartIcon = '';
$linkStartTitle = '';
$linkEnd = '';
$linkAttr = '';
if (isset($p['main_link_attributes']) && $p['main_link_attributes'] != '') {
    $linkAttr = $p['main_link_attributes'];
}

if ($p['main_link'] != '') {
    $linkStartIcon = '<a href="'.htmlspecialchars($p['main_link']).'" '.$styleIcon.'  '.$linkAttr.'>';
    $linkStartTitle = '<a href="'.htmlspecialchars($p['main_link']).'" '.$styleTitle.'  '.$linkAttr.'>';
    $linkEnd = '</a>';
}

$title = '';
$titleAlt= '';
if (isset($p['main_title']) && $p['main_title'] != '') {
    $title = $p['main_title'];
    $titleAlt = htmlspecialchars($title);
}

echo '<div class="phModParticlesItem'.$boxWidthClass.$flexClass.'">';


// OPEN IMAGE BLOCK
if ($p['main_image'] != '') {
    echo '<div class="phModParticlesItemImage'.$iC.'" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.JURI::base() . '/'.htmlspecialchars(strip_tags($p['main_image'])).'" alt="'.$titleAlt.'" />'. $linkEnd .'';
}


if ($p['main_label'] != '') {
    echo '<div class="phModParticlesItemLabel'.$cC.'">'.$p['main_label'].'</div>';
}
if ($p['main_price_original'] != '') {
    echo '<div class="phModParticlesItemPriceOriginal'.$cC.'">'.$p['main_price_original'].'</div>';
}
if ($p['main_price'] != '') {
    echo '<div class="phModParticlesItemPrice'.$cC.'">'.$p['main_price'].'</div>';
}

// CLOSE IMAGE BLOCK
if ($p['main_image'] != '') {
    echo '</div>';
}


echo '<div class="phModParticlesItemFeatureBox'.$cC.'">';

if (!empty($items)) {
	foreach($items as $k => $v) {

        $title = '';
        if (isset($v->item_title) && $v->item_title != '') {
            $title = $v->item_title;
            $titleAlt = htmlspecialchars($title);
        }

        $linkStartIcon = '';
		$linkStartTitle = '';
		$linkEnd = '';
        $linkAttr = '';
        if (isset($v->item_link_attributes) && $v->item_link_attributes != '') {
            $linkAttr = ' '.$v->item_link_attributes;
        }

		if (isset($v->item_link) && $v->item_link != '') {
			$linkStartIcon = '<a href="'.htmlspecialchars($v->item_link).'"'.$styleIcon.$linkAttr.'>';
			$linkStartTitle = '<a href="'.htmlspecialchars($v->item_link).'"'.$styleTitle.$linkAttr.'>';
			$linkEnd = '</a>';
		}


        echo '<div class="phModParticlesIconBox">';

        if (isset($v->item_icon_class) && $v->item_icon_class != '') {
            echo '<div class="phModParticlesIcon" ' . $styleIcon . '>' . $linkStartIcon . '<i class="' . htmlspecialchars(strip_tags($v->item_icon_class)) . '"></i>' . $linkEnd . '</div>';
       // } else if (isset($v->item_image_svg) && $v->item_image_svg != '') {
		//	echo '<div class="phModParticlesSvg" '.$styleIcon.'>'. $linkStartIcon .$v->item_image_svg. $linkEnd .'</div>';
		} else if (isset($v->item_image) && $v->item_image != '') {
			echo '<div class="phModParticlesImage" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.JURI::base() . '/'.htmlspecialchars(strip_tags($v->item_image)).'" alt="'.$titleAlt.'" />'. $linkEnd .'</div>';
		}

        echo '</div>';
        echo '<div class="phModParticlesDescBox">';

		if ($title != '') {
			echo '<div class="phModParticlesTitle" '.$styleTitle.'>'. $linkStartTitle . $title. $linkEnd . '</div>';
		}
		if (isset($v->item_description) && $v->item_description != '') {
			echo '<div class="phModParticlesDesc">'.$v->item_description.'</div>';
		}
        echo '</div>';


	}
}

echo '<div class="phModParticlesIconBox"></div>';
echo '<div class="phModParticlesDescBox">';
// BUTTON Local (item) or GLOBAL (main)
if ($p['main_button_title']  != '') {
    $buttonLink = '';
    if ($p['main_button_link']  != '') {
        $buttonLink = $p['main_button_link'] ;
    }

    $buttonAttr = '';
    if ($p['main_button_attributes'] != '') {
        $buttonAttr = $p['main_button_attributes'];
    }

    echo '<div class="phModParticlesButtonBox"><a class="phModParticlesButton" href="'.$buttonLink.'" '.$buttonAttr.'>'.$p['main_button_title'].'</a></div>';
}
echo '</div>'; // end phModParticlesDescBox

echo '</div>'; //  end phModParticlesItemFeatureBox

echo '</div>'; //  end phModParticlesItem

echo '</div>'; // end phModParticlesImageFeatureBox


if ($p['description_bottom'] != '') {
    echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
}

echo '</div>'; // end phModParticles


