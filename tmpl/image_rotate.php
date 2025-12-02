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



echo '<div class="'.$class .'" id="'. $id .'">';

if ($p['description_top'] != '') {
    echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
}

if ($p['main_top_code'] != '') {
    echo $p['main_top_code'];
}

if ($p['main_title'] != '') {
    echo '<div class="phModParticlesItemTitle">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>';
}

if ($p['main_description'] != '') {
    echo '<div class="phModParticlesItemDesc">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>';
}

echo '<div class="phModParticlesImageRotate" data-loop="false">';

echo '<div class="phModParticlesImageRotateStage">';

echo '<div class="phModParticlesImageRotateTextOverlay">';
echo '<div class="phModParticlesImageRotateTextOverlayTitle"></div>';
echo '<div class="phModParticlesImageRotateTextOverlayDesc"></div>';
echo '</div>';

echo '<div class="phModParticlesImageRotateStack">';

if (!empty($items)) {
    foreach ($items as $k => $v) {

        $titleObject  = PhocaParticlesHelper::getTitleObject($v);
        $linkObject   = PhocaParticlesHelper::getLinkObject($v, $p, $titleObject);
        $boxItemClass = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';
        $titlePrefix  = (($v->item_title_prefix ?? '') !== '') ? '<span class="phModParticlesTitlePrefix">' . htmlspecialchars($v->item_title_prefix) . '</span>' : '';
        $titleSuffix  = (($v->item_title_suffix ?? '') !== '') ? '<span class="phModParticlesTitleSuffix">' . htmlspecialchars($v->item_title_suffix) . '</span>' : '';

        $dataTitle = $v->item_title ?? '' ? ' data-title="'.htmlspecialchars($v->item_title).'"' : '';
        $dataDescription = $v->item_title ?? ''  ? ' data-description="'.htmlspecialchars($v->item_description).'"' : '';
        $dataTitleSuffix = $v->item_title_suffix ?? '' ? ' data-title-suffix="'.htmlspecialchars($v->item_title_suffix).'"' : '';
        $dataClass = $v->item_class ?? '' ? ' data-class="'.htmlspecialchars($v->item_class).'"' : '';
        $dataTrack = ' data-track="'.($k + 1).'"';
        echo  '<img src="' . URI::base() . '/' . htmlspecialchars(strip_tags($v->item_image)) . '" class="phModParticlesImageRotateFrame" '.$dataTitle. $dataDescription.$dataTitleSuffix.$dataTrack.$dataClass.' alt="' . $titleObject['alt'] . '" />';
    }
}
echo '</div>'; // end phModParticlesImageRotateStack

echo '<div class="phModParticlesImageRotateTextOverlaySuffix">';
echo '<div class="phModParticlesImageRotateTextOverlayTitleSuffix"></div>';
echo '</div>';

echo '</div>'; // end phModParticlesImageRotateStage

echo '</div>'; //  end phModParticlesImageRotate


if ($p['main_bottom_code'] != '') {
    echo $p['main_bottom_code'];
}

if ($p['description_bottom'] != '') {
    echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
}


echo '</div>'; // end phModParticles

