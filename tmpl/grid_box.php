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

echo '<div class="'.$class .'" id="'. $id .'">';

if ($p['description_top'] != '') {
    echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
}

if ($p['main_top_code'] != '') {
    echo $p['main_top_code'];
}

echo '<div class="phModParticlesGridBoxBox '.$p['grid_box_type'].'">';


$p['box_width_class'] = ' pmpw50';//' pmpw'.$p['image_row_box_size'];
$p['box_flex_class'] = '';

$itemO = [];
$itemP = [];
if (!empty($items)) {
	foreach($items as $k => $v) {

        $titleObject    = PhocaParticlesHelper::getTitleObject($v);
        $linkObject     = PhocaParticlesHelper::getLinkObject($v, $p, $titleObject);
        $boxItemClass   = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';
        $titlePrefix    = (($v->item_title_prefix ?? '') !== '') ? '<span class="phModParticlesTitlePrefix">' . htmlspecialchars($v->item_title_prefix) . '</span>' : '';
        $titleSuffix    = (($v->item_title_suffix ?? '') !== '') ? '<span class="phModParticlesTitleSuffix">' . htmlspecialchars($v->item_title_suffix) . '</span>' : '';


        $itemO[$k][] =  '<div class="phModParticlesIconBox">';

        if (isset($v->item_icon_class) && $v->item_icon_class != '') {
            $itemO[$k][] = '<div class="phModParticlesIcon" ' . $p['style_icon'] . '>' . $linkObject['starticon'] . '<i class="' . htmlspecialchars(strip_tags($v->item_icon_class)) . '"></i>' . $linkObject['end'] . '</div>';
        } else if (isset($v->item_image_svg) && $v->item_image_svg != '') {
			$itemO[$k][] = '<div class="phModParticlesSvg" '.$p['style_icon'].'>'. $linkObject['starticon'] .$v->item_image_svg. $linkObject['end'] .'</div>';
		} else if (isset($v->item_image) && $v->item_image != '') {
			// This is used in this type for background image
            //$itemO[$k][]  = '<div class="phModParticlesImage" '.$p['style_icon'].'>'. $linkObject['starticon'] .'<img src="'.URI::base() . '/'.htmlspecialchars(strip_tags($v->item_image)).'" alt="'.$titleObject['alt'].'" />'. $linkObject['end'] .'</div>';
		}

        $itemO[$k][] = '</div>';
        $itemO[$k][] = '<div class="phModParticlesDescBox">';


		if ($titleObject['title'] != '') {
			$itemO[$k][] = '<div class="phModParticlesTitle" '.$p['style_title'].'>'.$linkObject['starttitle'] .$titlePrefix.PhocaParticlesHelper::completeValueContent( $titleObject['title'], $p['item_title_animation']) .$titleSuffix. $linkObject['end'] . '</div>';
		}
		if (isset($v->item_description) && $v->item_description != '') {
			$itemO[$k][] = '<div class="phModParticlesDesc">'.PhocaParticlesHelper::completeValueContent($v->item_description, $p['item_description_animation']) .'</div>';
		}

        if (($v->item_content ?? '') !== '') {
            $itemO[$k][] = '<div class="phModParticlesContent">' . HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($v->item_content, $p['item_content_animation'])). '</div>';
        }


        $itemO[$k][] =  '</div>';


        if (($v->button_title ?? '') !== '') {

            $buttonLink = $v->button_link ?? '';
            $buttonAttr = $v->button_attributes ?? '';

            $itemO[$k][] = '<div class="phModParticlesButtonBox"><a class="'.$p['button_css'] .' phModParticlesButton" href="'.$buttonLink.'" '.$buttonAttr.'>'.$v->button_title.'</a></div>';
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

$style = $itemP[0]['style'] ?? '';
$itemClass = $itemP[0]['class'] ?? '';
echo '<div class="phModParticlesItem'.$p['box_width_class'].$p['box_flex_class'].'">';
echo '<div class="phModParticlesItemRow">';
echo '<div class="phModParticlesItemBox phModParticlesBackgroundImage pmpcount0 pmpw100'.$itemClass.'"'.$style.'>';
echo implode("\n", $itemO[0]);
echo '</div>';
echo '</div>';
echo '</div>';


if (!empty($itemO[1])) {

    echo '<div class="phModParticlesItem' . $p['box_width_class'] . $p['box_flex_class'] . '">';

        echo '<div class="phModParticlesItemRow">';
        if (!empty($itemO[2])) {

            // Assignment using ??
            $style     = $itemP[1]['style'] ?? '';
            $itemClass = $itemP[1]['class'] ?? '';

            echo '<div class="phModParticlesItemBox phModParticlesBackgroundImage pmpcount1' . $p['box_width_class'] . $itemClass . '"' . $style . '>';
            echo implode("\n", $itemO[1]);
            echo '</div>';

            // Assignment using ??
            $style     = $itemP[2]['style'] ?? '';
            $itemClass = $itemP[2]['class'] ?? '';

            echo '<div class="phModParticlesItemBox phModParticlesBackgroundImage pmpcount2' . $p['box_width_class'] . $itemClass . '"' . $style . '>';
            echo implode("\n", $itemO[2]);
            echo '</div>';

        } else {
            // Assignment using ??
            $style     = $itemP[1]['style'] ?? '';
            $itemClass = $itemP[1]['class'] ?? '';

            echo '<div class="phModParticlesItemBox phModParticlesBackgroundImage pmpcount1 pmpw100' . $itemClass . '"' . $style . '>';
            echo implode("\n", $itemO[1]);
            echo '</div>';
        }
        echo '</div>'; // End phModParticlesItemRow

        echo '<div class="phModParticlesItemRow">';
        if (!empty($itemO[3])) {

            if (!empty($itemO[4])) {
                // Assignment using ??
                $style     = $itemP[3]['style'] ?? '';
                $itemClass = $itemP[3]['class'] ?? '';

                echo '<div class="phModParticlesItemBox phModParticlesBackgroundImage pmpcount3' . $p['box_width_class'] . $itemClass . '"' . $style . '>';
                echo implode("\n", $itemO[3]);
                echo '</div>';

                // Assignment using ??
                $style     = $itemP[4]['style'] ?? '';
                $itemClass = $itemP[4]['class'] ?? '';

                echo '<div class="phModParticlesItemBox phModParticlesBackgroundImage pmpcount4' . $p['box_width_class'] . $itemClass . '"' . $style . '>';
                echo implode("\n", $itemO[4]);
                echo '</div>';

            } else {
                // Assignment using ??
                $style     = $itemP[3]['style'] ?? '';
                $itemClass = $itemP[3]['class'] ?? '';

                echo '<div class="phModParticlesItemBox phModParticlesBackgroundImage pmpcount5 pmpw100' . $itemClass . '"' . $style . '>';
                echo implode("\n", $itemO[3]);
                echo '</div>';
            }

        }
        echo '</div>'; // End phModParticlesItemRow

    echo '</div>'; // End phModParticlesItem
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

    echo '<div class="phModParticlesButtonBox"><a class="'.$p['button_css'] .' phModParticlesButton" href="'.$buttonLink.'" '.$buttonAttr.'>'.$p['main_button_title'].'</a></div>';
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


