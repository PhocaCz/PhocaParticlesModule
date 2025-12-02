<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

/** @var \Joomla\CMS\Layout\FileLayout $this */
/** @var array $displayData */
/** @var Joomla\Registry\Registry $params */

$d 					= $displayData;
$p                  = $d['params'];
$displayData 		= null;

$titleObject    = PhocaParticlesHelper::getTitleObjectMain($p);
$linkObject     = PhocaParticlesHelper::getLinkObjectMain($p, $titleObject);

// OPEN IMAGE BOX
echo '<div class="phModParticlesItemImage' . $p['box_size_ic'] . '" ' . $p['style_icon'] . '>';

if ($p['main_image'] != '') {
    echo $linkObject['starticon'] .'<img'.PhocaParticlesHelper::completeValueAttribute($p['main_image_animation'] ).' src="'.URI::base() . '/'.htmlspecialchars(strip_tags($p['main_image'])).'" alt="'.$titleObject['alt'].'" />'. $linkObject['end'];
} else if ($p['main_image_svg'] != '') {
    echo '<div class="phModParticlesSvg">'. $linkObject['starticon'] .$p['main_image_svg']. $linkObject['end'] .'</div>';
}  else if ($p['image_empty_space'] == 1){
    // Display empty space instead of image, in case e.g. the background image includes some part like image
    //echo '<div class="phModParticlesItemImage'.$p['box_size_ic'].'" '.$p['style_icon'].'>';
} else if (isset($d['items'][0]->item_image) && $d['items'][0]->item_image != ''){
    echo  $linkObject['starticon'] .'<img src="'.URI::base() . '/'.htmlspecialchars(strip_tags($d['items'][0]->item_image)).'" alt="'.$titleObject['alt'].'" />'. $linkObject['end'] .'';
} else if (isset($d['items'][0]->item_image_svg) && $d['items'][0]->item_image_svg != ''){
    echo  $linkObject['starticon'] .$d['items'][0]->item_image_svg. $linkObject['end'] .'';
} else if ($p['main_video'] != '') {
    echo '<div class="phModParticlesVideoBox"><iframe width="'.htmlspecialchars(strip_tags($p['main_video_width'])).'" height="'.htmlspecialchars(strip_tags($p['main_video_height'])).'" src="//www.youtube.com/embed/'.htmlspecialchars(strip_tags($p['main_video'])).'" frameborder="0" allowfullscreen></iframe></div>';
} else if ($p['main_video_file']!= '') {

    $poster = '';
    if ($p['main_video_file_thumbnail'] != '') {
        $poster = 'poster="'.URI::base() . '/'.htmlspecialchars(strip_tags($p['main_video_file_thumbnail'])).'"';
    }

    echo '<div class="phModParticlesVideoBox"><video width="'.htmlspecialchars(strip_tags($p['main_video_width'])).'" height="'.htmlspecialchars(strip_tags($p['main_video_height'])).'" controls loading="lazy"'.$poster.'>';
    echo '<source src="'.URI::base() . '/'.htmlspecialchars(strip_tags($p['main_video_file'])).'" type="video/mp4" controls>';
    echo Text::_('MOD_PHOCAPARTICLES_YOUR_BROWSWER_DOES_NOT_SUPPORT_VIDEO_TAG');
    echo '</video></div>';
}


if ($p['main_label'] != '') {
    echo '<div class="phModParticlesItemLabel">'.$p['main_label'].'</div>';
}
if ($p['main_price_original'] != '') {
    echo '<div class="phModParticlesItemPriceOriginal">'.$p['main_price_original'].'</div>';
}
if ($p['main_price'] != '') {
    echo '<div class="phModParticlesItemPrice">'.$p['main_price'].'</div>';
}



// CLOSE IMAGE BLOCK
if ($p['main_image'] != '') {
    echo '</div>';
} else if ($p['main_image_svg'] != ''){
    echo '</div>';
} else if ($p['image_empty_space'] == 1){
    // Display empty space instead of image, in case e.g. the background image includes some part like image
    echo '</div>';
} else if (isset($d['items'][0]->item_image) && $d['items'][0]->item_image != ''){
    echo '</div>';
} else if (isset($d['items'][0]->item_image_svg) && $d['items'][0]->item_image_svg != ''){
    echo '</div>';
} else if ($p['main_video'] != '') {
    echo '</div>';
} else if ($p['main_video_file'] != '') {
    echo '</div>';
} else {
    echo '</div>';
}
