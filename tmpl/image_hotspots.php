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

// Main Title/Desc outside the map
echo ($p['main_title'] != '') ? '<div class="phModParticlesItemTitle phModParticlesItemTitleTop">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>' : '';
echo ($p['main_description'] != '') ? '<div class="phModParticlesItemDesc phModParticlesItemDescTop">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>' : '';

echo '<div class="phModParticlesImageHotspots">';

// Render the Map Wrapper
echo '<div class="phModParticlesImageHotspotsMap">';

    // The Frame: Position Context + Clipping + Shrink Wrap choice
    // Hotspots are INSIDE this frame.
    echo '<div class="phModParticlesImageHotspotsFrame">';

        if (($p['main_image_svg'] ?? '') !== '') {
            // SVG Handling
            $svgContent = $p['main_image_svg'];
            if (strpos($svgContent, 'viewBox') === false) {
                preg_match('/width=["\']?(\d+)["\']?/', $svgContent, $matchesW);
                preg_match('/height=["\']?(\d+)["\']?/', $svgContent, $matchesH);
                if (!empty($matchesW[1]) && !empty($matchesH[1])) {
                    $svgContent = str_replace('<svg', '<svg viewBox="0 0 ' . $matchesW[1] . ' ' . $matchesH[1] . '"', $svgContent);
                }
            }
            echo '<div class="phModParticlesImageHotspotsMapSvg">' . $svgContent . '</div>';
        } elseif (($p['main_image'] ?? '') !== '') {
            echo '<img class="phModParticlesImageHotspotsMapImg" src="' . URI::base() . '/' . htmlspecialchars(strip_tags($p['main_image'])) . '" alt="" />';
        }

        // Hotspots (Now siblings of the IMG/SVG, inside the Frame)
        if (!empty($items)) {
            foreach ($items as $k => $v) {
                $titleObject  = PhocaParticlesHelper::getTitleObject($v);
                $linkObject   = PhocaParticlesHelper::getLinkObject($v, $p, $titleObject);
                $boxItemClass = (($v->item_class ?? '') !== '') ? ' ' . htmlspecialchars($v->item_class) : '';

                // Coordinates
                $top  = ($v->item_title_prefix !== '') ? htmlspecialchars($v->item_title_prefix) : '50%';
                $left = ($v->item_title_suffix !== '') ? htmlspecialchars($v->item_title_suffix) : '50%';

                if (is_numeric($top)) $top .= '%';
                if (is_numeric($left)) $left .= '%';

                echo '<div class="phModParticlesItem phModParticlesImageHotspot ' . $boxItemClass . '" style="top: ' . $top . '; left: ' . $left . ';" tabindex="0">';

                // The Dot
                echo '<div class="phModParticlesImageHotspotDot">';
                if (($v->item_icon_class ?? '') !== '') {
                    echo '<i class="' . htmlspecialchars(strip_tags($v->item_icon_class)) . '"></i>';
                } else {
                    echo '<span class="phModParticlesImageHotspotDotDefault"></span>';
                }
                echo '</div>';

                // The Tooltip
                echo '<div class="phModParticlesImageHotspotContent">';
                if (($v->item_image ?? '') !== '') {
                    echo '<div class="phModParticlesImage"><img' . PhocaParticlesHelper::completeValueAttribute($p['item_image_animation']) . ' src="' . URI::base() . '/' . htmlspecialchars(strip_tags($v->item_image)) . '" alt="' . $titleObject['alt'] . '" /></div>';
                }
                if ($titleObject['title'] != '') {
                     echo '<div class="phModParticlesTitle" ' . $p['style_title'] . '>' . $linkObject['starttitle'] . PhocaParticlesHelper::completeValueContent($titleObject['title'], $p['item_title_animation']) . $linkObject['end'] . '</div>';
                }
                if (($v->item_description ?? '') !== '') {
                    echo '<div class="phModParticlesDesc">' . PhocaParticlesHelper::completeValueContent($v->item_description, $p['item_description_animation']) . '</div>';
                } else if (isset($v->item_content) && $v->item_content != '') {
                    echo '<div class="phModParticlesContent">'. HTMLHelper::_('content.prepare', PhocaParticlesHelper::completeValueContent($v->item_content, $p['item_content_animation'])) . '</div>';
                }
                if (($v->button_title ?? '') !== '') {
                    $buttonLink = $v->button_link ?? '';
                    $buttonAttr = $v->button_attributes ?? '';
                    echo '<div class="phModParticlesButtonBox"><a class="' . $p['button_css'] . ' phModParticlesButton" href="' . $buttonLink . '" ' . $buttonAttr . '>' . $v->button_title . '</a></div>';
                }
                echo '</div>'; // End Tooltip
                echo '</div>'; // End Hotspot
            }
        } // End Items

    echo '</div>'; // End Frame

echo '</div>'; // End Map wrapper
echo '</div>'; // End ImageHotspots container

echo $p['main_bottom_code'] ?? '';
echo ($p['description_bottom'] != '') ? '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>' : '';

echo '</div>';
