<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Uri\Uri;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

$layoutBTN = new FileLayout('phocaparticles.button', JPATH_SITE . '/modules/mod_phocaparticles/layouts');

echo '<div class="'.$class .'" id="'. $id .'">';

echo ($p['description_top'] != '') ? '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>' : '';
echo $p['main_top_code'] ?? '';
echo ($p['main_title'] != '') ? '<div class="phModParticlesItemTitle phModParticlesItemTitleTop">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>' : '';
echo ($p['main_description'] != '') ? '<div class="phModParticlesItemDesc phModParticlesItemDescTop">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>' : '';

echo '<div class="phModParticlesSlideshow">';
echo '<div class="phModParticlesSlideshowTrack">';

if (!empty($items)) {
    foreach ($items as $k => $v) {
        $titleObject  = PhocaParticlesHelper::getTitleObject($v);
        $linkObject   = PhocaParticlesHelper::getLinkObject($v, $p, $titleObject);
        $boxItemClass = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';

        echo '<div class="phModParticlesItem phModParticlesSlideshowSlide' . $boxItemClass . '">';

        if (($v->item_image ?? '') !== '') {
            echo '<div class="phModParticlesImage">' . $linkObject['starticon'] . '<img' . PhocaParticlesHelper::completeValueAttribute($p['item_image_animation']) . ' src="' . URI::base() . '/' . htmlspecialchars(strip_tags($v->item_image)) . '" alt="' . $titleObject['alt'] . '" />' . $linkObject['end'] . '</div>';
        } else if (isset($v->item_image_svg) && $v->item_image_svg != '') {
			echo '<div class="phModParticlesSvg" '.$p['style_icon'].'>'. $linkObject['starticon'] .$v->item_image_svg. $linkObject['end'] .'</div>';
		}

        if ($titleObject['title'] != '' || ($v->item_description ?? '') !== '') {
            echo '<div class="phModParticlesSlideshowCaption">';
            if ($titleObject['title'] != '') {
                echo '<div class="phModParticlesTitle" ' . $p['style_title'] . '>' . $linkObject['starttitle'] . PhocaParticlesHelper::completeValueContent($titleObject['title'], $p['item_title_animation']) . $linkObject['end'] . '</div>';
            }
            if (($v->item_description ?? '') !== '') {
                echo '<div class="phModParticlesDesc">' . PhocaParticlesHelper::completeValueContent($v->item_description, $p['item_description_animation']) . '</div>';
            } else if (isset($v->item_content) && $v->item_content != '') {
                echo '<div class="phModParticlesContent">'. HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($v->item_content, $p['item_content_animation'])) . '</div>';
            }
            echo '</div>';
        }

        echo '</div>'; // end slide
    }
}

echo '</div>'; // end track
echo '<button class="phModParticlesSlideshowPrev" aria-label="' . Text::_('MOD_PHOCAPARTICLES_PREVIOUS') . '">&#10094;</button>';
echo '<button class="phModParticlesSlideshowNext" aria-label="' . Text::_('MOD_PHOCAPARTICLES_NEXT') . '">&#10095;</button>';
echo '<div class="phModParticlesSlideshowDots">';
if (!empty($items)) {
    foreach ($items as $k => $v) {
        echo '<span class="phModParticlesSlideshowDot' . ($k === 0 ? ' active' : '') . '" data-index="' . $k . '"></span>';
    }
}
echo '</div>';
echo '</div>'; // end slideshow

// BUTTON
$dB           = [];
$dB['items']     = $items;
$dB['params']   = $p;
$dB['alternative_items_button'] = 1;
echo $layoutBTN->render($dB);

echo $p['main_bottom_code'] ?? '';
echo ($p['description_bottom'] != '') ? '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>' : '';

echo '</div>';
