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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;


echo '<div class="'.$class .'" id="'. $id .'">';

if ($p['description_top'] != '') {
    echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
}

if ($p['main_top_code'] != '') {
    echo $p['main_top_code'];
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

// OPEN IMAGE BLOCK

if ($p['main_image'] != '') {
    echo '<div class="phModParticlesItemImage'.$iC.'" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.URI::base() . '/'.htmlspecialchars(strip_tags($p['main_image'])).'" alt="'.$titleAlt.'" />'. $linkEnd .'';
} else if (isset($items[0]->item_image) && $items[0]->item_image != ''){
    echo '<div class="phModParticlesItemImage'.$iC.'" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.URI::base() . '/'.htmlspecialchars(strip_tags($items[0]->item_image)).'" alt="'.$titleAlt.'" />'. $linkEnd .'';
} else if (isset($items[0]->item_image_svg) && $items[0]->item_image_svg != ''){
    echo '<div class="phModParticlesItemImage'.$iC.'" '.$styleIcon.'>'. $linkStartIcon .$items[0]->item_image_svg. $linkEnd .'';
} else if ($p['main_video'] != '') {
    echo '<div class="phModParticlesItemImage'.$iC.'" '.$styleIcon.'>';
    echo '<div class="phModParticlesVideoBox"><iframe width="'.htmlspecialchars(strip_tags($p['main_video_width'])).'" height="'.htmlspecialchars(strip_tags($p['main_video_height'])).'" src="//www.youtube.com/embed/'.htmlspecialchars(strip_tags($p['main_video'])).'" frameborder="0" allowfullscreen></iframe></div>';
} else if ($p['main_video_file']!= '') {

    $poster = '';
    if ($p['main_video_file_thumbnail'] != '') {
        $poster = 'poster="'.URI::base() . '/'.htmlspecialchars(strip_tags($p['main_video_file_thumbnail'])).'"';
    }

    echo '<div class="phModParticlesItemImage'.$iC.'" '.$styleIcon.'>';
    echo '<div class="phModParticlesVideoBox"><video width="'.htmlspecialchars(strip_tags($p['main_video_width'])).'" height="'.htmlspecialchars(strip_tags($p['main_video_height'])).'" controls loading="lazy"'.$poster.'>';
    echo '<source src="'.URI::base() . '/'.htmlspecialchars(strip_tags($p['main_video_file'])).'" type="video/mp4" controls>';
    echo Text::_('MOD_PHOCAPARTICLES_YOUR_BROWSWER_DOES_NOT_SUPPORT_VIDEO_TAG');
    echo '</video></div>';

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
} else if (isset($items[0]->item_image) && $items[0]->item_image != ''){
    echo '</div>';
} else if (isset($items[0]->item_image_svg) && $items[0]->item_image_svg != ''){
    echo '</div>';
} else if ($p['image_empty_space'] == 1){
    // Display empty space instead of image, in case e.g. the background image includes some part like image
    echo '<div class="phModParticlesItemImage'.$iC.'" '.$styleIcon.'></div>';
} else if ($p['main_video'] != '') {
    echo '</div>';
} else if ($p['main_video_file'] != '') {
    echo '</div>';
}


// OPEN CONTENT
if ($p['main_content'] != '') {
    echo '<div class="phModParticlesItemContent'.$cC.'">';
} else if (isset($items[0]->item_content) && $items[0]->item_content != '') {
    echo '<div class="phModParticlesItemContent' . $cC . '">';
}

if ($p['main_title'] != '') {
    echo '<div class="phModParticlesItemTitle">'.$p['main_title'].'</div>';
} else if (isset($items[0]->item_title) && $items[0]->item_title != '') {
    echo '<div class="phModParticlesItemTitle">'.$items[0]->item_title.'</div>';
}


if ($p['main_content'] != '') {
    echo HTMLHelper::_('content.prepare', $p['main_content']).'';
} else if (isset($items[0]->item_content) && $items[0]->item_content != '') {
    echo HTMLHelper::_('content.prepare', $items[0]->item_content) . '';
}

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
} else if (isset($items[0]->button_title) && $items[0]->button_title != '') {
    $buttonLink = '';
    if (isset($items[0]->button_link) && $items[0]->button_link != '') {
        $buttonLink = $items[0]->button_link;
    }

    $buttonAttr = '';
    if (isset($items[0]->button_attributes) && $items[0]->button_attributes != '') {
        $buttonAttr = $items[0]->button_attributes;
    }

    echo '<div class="phModParticlesButtonBox"><a class="phModParticlesButton" href="'.$buttonLink.'" '.$buttonAttr.'>'.$items[0]->button_title.'</a></div>';
}


// CLOSE CONTENT
if ($p['main_content'] != '') {
    echo '</div>';
} else if (isset($items[0]->item_content) && $items[0]->item_content != '') {
    echo '</div>';
}

echo '</div>'; //  end phModParticlesItem




echo '</div>'; // end phModParticlesImageContent


if ($p['main_bottom_code'] != '') {
    echo $p['main_bottom_code'];
}

if ($p['description_bottom'] != '') {
    echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
}



echo '</div>'; // end phModParticles


