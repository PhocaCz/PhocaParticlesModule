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

echo '<div class="phModParticlesMarquee">';
echo '<div class="phModParticlesMarqueeTrack">';

// Render items twice for seamless infinite loop
for ($loop = 0; $loop < 2; $loop++) {
    if (!empty($items)) {
        foreach ($items as $k => $v) {
            $titleObject  = PhocaParticlesHelper::getTitleObject($v);
            $linkObject   = PhocaParticlesHelper::getLinkObject($v, $p, $titleObject);
            $boxItemClass = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';

            echo '<div class="phModParticlesItem phModParticlesMarqueeItem' . $boxItemClass . '" aria-hidden="' . ($loop > 0 ? 'true' : 'false') . '">';

            if (($v->item_image ?? '') !== '') {
                echo '<div class="phModParticlesImage">' . $linkObject['starticon'] . '<img src="' . URI::base() . '/' . htmlspecialchars(strip_tags($v->item_image)) . '" alt="' . $titleObject['alt'] . '" />' . $linkObject['end'] . '</div>';
            } else if (isset($v->item_image_svg) && $v->item_image_svg != '') {
			    echo '<div class="phModParticlesSvg" '.$p['style_icon'].'>'. $linkObject['starticon'] .$v->item_image_svg. $linkObject['end'] .'</div>';
		    }

            if (($v->item_icon_class ?? '') !== '') {
                echo '<div class="phModParticlesIcon" ' . $p['style_icon'] . '>' . $linkObject['starticon'] . '<i class="' . htmlspecialchars(strip_tags($v->item_icon_class)) . '"></i>' . $linkObject['end'] . '</div>';
            }

            if ($titleObject['title'] != '') {
                echo '<div class="phModParticlesTitle" ' . $p['style_title'] . '>' . $linkObject['starttitle'] . PhocaParticlesHelper::completeValueContent($titleObject['title'], $p['item_title_animation']) . $linkObject['end'] . '</div>';
            }

            echo '</div>'; // end item
        }
    }
}

echo '</div>'; // end track
echo '</div>'; // end marquee

echo $p['main_bottom_code'] ?? '';
echo ($p['description_bottom'] != '') ? '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>' : '';

echo '</div>';
