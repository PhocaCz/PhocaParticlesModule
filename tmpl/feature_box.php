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
use Joomla\CMS\Uri\Uri;
use Joomla\Module\PhocaParticles\Site\Helper\PhocaParticlesHelper;

$layoutFB = new FileLayout('phocaparticles.feature_box', JPATH_SITE . '/modules/mod_phocaparticles/layouts');

if (!empty($items)) {
	echo '<div class="'.$class .'" id="'. $id .'">';

	if ($p['description_top'] != '') {
		echo '<div class="phModParticlesDescTop">'.HTMLHelper::_('content.prepare', $p['description_top']).'</div>';
	}

    if ($p['main_top_code'] != '') {
        echo $p['main_top_code'];
    }

    if ($p['main_title'] != '') {
        echo '<div class="phModParticlesItemTitle">' . PhocaParticlesHelper::completeValueContent($p['main_title'], $p['main_title_animation']) . '</div>';
    }

    if ($p['main_description'] != '') {
        echo '<div class="phModParticlesItemDesc">' . PhocaParticlesHelper::completeValueContent($p['main_description'], $p['main_description_animation']) . '</div>';
    }

	echo '<div class="phModParticlesFeatureBox">';

    $dF = [];
    $dF['items'] = $items;
    $dF['params'] = $p;
    echo $layoutFB->render($dF);


	echo '</div>';

    if ($p['main_bottom_code'] != '') {
        echo $p['main_bottom_code'];
    }

	if ($p['description_bottom'] != '') {
		echo '<div class="phModParticlesDescBottom">'.HTMLHelper::_('content.prepare', $p['description_bottom']).'</div>';
	}

	echo '</div>';
}

