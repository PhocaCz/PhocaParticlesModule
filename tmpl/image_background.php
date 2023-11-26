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
use Joomla\CMS\Uri\Uri;

$document = Factory::getDocument();


echo '<div class="'.$class .'" id="'. $id .'">';

if ($p['description_top'] != '') {
    echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
}

if ($p['main_top_code'] != '') {
    echo $p['main_top_code'];
}


$style      = array();
$styleIcon  = $p['icon_color'] != '' ? ' style="color: '.strip_tags($p['icon_color']).';"' : '';
$styleTitle = $p['title_color'] != '' ? ' style="color: '.strip_tags($p['title_color']).';"' : '';


echo '<div class="phModParticlesImageBackground">';
echo '<div class="phModParticlesItem">';

// LINK Local (item) or GLOBAL (main)
$linkStartIcon = '';
$linkStartTitle = '';
$linkEnd = '';
$linkAttr = '';


// TITLE Local (item) or GLOBAL (main)
$title = '';
$titleAlt= '';
if ($p['main_title'] != '') {
    $title = $p['main_title'];
    $titleAlt = htmlspecialchars($title);
} else if (isset($items[0]->item_title) && $items[0]->item_title != '') {
    $title = $items[0]->item_title;
    $titleAlt = htmlspecialchars($title);
}

if ($p['main_link'] != '') {
    if ($p['main_link_attributes'] != '') {
        $linkAttr = ' '.$p['main_link_attributes'];
    }

    $linkStartIcon = '<a href="'.htmlspecialchars($p['main_link']).'"'.$styleIcon.$linkAttr.' aria-label="'.$titleAlt.'">';
    $linkStartTitle = '<a href="'.htmlspecialchars($p['main_link']).'"'.$styleTitle.$linkAttr.'>';
    $linkEnd = '</a>';
} else if (isset($items[0]->item_link) && $items[0]->item_link != '') {
    if (isset($items[0]->item_link_attributes) && $items[0]->item_link_attributes != '') {
        $linkAttr = ' '.$items[0]->item_link_attributes;
    }

    $linkStartIcon = '<a href="'.htmlspecialchars($items[0]->item_link).'"'.$styleIcon.$linkAttr.' aria-label="'.$titleAlt.'">';
    $linkStartTitle = '<a href="'.htmlspecialchars($items[0]->item_link).'"'.$styleTitle.$linkAttr.'>';
    $linkEnd = '</a>';
}

// ICON/SVG Local (item) or GLOBAL (main)
if ($p['main_icon_class'] != '') {
    echo '<div class="phModParticlesIcon" '.$styleIcon.'>'. $linkStartIcon .'<i class="'.htmlspecialchars(strip_tags($p['main_icon_class'])).'"></i>'. $linkEnd .'</div>';
} else if ($p['main_image_svg'] != '') {
    echo '<div class="phModParticlesSvg" '.$styleIcon.'>'. $linkStartIcon .$p['main_image_svg']. $linkEnd .'</div>';
} else if (isset($items[0]->item_icon_class) && $items[0]->item_icon_class != '') {
    echo '<div class="phModParticlesIcon" '.$styleIcon.'>'. $linkStartIcon .'<i class="'.htmlspecialchars(strip_tags($items[0]->item_icon_class)).'"></i>'. $linkEnd .'</div>';
} else if (isset($items[0]->item_image_svg) && $items[0]->item_image_svg != '') {
    echo '<div class="phModParticlesSvg" '.$styleIcon.'>'. $linkStartIcon .$items[0]->item_image_svg. $linkEnd .'</div>';
}

// TITLE Local (item) or GLOBAL (main)
if ($p['main_title'] != '') {
    echo '<div class="phModParticlesTitle" '.$styleTitle.'>'. $linkStartTitle . $title. $linkEnd . '</div>';
} else if (isset($items[0]->item_title) && $items[0]->item_title != '') {
    echo '<div class="phModParticlesTitle" '.$styleTitle.'>'. $linkStartTitle . $title. $linkEnd . '</div>';
}

// IMAGE Local (item) or GLOBAL (main)
if ($p['main_image'] != '') {
    echo '<div class="phModParticlesImage" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.URI::base() . '/'.htmlspecialchars(strip_tags($p['main_image'])).'"/>'. $linkEnd .'</div>';
} else if (isset($items[0]->item_image) && $items[0]->item_image != '') {
    echo '<div class="phModParticlesImage" '.$styleIcon.'>'. $linkStartIcon .'<img src="'.URI::base() . '/'.htmlspecialchars(strip_tags($items[0]->item_image)).'"/>'. $linkEnd .'</div>';
}

// DESC Local (item) or GLOBAL (main)
if ($p['main_description'] != '') {
    echo '<div class="phModParticlesDesc">'.$p['main_description'].'</div>';
} else if (isset($items[0]->item_description) && $items[0]->item_description != '') {
    echo '<div class="phModParticlesDesc">'.$items[0]->item_description.'</div>';
}

// CONTENT Local (item) or GLOBAL (main)
if ($p['main_content'] != '') {
    echo '<div class="phModParticlesContent">'.HTMLHelper::_('content.prepare', $p['main_content']).'</div>';
} else if (isset($items[0]->item_content) && $items[0]->item_content != '') {
    echo '<div class="phModParticlesContent">'.HTMLHelper::_('content.prepare', $items[0]->item_content).'</div>';
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


echo '</div>';
echo '</div>';

if ($p['main_bottom_code'] != '') {
    echo $p['main_bottom_code'];
}

if ($p['description_bottom'] != '') {
    echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
}

echo '</div>';

