<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

use Joomla\CMS\Uri\Uri;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

/** @var \Joomla\CMS\Layout\FileLayout $this */
/** @var array $displayData */
/** @var Joomla\Registry\Registry $params */

$d = $displayData;
$p = $d['params'];
$displayData = null;

if (!empty($d['items'])) {
    foreach ($d['items'] as $k => $v) {

        $titleObject  = PhocaParticlesHelper::getTitleObject($v);
        $linkObject   = PhocaParticlesHelper::getLinkObject($v, $p, $titleObject);
        $boxItemClass = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';
        $titlePrefix  = (($v->item_title_prefix ?? '') !== '') ? '<span class="phModParticlesTitlePrefix">' . htmlspecialchars($v->item_title_prefix) . '</span>' : '';
        $titleSuffix  = (($v->item_title_suffix ?? '') !== '') ? '<span class="phModParticlesTitleSuffix">' . htmlspecialchars($v->item_title_suffix) . '</span>' : '';

        echo '<div class="phModParticlesItem' . $boxItemClass . '">';

        echo '<div class="phModParticlesIconBox">';

        if (($v->item_icon_class ?? '') !== '') {
            echo '<div class="phModParticlesIcon" ' . $p['style_icon'] . '>' . $linkObject['starticon'] . '<i class="' . htmlspecialchars(strip_tags($v->item_icon_class)) . '"></i>' . $linkObject['end'] . '</div>';
        } else if (($v->item_image_svg ?? '') !== '') {
            echo  '<div class="phModParticlesSvg" ' . $p['style_icon'] . '>' . $linkObject['starticon'] . $v->item_image_svg . $linkObject['end'] . '</div>';
        } else if (($v->item_image ?? '') !== '') {
            echo '<div class="phModParticlesImage" ' . $p['style_icon'] . '>' . $linkObject['starticon'] . '<img' . PhocaParticlesHelper::completeValueAttribute($p['item_image_animation']) . ' src="' . URI::base() . '/' . htmlspecialchars(strip_tags($v->item_image)) . '" alt="' . $titleObject['alt'] . '" />' . $linkObject['end'] . '</div>';
        }

        echo '</div>';
        echo '<div class="phModParticlesDescBox">';

        if ($titleObject['title'] != '') {
            echo '<div class="phModParticlesTitle" ' . $p['style_title'] . '>' . $linkObject['starttitle'] . $titlePrefix . PhocaParticlesHelper::completeValueContent($titleObject['title'], $p['item_title_animation']) . $titleSuffix . $linkObject['end'] . '</div>';
        }

        if (($v->item_description ?? '') !== '') {
            echo '<div class="phModParticlesDesc">' . PhocaParticlesHelper::completeValueContent($v->item_description, $p['item_description_animation']) . '</div>';
        }

        if (($v->button_title ?? '') !== '') {

            $buttonLink = $v->button_link ?? '';
            $buttonAttr = $v->button_attributes ?? '';

            echo '<div class="phModParticlesButtonBox"><a class="' . $p['button_css'] . ' phModParticlesButton" href="' . $buttonLink . '" ' . $buttonAttr . '>' . $v->button_title . '</a></div>';
        }

        echo '</div>';
        echo '</div>';

    }
}
