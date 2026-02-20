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
use Joomla\CMS\Uri\Uri;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

echo '<div class="'.$class .'" id="'. $id .'">';

echo ($p['description_top'] != '') ? '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>' : '';
echo $p['main_top_code'] ?? '';
echo ($p['main_title'] != '') ? '<div class="phModParticlesItemTitle phModParticlesItemTitleTop">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>' : '';
echo ($p['main_description'] != '') ? '<div class="phModParticlesItemDesc phModParticlesItemDescTop">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>' : '';

echo '<div class="phModParticlesImageGallery">';

if (!empty($items)) {
    foreach ($items as $k => $v) {
        $titleObject  = PhocaParticlesHelper::getTitleObject($v);
        $linkObject   = PhocaParticlesHelper::getLinkObject($v, $p, $titleObject);
        $boxItemClass = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';

        if (($v->item_image ?? '') === '') {
            continue;
        }

        $imageSrc = URI::base() . '/' . htmlspecialchars(strip_tags($v->item_image));

        echo '<div class="phModParticlesItem phModParticlesImageGalleryItem' . $boxItemClass . '">';

        echo '<div class="phModParticlesImageGalleryThumb" data-full-src="' . $imageSrc . '" data-index="' . $k . '">';
        echo '<img' . PhocaParticlesHelper::completeValueAttribute($p['item_image_animation']) . ' src="' . $imageSrc . '" alt="' . $titleObject['alt'] . '" loading="lazy" />';

        // Overlay with title/desc on hover
        if ($titleObject['title'] != '' || ($v->item_description ?? '') !== '') {
            echo '<div class="phModParticlesImageGalleryOverlay">';
            if ($titleObject['title'] != '') {
                echo '<div class="phModParticlesTitle" ' . $p['style_title'] . '>' . PhocaParticlesHelper::completeValueContent($titleObject['title'], $p['item_title_animation']) . '</div>';
            }
            if (($v->item_description ?? '') !== '') {
                echo '<div class="phModParticlesDesc">' . PhocaParticlesHelper::completeValueContent($v->item_description, $p['item_description_animation']) . '</div>';
            }
            echo '</div>';
        }

        echo '</div>'; // end thumb
        echo '</div>'; // end item
    }
}

echo '</div>'; // end gallery

// Lightbox overlay (hidden, JS-activated)
echo '<div class="phModParticlesImageGalleryLightbox" aria-hidden="true">';
echo '<button class="phModParticlesImageGalleryLightboxClose" aria-label="' . Text::_('MOD_PHOCAPARTICLES_CLOSE') . '">&times;</button>';
echo '<button class="phModParticlesImageGalleryLightboxPrev" aria-label="' . Text::_('MOD_PHOCAPARTICLES_PREVIOUS') . '">&lsaquo;</button>';
echo '<img class="phModParticlesImageGalleryLightboxImg" src="" alt="" />';
echo '<button class="phModParticlesImageGalleryLightboxNext" aria-label="' . Text::_('MOD_PHOCAPARTICLES_NEXT') . '">&rsaquo;</button>';
echo '</div>';

echo $p['main_bottom_code'] ?? '';
echo ($p['description_bottom'] != '') ? '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>' : '';

echo '</div>';
