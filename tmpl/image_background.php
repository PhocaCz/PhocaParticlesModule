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
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Uri\Uri;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

$layoutBTN = new FileLayout('phocaparticles.button', JPATH_SITE . '/modules/mod_phocaparticles/layouts');



echo '<div class="'.$class .'" id="'. $id .'">';

if ($p['description_top'] != '') {
    echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
}

if ($p['main_top_code'] != '') {
    echo $p['main_top_code'];
}


echo '<div class="phModParticlesImageBackground">';
echo '<div class="phModParticlesItem">';


$titleObject    = PhocaParticlesHelper::getTitleObjectMain($p);
$linkObject     = PhocaParticlesHelper::getLinkObjectMain($p, $titleObject);

$titleObjectItem = !empty($items[0]) ? PhocaParticlesHelper::getTitleObject($items[0]) : ['title' => '', 'alt' => ''];
$linkObjectItem = !empty($items[0]) ? PhocaParticlesHelper::getLinkObject($items[0], $p, $titleObjectItem) : ['starticon' => '', 'starttitle' => '', 'end' => '', 'attribute' => ''];


// ICON/SVG Local (item) or GLOBAL (main)
if ($p['main_icon_class'] != '') {
    echo '<div class="phModParticlesIcon" '.$p['style_icon'].'>'. $linkObject['starticon'] .'<i class="'.htmlspecialchars(strip_tags($p['main_icon_class'])).'"></i>'. $linkObject['end'] .'</div>';
} else if ($p['main_image_svg'] != '') {
    echo '<div class="phModParticlesSvg" '.$p['style_icon'].'>'. $linkObject['starticon'] .$p['main_image_svg']. $linkObject['end'] .'</div>';
} else if (isset($items[0]->item_icon_class) && $items[0]->item_icon_class != '') {
    echo '<div class="phModParticlesIcon" '.$p['style_icon'].'>'. $linkObjectItem['starticon'] .'<i class="'.htmlspecialchars(strip_tags($items[0]->item_icon_class)).'"></i>'. $linkObjectItem['end'] .'</div>';
} else if (isset($items[0]->item_image_svg) && $items[0]->item_image_svg != '') {
    echo '<div class="phModParticlesSvg" '.$p['style_icon'].'>'. $linkObjectItem['starticon'] .$items[0]->item_image_svg. $linkObjectItem['end'] .'</div>';
}

// TITLE Local (item) or GLOBAL (main)
if ($p['main_title'] != '') {
    echo '<div class="phModParticlesTitle" '.$p['style_title'].'>'. $linkObject['starttitle'] . PhocaParticlesHelper::completeValueContent( $titleObject['title'], $p['main_title_animation']) . $linkObject['end'] . '</div>';
} else if (isset($items[0]->item_title) && $items[0]->item_title != '') {
    echo '<div class="phModParticlesTitle" '.$p['style_title'].'>'. $linkObjectItem['starttitle'] . PhocaParticlesHelper::completeValueContent( $titleObjectItem, $p['item_title_animation']) . $linkObjectItem['end'] . '</div>';
}

// IMAGE Local (item) or GLOBAL (main)
if ($p['main_image'] != '') {
    echo '<div class="phModParticlesImage" '.$p['style_icon'].'>'. $linkObject['starticon'] .'<img'.PhocaParticlesHelper::completeValueAttribute($p['main_image_animation'] ).' src="'.URI::base() . '/'.htmlspecialchars(strip_tags($p['main_image'])).'"/>'. $linkObject['end'] .'</div>';
} else if (isset($items[0]->item_image) && $items[0]->item_image != '') {
    echo '<div class="phModParticlesImage" '.$p['style_icon'].'>'. $linkObjectItem['starticon'] .'<img'.PhocaParticlesHelper::completeValueAttribute($p['item_image_animation'] ).' src="'.URI::base() . '/'.htmlspecialchars(strip_tags($items[0]->item_image)).'"/>'. $linkObjectItem['end'] .'</div>';
}

// DESC Local (item) or GLOBAL (main)
if ($p['main_description'] != '') {
    echo '<div class="phModParticlesDesc">'.PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']).'</div>';
} else if (isset($items[0]->item_description) && $items[0]->item_description != '') {
    echo '<div class="phModParticlesDesc">'.PhocaParticlesHelper::completeValueContent($items[0]->item_description, $p['item_description_animation']).'</div>';
}

// CONTENT Local (item) or GLOBAL (main)
if ($p['main_content'] != '') {
    echo '<div class="phModParticlesContent">'.HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($p['main_content'], $p['main_content_animation'])).'</div>';
} else if (isset($items[0]->item_content) && $items[0]->item_content != '') {
    echo '<div class="phModParticlesContent">'.HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($items[0]->item_content, $p['item_content_animation'])).'</div>';
}

// BUTTON Local (item) or GLOBAL (main)
$dB           = [];
$dB['items']     = $items;
$dB['params']   = $p;
$dB['alternative_items_button'] = 1;
echo $layoutBTN->render($dB);



echo '</div>';
echo '</div>';

if ($p['main_bottom_code'] != '') {
    echo $p['main_bottom_code'];
}

if ($p['description_bottom'] != '') {
    echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
}

echo '</div>';

