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

// BUTTON Local (item) or GLOBAL (main)
if ($p['main_button_title']  != '') {

    $buttonLink = $p['main_button_link'] ?? '';
    $buttonAttr = $p['main_button_attributes'] ?? '';

    //echo '<div class="phModParticlesIconBox"></div>';
    //echo '<div class="phModParticlesDescBox">';
    echo '<div class="phModParticlesButtonBox"><a class="'.$p['button_css'] .' phModParticlesButton" href="'.$buttonLink.'" '.$buttonAttr.'>'.$p['main_button_title'].'</a></div>';
    //echo '</div>'; // end phModParticlesDescBox

} else if (isset($d['alternative_items_button']) && $d['alternative_items_button'] == 1 &&  isset($d['items'][0]->button_title) && $d['items'][0]->button_title != '') {


    $buttonLink = $d['items'][0]->button_link ?? '';
    $buttonAttr = $d['items'][0]->button_attributes ?? '';

    //echo '<div class="phModParticlesIconBox"></div>';
    //echo '<div class="phModParticlesDescBox">';
    echo '<div class="phModParticlesButtonBox"><a class="'.$p['button_css'] .' phModParticlesButton" href="'.$buttonLink.'" '.$buttonAttr.'>'.$d['items'][0]->button_title.'</a></div>';
    //echo '</div>'; // end phModParticlesDescBox
}
