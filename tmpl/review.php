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

echo '<div class="'.$class .'" id="'. $id .'">';

echo ($p['description_top'] != '') ? '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>' : '';
echo $p['main_top_code'] ?? '';
echo ($p['main_title'] != '') ? '<div class="phModParticlesItemTitle phModParticlesItemTitleTop">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>' : '';
echo ($p['main_description'] != '') ? '<div class="phModParticlesItemDesc phModParticlesItemDescTop">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>' : '';

echo '<div class="phModParticlesReviewRow">';

if (!empty($items)) {
    foreach ($items as $k => $v) {
        $titleObject  = PhocaParticlesHelper::getTitleObject($v);
        $linkObject   = PhocaParticlesHelper::getLinkObject($v, $p, $titleObject);
        $boxItemClass = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';

        echo '<div class="phModParticlesItem phModParticlesReviewItem' . $boxItemClass . '">';
        echo '<div class="phModParticlesReviewCard">'; // Inner card container

        // Stars Logic
        $rating = (int) ($v->item_title_prefix ?? 0);
        $rating = max(0, min(5, $rating)); // Clamp between 0 and 5
        $starsHtml = '';
        if ($rating > 0) {
            $starsHtml = '<div class="phModParticlesReviewStars" aria-label="' . Text::sprintf('MOD_PHOCAPARTICLES_RATING_X_OF_5', $rating) . '">';
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rating) {
                    $starsHtml .= '<span class="ph-star-full">★</span>';
                } else {
                    $starsHtml .= '<span class="ph-star-empty">☆</span>';
                }
            }
            $starsHtml .= '</div>';
        }

        // Image (Avatar)
        if (($v->item_image ?? '') !== '') {
            echo '<div class="phModParticlesImage">' . $linkObject['starticon'] . '<img' . PhocaParticlesHelper::completeValueAttribute($p['item_image_animation']) . ' src="' . URI::base() . '/' . htmlspecialchars(strip_tags($v->item_image)) . '" alt="' . $titleObject['alt'] . '" />' . $linkObject['end'] . '</div>';
        }

        // Description (Quote) - Displayed prominently
        if (($v->item_description ?? '') !== '') {
            echo '<div class="phModParticlesDesc phModParticlesReviewQuote">' . PhocaParticlesHelper::completeValueContent($v->item_description, $p['item_description_animation']) . '</div>';
        }

        // Stars
        echo $starsHtml;

        // Title (Name)
        if ($titleObject['title'] != '') {
            echo '<div class="phModParticlesTitle phModParticlesReviewName" ' . $p['style_title'] . '>' . $linkObject['starttitle'] . PhocaParticlesHelper::completeValueContent($titleObject['title'], $p['item_title_animation']) . $linkObject['end'] . '</div>';
        }

        // Suffix (Role/Company - optional usage of existing field if needed, but not strictly requested as "Role" field, user said 1-5 is prefix. We can use Suffix for Role if available, or just ignore.)
        // User requirements: title=Name, prefix=Stars, desc=Quote. keeping it minimal.

        if (($v->button_title ?? '') !== '') {
            $buttonLink = $v->button_link ?? '';
            $buttonAttr = $v->button_attributes ?? '';
            echo '<div class="phModParticlesButtonBox"><a class="' . $p['button_css'] . ' phModParticlesButton" href="' . $buttonLink . '" ' . $buttonAttr . '>' . $v->button_title . '</a></div>';
        }

        echo '</div>'; // End card
        echo '</div>'; // End Item
    }
}

echo '</div>'; // End Row

echo $p['main_bottom_code'] ?? '';
echo ($p['description_bottom'] != '') ? '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>' : '';

echo '</div>';
