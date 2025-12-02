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
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Uri\Uri;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

$layoutMI = new FileLayout('phocaparticles.image', JPATH_SITE . '/modules/mod_phocaparticles/layouts');
$layoutBTN = new FileLayout('phocaparticles.button', JPATH_SITE . '/modules/mod_phocaparticles/layouts');


echo '<div class="'.$class .'" id="'. $id .'">';

if ($p['description_top'] != '') {
    echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
}

if ($p['main_top_code'] != '') {
    echo $p['main_top_code'];
}

if ($p['main_background_image_animation']) {
    echo '<div class="phModParticlesImageContent '.htmlspecialchars($p['main_background_image_animation']).'">';
} else {
    echo '<div class="phModParticlesImageContent">';
}

echo '<div class="phModParticlesItem'.$p['box_width_class'].$p['box_flex_class'].'">';

// MAIN IMAGE - start is a part of layout
$dI           = [];
$dI['items']     = $items;
$dI['params'] = $p;
echo $layoutMI->render($dI);
// end is a part of layout



// OPEN CONTENT
echo '<div class="phModParticlesItemContent'.$p['box_size_cc'].'">';


if ($p['main_title'] != '') {
    echo '<div class="phModParticlesItemTitle">'.PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']).'</div>';
} else if (isset($items[0]->item_title) && $items[0]->item_title != '') {
    echo '<div class="phModParticlesItemTitle">'.PhocaParticlesHelper::completeValueContent($items[0]->item_title, $p['item_title_animation']).'</div>';
}

if ($p['main_description'] != '') {
    echo '<div class="phModParticlesItemDesc">'.PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']).'</div>';
} else if (isset($items[0]->item_title) && $items[0]->item_title != '') {
    echo '<div class="phModParticlesItemDesc">'.PhocaParticlesHelper::completeValueContent($items[0]->item_description, $p['item_description_animation']).'</div>';
}


if ($p['main_content'] != '') {
    echo '<div class="phModParticlesItemContentIn">'. HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($p['main_content'], $p['main_content_animation'])).'</div>';
} else if (isset($items[0]->item_content) && $items[0]->item_content != '') {
    echo '<div class="phModParticlesItemContentIn">'. HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($items[0]->item_content, $p['item_content_animation'])) . '</div>';
}

$dB           = [];
$dB['items']     = $items;
$dB['params'] = $p;
$dB['alternative_items_button'] = 1;
echo $layoutBTN->render($dB);


// CLOSE CONTENT
echo '</div>';

echo '</div>'; //  end phModParticlesItem

echo '</div>'; // end phModParticlesImageContent


if ($p['main_bottom_code'] != '') {
    echo $p['main_bottom_code'];
}

if ($p['description_bottom'] != '') {
    echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
}


echo '</div>'; // end phModParticles


