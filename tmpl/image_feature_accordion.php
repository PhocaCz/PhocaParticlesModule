<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\FileLayout;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

$layoutFA = new FileLayout('phocaparticles.feature_accordion', JPATH_SITE . '/modules/mod_phocaparticles/layouts');
$layoutMI = new FileLayout('phocaparticles.image', JPATH_SITE . '/modules/mod_phocaparticles/layouts');
$layoutBTN = new FileLayout('phocaparticles.button', JPATH_SITE . '/modules/mod_phocaparticles/layouts');

echo '<div class="'.$class .'" id="'. $id .'">';

echo ($p['description_top'] != '') ? '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>' : '';
echo $p['main_top_code'] ?? '';
echo ($p['main_title'] != '') ? '<div class="phModParticlesItemTitle">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>' : '';
echo ($p['main_description'] != '') ? '<div class="phModParticlesItemDesc">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>' : '';

echo '<div class="phModParticlesImageFeatureAccordion">';

echo '<div class="phModParticlesItem'.$p['box_width_class'].$p['box_flex_class'].'">';

// MAIN IMAGE
echo $layoutMI->render(['items' => $items, 'params' => $p]);

// FEATURE ACCORDION
echo '<div class="phModParticlesItemFeatureAccordion' . $p['box_size_cc'] . '">';
echo $layoutFA->render(['items' => $items, 'params' => $p]);
echo $layoutBTN->render(['items' => $items, 'params' => $p]);
echo '</div>'; //  end phModParticlesItemFeatureBox


echo '</div>'; //  end phModParticlesItem

echo '</div>'; // end phModParticlesImageFeatureBox

echo $p['main_bottom_code'] ?? '';
echo ($p['description_bottom'] != '') ? '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>' : '';

echo '</div>'; // end phModParticles


