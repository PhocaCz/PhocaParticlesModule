<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

echo '<div class="'.$class .'" id="'. $id .'">';

echo ($p['description_top'] != '') ? '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>' : '';
echo $p['main_top_code'] ?? '';
echo ($p['main_title'] != '') ? '<div class="phModParticlesItemTitle">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>' : '';
echo ($p['main_description'] != '') ? '<div class="phModParticlesItemDesc">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>' : '';

echo '<div class="phModParticlesSteps">';

if (!empty($items)) {
    $totalItems = count($items);
    foreach ($items as $k => $v) {
        $titleObject  = PhocaParticlesHelper::getTitleObject($v);
        $linkObject   = PhocaParticlesHelper::getLinkObject($v, $p, $titleObject);
        $boxItemClass = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';
        $stepNumber   = (($v->item_title_prefix ?? '') !== '') ? htmlspecialchars($v->item_title_prefix) : ($k + 1);

        echo '<div class="phModParticlesItem phModParticlesStepsItem' . $boxItemClass . '">';

        // Connector line (not on last item)
        if ($k < $totalItems - 1) {
            echo '<div class="phModParticlesStepsConnector"></div>';
        }

        echo '<div class="phModParticlesStepsMarker">';
        if (($v->item_icon_class ?? '') !== '') {
            echo '<i class="' . htmlspecialchars(strip_tags($v->item_icon_class)) . '"></i>';
        } else if (isset($v->item_image_svg) && $v->item_image_svg != '') {
			echo '<div class="phModParticlesSvg" '.$p['style_icon'].'>'. $linkObject['starticon'] .$v->item_image_svg. $linkObject['end'] .'</div>';
		} else {
            echo '<span>' . $stepNumber . '</span>';
        }
        echo '</div>';

        if ($titleObject['title'] != '') {
            echo '<div class="phModParticlesTitle" ' . $p['style_title'] . '>' . $linkObject['starttitle'] . PhocaParticlesHelper::completeValueContent($titleObject['title'], $p['item_title_animation']) . $linkObject['end'] . '</div>';
        }

        if (($v->item_description ?? '') !== '') {
            echo '<div class="phModParticlesDesc">' . PhocaParticlesHelper::completeValueContent($v->item_description, $p['item_description_animation']) . '</div>';
        }  else if (isset($v->item_content) && $v->item_content != '') {
            echo '<div class="phModParticlesContent">'. HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($v->item_content, $p['item_content_animation'])) . '</div>';
        }

        echo '</div>'; // end step item
    }
}

echo '</div>'; // end steps

echo $p['main_bottom_code'] ?? '';
echo ($p['description_bottom'] != '') ? '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>' : '';

echo '</div>';
