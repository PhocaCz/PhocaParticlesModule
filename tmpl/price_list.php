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
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Uri\Uri;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

$layoutBTN = new FileLayout('phocaparticles.button', JPATH_SITE . '/modules/mod_phocaparticles/layouts');

echo '<div class="'.$class .'" id="'. $id .'">';

// Description Top
echo ($p['description_top'] != '') ? '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>' : '';
echo $p['main_top_code'] ?? '';

echo '<div class="phModParticlesPriceListContainer">';

// Main Title
echo ($p['main_title'] != '') ? '<div class="phModParticlesItemTitle">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>' : '';

// Main Description
echo ($p['main_description'] != '') ? '<div class="phModParticlesItemDesc">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>' : '';

// PRICE LIST START
echo '<div class="phModParticlesPriceList">';

if (!empty($items)) {
    foreach ($items as $v) {

        $titleObject  = PhocaParticlesHelper::getTitleObject($v);
        $linkObject   = PhocaParticlesHelper::getLinkObject($v, $p, $titleObject);
        $titlePrefix  = (($v->item_title_prefix ?? '') !== '') ? '<span class="pmpPriceListPrefix">' . htmlspecialchars($v->item_title_prefix) . '</span>' : '';
        $titleSuffix  = (($v->item_title_suffix ?? '') !== '') ? '<span class="pmpPriceListSuffix">' . htmlspecialchars($v->item_title_suffix) . '</span>' : '';

        echo '<div class="phModParticlesPriceListItem">';

        // Media (Icon, SVG, or Image)
        echo '<div class="pmpPriceListMedia">';
        if (($v->item_icon_class ?? '') !== '') {
            echo '<div class="phModParticlesIcon">' . $linkObject['starticon'] . '<i class="' . htmlspecialchars(strip_tags($v->item_icon_class)) . '"></i>' . $linkObject['end'] . '</div>';
        } else if (($v->item_image_svg ?? '') !== '') {
            echo '<div class="phModParticlesSvg">' . $linkObject['starticon'] . $v->item_image_svg . $linkObject['end'] . '</div>';
        } else if (($v->item_image ?? '') !== '') {
            echo '<div class="phModParticlesImage">' . $linkObject['starticon'] . '<img src="' . URI::base() . '/' . htmlspecialchars(strip_tags($v->item_image)) . '" alt="' . $titleObject['alt'] . '" />' . $linkObject['end'] . '</div>';
        }
        echo '</div>';

        // Title Group
        if ($titleObject['title'] != '') {
            echo $titlePrefix;
            echo '<div class="pmpPriceListTitle">' . $linkObject['starttitle'] . PhocaParticlesHelper::completeValueContent($titleObject['title'], $p['item_title_animation']) . $linkObject['end'] . '</div>';
        }

        // Dotted Leader
        echo '<div class="pmpPriceListLeader"></div>';

        // Suffix
        echo $titleSuffix;

        echo '</div>';
    }
}

echo '</div>';
// PRICE LIST END

// Main Content
if ($p['main_content'] != '') {
    echo '<div class="phModParticlesItemContentIn">'. HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($p['main_content'], $p['main_content_animation'])).'</div>';
}

// Button
echo $layoutBTN->render(['items' => $items, 'params' => $p]);

echo '</div>'; // end phModParticlesPriceListContainer

echo $p['main_bottom_code'] ?? '';

// Description Bottom
echo ($p['description_bottom'] != '') ? '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>' : '';

echo '</div>'; // end phModParticles
