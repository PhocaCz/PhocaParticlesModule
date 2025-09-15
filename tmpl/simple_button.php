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


echo '<div class="phModParticlesSimpleButton">';
echo '<div class="phModParticlesItem">';



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
} else if (isset($items[0]->button_title) && $items[0]->button_title != '') {
    $buttonLink = '';
    if (isset($items[0]->button_link) && $items[0]->button_link != '') {
        $buttonLink = $items[0]->button_link;
    }

    $buttonAttr = '';
    if (isset($items[0]->button_attributes) && $items[0]->button_attributes != '') {
        $buttonAttr = $items[0]->button_attributes;
    }

    echo '<div class="phModParticlesButtonBox"><a class="'.$p['button_css'] .' phModParticlesButton" href="'.$buttonLink.'" '.$buttonAttr.'>'.$items[0]->button_title.'</a></div>';
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

