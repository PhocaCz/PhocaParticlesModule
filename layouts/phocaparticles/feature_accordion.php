<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

/** @var \Joomla\CMS\Layout\FileLayout $this */
/** @var array $displayData */
/** @var Joomla\Registry\Registry $params */

$d = $displayData;
$p = $d['params'];
$displayData = null;

$svgArrow = '<svg class="phModParticlesAccordionHeaderIcon" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>';

if (!empty($d['items'])) {
    foreach ($d['items'] as $k => $v) {

        $titleObject  = PhocaParticlesHelper::getTitleObject($v);
        $boxItemClass = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';
        $titlePrefix  = (($v->item_title_prefix ?? '') !== '') ? '<span class="phModParticlesTitlePrefix">' . htmlspecialchars($v->item_title_prefix) . '</span>' : '';
        $titleSuffix  = (($v->item_title_suffix ?? '') !== '') ? '<span class="phModParticlesTitleSuffix">' . htmlspecialchars($v->item_title_suffix) . '</span>' : '';

        echo '<div class="phModParticlesItem' . $boxItemClass . '">';


        echo '<div class="phModParticlesAccordion">';
        echo '<div class="phModParticlesAccordionItem">';

        echo '<div class="phModParticlesAccordionHeader" ' . $p['style_title'] . '>';
        if ($titleObject['title'] != '') {
            echo $titlePrefix . PhocaParticlesHelper::completeValueContent($titleObject['title'], $p['item_title_animation']) . $titleSuffix . $svgArrow ;
        }
        echo '</div>';

        echo '<div class="phModParticlesAccordionContent">';
        if (($v->item_description ?? '') !== '') {
            echo '<div class="phModParticlesDesc">' . PhocaParticlesHelper::completeValueContent($v->item_description, $p['item_description_animation']) . '</div>';
        }

         if (($v->item_content ?? '') !== '') {
            echo '<div class="phModParticlesContent">' . HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($v->item_content, $p['item_content_animation'])). '</div>';
        }

        if (($v->button_title ?? '') !== '') {

            $buttonLink = $v->button_link ?? '';
            $buttonAttr = $v->button_attributes ?? '';

            echo '<div class="phModParticlesButtonBox"><a class="' . $p['button_css'] . ' phModParticlesButton" href="' . $buttonLink . '" ' . $buttonAttr . '>' . $v->button_title . '</a></div>';
        }
        echo '</div>';// end phModParticlesAccordionContent

        echo '</div>';// end phModParticlesAccordionItem
        echo '</div>';// end phModParticlesAccordion

        echo '</div>';// phModParticlesItem

    }
}
