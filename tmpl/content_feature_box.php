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
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

$layoutFB = new FileLayout('phocaparticles.feature_box', JPATH_SITE . '/modules/mod_phocaparticles/layouts');
$layoutBTN = new FileLayout('phocaparticles.button', JPATH_SITE . '/modules/mod_phocaparticles/layouts');


echo '<div class="'.$class .'" id="'. $id .'">';

echo ($p['description_top'] != '') ? '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>' : '';
echo $p['main_top_code'] ?? '';
echo ($p['main_title'] != '') ? '<div class="phModParticlesItemTitle">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>' : '';
echo ($p['main_description'] != '') ? '<div class="phModParticlesItemDesc">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>' : '';

echo '<div class="phModParticlesContentFeatureBox">';

echo '<div class="phModParticlesItem'.$p['box_width_class'].$p['box_flex_class'].'">';

if ($p['content_feature_box_size'] != 7 && $p['content_feature_box_size'] != 8) {

    // MAIN CONTENT
    if ($p['main_content'] != '') {
        echo '<div class="phModParticlesItemContent'.$p['box_size_ic'].'">'
        . '<div class="phModParticlesItemContentIn">'. HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($p['main_content'], $p['main_content_animation'])).'</div>'
        . '</div>';
    }

    // FEATURE BOX
    echo '<div class="phModParticlesItemFeatureBox' . $p['box_size_cc'] . '">';
    echo $layoutFB->render(['items' => $items, 'params' => $p]);
    echo $layoutBTN->render(['items' => $items, 'params' => $p]);
    echo '</div>'; //  end phModParticlesItemFeatureBox

} else {

    // 2) Feature box is divided into two columns and the output is: half feature box column | image column | half feature box column
    //    There is no more general part with button as such will be duplicated in both columns
    $totalCount = count($items);
    $splitPoint = (int)ceil($totalCount / 2);
    $firstPart = array_slice($items, 0, $splitPoint, true);
    $secondPart = array_slice($items, $splitPoint, null, true);

    // Feture box divided
    echo '<div class="phModParticlesItemFeatureBox' . $p['box_size_cc'] . '">';
    echo $layoutFB->render(['items' => $firstPart, 'params' => $p]);
    echo '</div>'; //  end phModParticlesItemFeatureBox

    // CONTENT
    if ($p['main_content'] != '') {
        echo '<div class="phModParticlesItemContent' . $p['box_size_ic'] . '">'
        . '<div class="phModParticlesItemContentIn">' . HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($p['main_content'], $p['main_content_animation'])) . '</div>'
        . '</div>';
    }

    // Feature box divided
    echo '<div class="phModParticlesItemFeatureBox' . $p['box_size_cc'] . '">';
    echo $layoutFB->render(['items' => $secondPart, 'params' => $p]);
    echo '</div>'; //  end phModParticlesItemFeatureBox
}

echo '</div>'; //  end phModParticlesItem

echo '</div>'; // end phModParticlesContentFeatureBox

echo $p['main_bottom_code'] ?? '';
echo ($p['description_bottom'] != '') ? '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>' : '';

echo '</div>'; // end phModParticles


