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

echo '<div class="phModParticlesGridBoxBox">';

$styleIcon = $p['icon_color'] != '' ? ' style="color: '.strip_tags($p['icon_color']).';"' : '';
$styleTitle = $p['title_color'] != '' ? ' style="color: '.strip_tags($p['title_color']).';"' : '';
$boxWidthClass = ' pmpw50';//' pmpw'.$p['image_row_box_size'];
$flexClass = '';
/*
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
*/

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




// OPEN IMAGE BLOCK
/*
if ($p['main_image'] != '') {
    echo '<div class="phModParticlesItemImage'.$iC.'" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.URI::base() . '/'.htmlspecialchars(strip_tags($p['main_image'])).'" alt="'.$titleAlt.'" />'. $linkEnd .'';
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
*//*
// CLOSE IMAGE BLOCK
if ($p['main_image'] != '') {
    echo '</div>';
} else if ($p['image_empty_space'] == 1){
    // Display empty space instead of image, in case e.g. the background image includes some part like image
    echo '<div class="phModParticlesItemImage'.$iC.'" '.$styleIcon.'></div>';
}


echo '<div class="phModParticlesItemFeatureBox'.$cC.'">';
*/
$itemO = [];
$itemP = [];
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


        $itemO[$k][] =  '<div class="phModParticlesIconBox">';

        if (isset($v->item_icon_class) && $v->item_icon_class != '') {
            $itemO[$k][] = '<div class="phModParticlesIcon" ' . $styleIcon . '>' . $linkStartIcon . '<i class="' . htmlspecialchars(strip_tags($v->item_icon_class)) . '"></i>' . $linkEnd . '</div>';
        } else if (isset($v->item_image_svg) && $v->item_image_svg != '') {
			$itemO[$k][] = '<div class="phModParticlesSvg" '.$styleIcon.'>'. $linkStartIcon .$v->item_image_svg. $linkEnd .'</div>';
		} else if (isset($v->item_image) && $v->item_image != '') {
			// This is used in this type for background image
            //$itemO[$k][]  = '<div class="phModParticlesImage" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.URI::base() . '/'.htmlspecialchars(strip_tags($v->item_image)).'" alt="'.$titleAlt.'" />'. $linkEnd .'</div>';
		}

        $itemO[$k][] = '</div>';
        $itemO[$k][] = '<div class="phModParticlesDescBox">';

		if ($title != '') {
			$itemO[$k][] = '<div class="phModParticlesTitle" '.$styleTitle.'>'. $linkStartTitle . $title. $linkEnd . '</div>';
		}
		if (isset($v->item_description) && $v->item_description != '') {
			$itemO[$k][] = '<div class="phModParticlesDesc">'.$v->item_description.'</div>';
		}
        $itemO[$k][] =  '</div>';


        if (isset($v->button_title) && $v->button_title != '') {
            $buttonLink = '';
            if (isset($v->button_link) && $v->button_link != '') {
                $buttonLink = $v->button_link;
            }

            $buttonAttr = '';
            if (isset($v->button_attributes) && $v->button_attributes != '') {
                $buttonAttr = $v->button_attributes;
            }

            $itemO[$k][] = '<div class="phModParticlesButtonBox"><a class="phModParticlesButton" href="'.$buttonLink.'" '.$buttonAttr.'>'.$v->button_title.'</a></div>';
        }


        if (isset($v->item_image) && $v->item_image != '') {
            $imgClean = HTMLHelper::cleanImageURL($v->item_image);
            if ($imgClean->url != '') {
                $itemP[$k]['style'] = ' style="background-image: url('.Uri::base() . $imgClean->url.');"';
            }
        }

        if (isset($v->item_image) && $v->item_image != '') {
            $itemP[$k]['class'] = ' '.$v->item_class.'';
        }

	}
}

$style = isset($itemP[0]['style'])? $itemP[0]['style'] : '';
$itemClass = isset($itemP[0]['class'])? $itemP[0]['class'] : '';
echo '<div class="phModParticlesItem'.$boxWidthClass.$flexClass.'">';
echo '<div class="phModParticlesItemRow">';
echo '<div class="phModParticlesItemBox phModPrticlesBackgroundImage pmpcount0 pmpw100'.$itemClass.'"'.$style.'>';
echo implode("\n", $itemO[0]);
echo '</div>';
echo '</div>';
echo '</div>';

if (!empty($itemO[1])) {

    echo '<div class="phModParticlesItem' . $boxWidthClass . $flexClass . '">';

        echo '<div class="phModParticlesItemRow">';
        if (!empty($itemO[2])) {

            $style = isset($itemP[1]['style'])? $itemP[1]['style'] : '';
            $itemClass = isset($itemP[1]['class'])? $itemP[1]['class'] : '';
            echo '<div class="phModParticlesItemBox phModPrticlesBackgroundImage pmpcount1' . $boxWidthClass.$itemClass.'"'.$style.'>';
            echo implode("\n", $itemO[1]);
            echo '</div>';

            $style = isset($itemP[2]['style'])? $itemP[2]['style'] : '';
            $itemClass = isset($itemP[2]['class'])? $itemP[2]['class'] : '';
            echo '<div class="phModParticlesItemBox phModPrticlesBackgroundImage pmpcount2' . $boxWidthClass.$itemClass.'"'.$style.'>';
            echo implode("\n", $itemO[2]);
            echo '</div>';
        } else {
            $style = isset($itemP[1]['style'])? $itemP[1]['style'] : '';
            $itemClass = isset($itemP[1]['class'])? $itemP[1]['class'] : '';
            echo '<div class="phModParticlesItemBox phModPrticlesBackgroundImage pmpcount1 pmpw100'.$itemClass.'"'.$style.'>';
            echo implode("\n", $itemO[1]);
            echo '</div>';
        }
        echo '</div>';

        echo '<div class="phModParticlesItemRow">';
        if (!empty($itemO[3])) {

            if (!empty($itemO[4])) {
                $style = isset($itemP[3]['style'])? $itemP[3]['style'] : '';
                $itemClass = isset($itemP[3]['class'])? $itemP[3]['class'] : '';
                echo '<div class="phModParticlesItemBox phModPrticlesBackgroundImage pmpcount3' . $boxWidthClass .$itemClass.'"'.$style.'>';
                echo implode("\n", $itemO[3]);
                echo '</div>';
                $style = isset($itemP[4]['style'])? $itemP[4]['style'] : '';
                $itemClass = isset($itemP[4]['class'])? $itemP[4]['class'] : '';
                echo '<div class="phModParticlesItemBox phModPrticlesBackgroundImage pmpcount4' . $boxWidthClass .$itemClass.'"'.$style.'>';
                echo implode("\n", $itemO[4]);
                echo '</div>';
            } else {
                $style = isset($itemP[3]['style'])? $itemP[3]['style'] : '';
                $itemClass = isset($itemP[3]['class'])? $itemP[3]['class'] : '';
                echo '<div class="phModParticlesItemBox phModPrticlesBackgroundImage pmpcount5 pmpw100'.$itemClass.'"'.$style.'>';
                echo implode("\n", $itemO[3]);
                echo '</div>';
            }

        }
        echo '</div>';

    echo '</div>';
}

/*
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
*/

echo '</div>'; //  end phModParticlesGridBox

echo '</div>'; //  end phModParticlesItem

echo '</div>'; // end phModParticlesImageFeatureBox

if ($p['main_bottom_code'] != '') {
    echo $p['main_bottom_code'];
}

if ($p['description_bottom'] != '') {
    echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
}

echo '</div>'; // end phModParticles


