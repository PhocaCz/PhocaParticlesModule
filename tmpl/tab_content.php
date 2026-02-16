<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Uri\Uri;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

echo '<div class="'.$class .'" id="'. $id .'">';

echo ($p['description_top'] != '') ? '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>' : '';
echo $p['main_top_code'] ?? '';
echo ($p['main_title'] != '') ? '<div class="phModParticlesItemTitle">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>' : '';
echo ($p['main_description'] != '') ? '<div class="phModParticlesItemDesc">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>' : '';

echo '<div class="phModParticlesTabContent">';

// Tab headers
echo '<div class="phModParticlesTabHeaders" role="tablist">';
if (!empty($items)) {
    foreach ($items as $k => $v) {
        $titleObject  = PhocaParticlesHelper::getTitleObject($v);
        $activeClass = ($k === 0) ? ' active' : '';
        $ariaSelected = ($k === 0) ? 'true' : 'false';

        echo '<button class="phModParticlesTabButton' . $activeClass . '" role="tab" aria-selected="' . $ariaSelected . '" data-tab-index="' . $k . '">';
        if (($v->item_icon_class ?? '') !== '') {
            echo '<i class="' . htmlspecialchars(strip_tags($v->item_icon_class)) . '"></i> ';
        }
        if ($titleObject['title'] != '') {
            echo '<span class="phModParticlesTitle" ' . $p['style_title'] . '>' . PhocaParticlesHelper::completeValueContent($titleObject['title'], $p['item_title_animation']) . '</span>';
        }
        echo '</button>';
    }
}
echo '</div>'; // end tab headers

// Tab panels
echo '<div class="phModParticlesTabPanels">';
if (!empty($items)) {
    foreach ($items as $k => $v) {
        $boxItemClass = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';
        $activeClass = ($k === 0) ? ' active' : '';

        echo '<div class="phModParticlesItem phModParticlesTabPanel' . $activeClass . $boxItemClass . '" role="tabpanel" data-tab-index="' . $k . '">';

        if (($v->item_description ?? '') !== '') {
            echo '<div class="phModParticlesDesc">' . PhocaParticlesHelper::completeValueContent($v->item_description, $p['item_description_animation']) . '</div>';
        }

        if (($v->item_content ?? '') !== '') {
            echo '<div class="phModParticlesContent">' . HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($v->item_content, $p['item_content_animation'])) . '</div>';
        }

        if (($v->item_image ?? '') !== '') {
            echo '<div class="phModParticlesImage"><img' . PhocaParticlesHelper::completeValueAttribute($p['item_image_animation']) . ' src="' . URI::base() . '/' . htmlspecialchars(strip_tags($v->item_image)) . '" alt="' . htmlspecialchars(strip_tags($v->item_title ?? '')) . '" /></div>';
        }

        echo '</div>'; // end panel
    }
}
echo '</div>'; // end panels

echo '</div>'; // end tab_content

echo $p['main_bottom_code'] ?? '';
echo ($p['description_bottom'] != '') ? '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>' : '';

echo '</div>';
