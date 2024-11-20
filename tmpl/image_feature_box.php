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


echo '<div class="'.$class .'" id="'. $id .'">';

if ($p['description_top'] != '') {
    echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
}

if ($p['main_top_code'] != '') {
    echo $p['main_top_code'];
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

    case 7:
        $iC = ' pmpw50';
        $cC = ' pmpw25';
    break;
    case 8:
        $iC = ' pmpw30';
        $cC = ' pmpw35';
    break;

    case 1:
    default:
        $iC = ' pmpw40';
        $cC = ' pmpw60';
    break;
}

$title = '';
$titleAlt= '';
if (isset($p['main_title']) && $p['main_title'] != '') {
    $title = $p['main_title'];
    $titleAlt = htmlspecialchars($title);
}

$linkStartIcon = '';
$linkStartTitle = '';
$linkEnd = '';
$linkAttr = '';
if (isset($p['main_link_attributes']) && $p['main_link_attributes'] != '') {
    $linkAttr = $p['main_link_attributes'];
}

if ($p['main_link'] != '') {
    $linkStartIcon = '<a href="'.htmlspecialchars($p['main_link']).'" '.$styleIcon.'  '.$linkAttr.' aria-label="'.$titleAlt.'">';
    $linkStartTitle = '<a href="'.htmlspecialchars($p['main_link']).'" '.$styleTitle.'  '.$linkAttr.'>';
    $linkEnd = '</a>';
}

echo '<div class="phModParticlesItem'.$boxWidthClass.$flexClass.'">';


$imageOutput = [];
$columnOutput = [];


// OPEN IMAGE BLOCK
if ($p['main_image'] != '') {
    $imageOutput[] = '<div class="phModParticlesItemImage'.$iC.'" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.URI::base() . '/'.htmlspecialchars(strip_tags($p['main_image'])).'" alt="'.$titleAlt.'" />'. $linkEnd .'';
}


if ($p['main_label'] != '') {
    $imageOutput[] = '<div class="phModParticlesItemLabel'.$cC.'">'.$p['main_label'].'</div>';
}
if ($p['main_price_original'] != '') {
    $imageOutput[] = '<div class="phModParticlesItemPriceOriginal'.$cC.'">'.$p['main_price_original'].'</div>';
}
if ($p['main_price'] != '') {
    $imageOutput[] = '<div class="phModParticlesItemPrice'.$cC.'">'.$p['main_price'].'</div>';
}

// CLOSE IMAGE BLOCK
if ($p['main_image'] != '') {
    $imageOutput[] = '</div>';
} else if ($p['image_empty_space'] == 1){
    // Display empty space instead of image, in case e.g. the background image includes some part like image
    $imageOutput[] = '<div class="phModParticlesItemImage'.$iC.'" '.$styleIcon.'></div>';
}




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
			$linkStartIcon = '<a href="'.htmlspecialchars($v->item_link).'"'.$styleIcon.$linkAttr.' aria-label="'.$titleAlt.'">';
			$linkStartTitle = '<a href="'.htmlspecialchars($v->item_link).'"'.$styleTitle.$linkAttr.'>';
			$linkEnd = '</a>';
		}


        $columnOutput[$k][] =  '<div class="phModParticlesIconBox">';

        if (isset($v->item_icon_class) && $v->item_icon_class != '') {
            $columnOutput[$k][] = '<div class="phModParticlesIcon" ' . $styleIcon . '>' . $linkStartIcon . '<i class="' . htmlspecialchars(strip_tags($v->item_icon_class)) . '"></i>' . $linkEnd . '</div>';
        } else if (isset($v->item_image_svg) && $v->item_image_svg != '') {
			$columnOutput[$k][]  = '<div class="phModParticlesSvg" '.$styleIcon.'>'. $linkStartIcon .$v->item_image_svg. $linkEnd .'</div>';
		} else if (isset($v->item_image) && $v->item_image != '') {
			$columnOutput[$k][] = '<div class="phModParticlesImage" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.URI::base() . '/'.htmlspecialchars(strip_tags($v->item_image)).'" alt="'.$titleAlt.'" />'. $linkEnd .'</div>';
		}

        $columnOutput[$k][] = '</div>';
        $columnOutput[$k][] =  '<div class="phModParticlesDescBox">';

		if ($title != '') {
			$columnOutput[$k][] =  '<div class="phModParticlesTitle" '.$styleTitle.'>'. $linkStartTitle . $title. $linkEnd . '</div>';
		}
		if (isset($v->item_description) && $v->item_description != '') {
			$columnOutput[$k][] =  '<div class="phModParticlesDesc">'.$v->item_description.'</div>';
		}
        $columnOutput[$k][] =  '</div>';


	}
}


if ($p['image_feature_box_size'] != 7 && $p['image_feature_box_size'] != 8) {

    // 1) Standard output - one feature box and one image column

    // First the image
    echo implode("\n", $imageOutput);

    // Then the feature box
    echo '<div class="phModParticlesItemFeatureBox' . $cC . '">';

    if (!empty($columnOutput)) {
        foreach ($columnOutput as $k => $v) {

            if (!empty($v)) {
                echo implode("\n", $v);
            }
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


} else {

    // 2) Feature box is divided into two columns and the output is: half feature box column | image column | half feature box column
    //    There is no more general part with button as such will be duplicated in both columns

    $columnOutput2 = [];
    if (!empty($columnOutput)) {
        $columnOutput2 = array_chunk($columnOutput, (int)ceil(count($columnOutput) / 2));
    }


    echo '<div class="phModParticlesItemFeatureBox' . $cC . '">';

    if (!empty($columnOutput2[0])) {
        foreach ($columnOutput2[0] as $k => $v) {

            if (!empty($v)) {
                echo implode("\n", $v);
            }
        }
    }

    echo '</div>'; //  end phModParticlesItemFeatureBox

    echo implode("\n", $imageOutput);

    echo '<div class="phModParticlesItemFeatureBox' . $cC . '">';

    if (!empty($columnOutput2[1])) {
        foreach ($columnOutput2[1] as $k => $v) {

            if (!empty($v)) {
                echo implode("\n", $v);
            }
        }
    }

    echo '</div>'; //  end phModParticlesItemFeatureBox



}






echo '</div>'; //  end phModParticlesItem

echo '</div>'; // end phModParticlesImageFeatureBox

if ($p['main_bottom_code'] != '') {
    echo $p['main_bottom_code'];
}

if ($p['description_bottom'] != '') {
    echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
}

echo '</div>'; // end phModParticles


