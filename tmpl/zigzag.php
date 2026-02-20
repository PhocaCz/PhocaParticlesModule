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

$layoutBTN = new FileLayout('phocaparticles.button', JPATH_SITE . '/modules/mod_phocaparticles/layouts');

echo '<div class="'.$class .'" id="'. $id .'">';

echo ($p['description_top'] != '') ? '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>' : '';
echo $p['main_top_code'] ?? '';
echo ($p['main_title'] != '') ? '<div class="phModParticlesItemTitle phModParticlesItemTitleTop">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>' : '';
echo ($p['main_description'] != '') ? '<div class="phModParticlesItemDesc phModParticlesItemDescTop">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>' : '';

echo '<div class="phModParticlesZigzag">';

if (!empty($items)) {
    foreach ($items as $k => $v) {
        $titleObject  = PhocaParticlesHelper::getTitleObject($v);
        $linkObject   = PhocaParticlesHelper::getLinkObject($v, $p, $titleObject);
        $boxItemClass = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';
        $reverseClass = ($k % 2 !== 0) ? ' pmpReverse' : '';

        echo '<div class="phModParticlesItem phModParticlesZigzagRow' . $reverseClass . $boxItemClass . '">';

        // Image side
        if (($v->item_image ?? '') !== '') {
            echo '<div class="phModParticlesZigzagImage">';
            echo $linkObject['starticon'] . '<img' . PhocaParticlesHelper::completeValueAttribute($p['item_image_animation']) . ' src="' . URI::base() . '/' . htmlspecialchars(strip_tags($v->item_image)) . '" alt="' . $titleObject['alt'] . '" />' . $linkObject['end'];
            echo '</div>';
        }  else if (isset($v->item_image_svg) && $v->item_image_svg != '') {
            echo '<div class="phModParticlesZigZagSvg" '.$p['style_icon'].'>'. $linkObject['starticon'] .$v->item_image_svg. $linkObject['end'] .'</div>';
        }

        // Content side
        echo '<div class="phModParticlesZigzagContent">';

        if ($titleObject['title'] != '') {
            echo '<div class="phModParticlesTitle" ' . $p['style_title'] . '>' . $linkObject['starttitle'] . PhocaParticlesHelper::completeValueContent($titleObject['title'], $p['item_title_animation']) . $linkObject['end'] . '</div>';
        }

        if (($v->item_description ?? '') !== '') {
            echo '<div class="phModParticlesDesc">' . PhocaParticlesHelper::completeValueContent($v->item_description, $p['item_description_animation']) . '</div>';
        }

        if (($v->item_content ?? '') !== '') {
            echo '<div class="phModParticlesContent">' . HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($v->item_content, $p['item_content_animation'])) . '</div>';
        }

        if (($v->button_title ?? '') !== '') {
            $buttonLink = $v->button_link ?? '';
            $buttonAttr = $v->button_attributes ?? '';
            echo '<div class="phModParticlesButtonBox"><a class="' . $p['button_css'] . ' phModParticlesButton" href="' . $buttonLink . '" ' . $buttonAttr . '>' . $v->button_title . '</a></div>';
        }

        echo '</div>'; // end content
        echo '</div>'; // end row
    }
}

echo '</div>'; // end zigzag

echo $p['main_bottom_code'] ?? '';
echo ($p['description_bottom'] != '') ? '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>' : '';

echo '</div>';
