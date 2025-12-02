<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_random_image
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Module\PhocaParticles\Site\Helper;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;
use Joomla\String\StringHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Helper for mod_random_image
 *
 * @since  1.5
 */
class PhocaParticlesHelper
{
    public static function completeValueContent($value, $animationValue) {

        $outputValue = '';
        if ($animationValue != '') {

            switch($animationValue){

                // class="'.htmlspecialchars($animationValue).'" will be not as default in html, such will be added by javascript when scroll
                case 'phAnimLetters':
                    $outputValue = '<div class="'.htmlspecialchars($animationValue).'" data-ph-animation="phAnimLetters">'.strip_tags($value, '<br>').'</div>';
                break;

                case 'phAnimCounterNumber':
                    $outputValue = '<div class="'.htmlspecialchars($animationValue).'" data-ph-animation="phAnimCounterNumber" data-target="'.preg_replace('/[^0-9.]/', '', $value).'">'.preg_replace('/[^0-9.]/', '', $value).'</div>';
                break;

                case 'phAnimScrambleWord':
                    $outputValue = '<div class="'.htmlspecialchars($animationValue).'" data-ph-animation="phAnimScrambleWord" data-word="'.strip_tags($value, '<br>').'">'.strip_tags($value, '<br>').'</div>';
                break;


                default:
                    // We only add the animationValue as class, e.g. phAnimScaleInFade
                    $outputValue = '<div class="'.htmlspecialchars($animationValue).'" data-ph-animation="'.htmlspecialchars($animationValue).'">'.$value.'</div>';
                break;

            }

        } else {
            $outputValue = $value;
        }

        return $outputValue;
    }

    public static function completeValueAttribute($animationValue) {

        $outputValue = '';
        if ($animationValue != '') {

            switch($animationValue){



                case 'phAnimKenBurnsImg':
                case 'phAnimKenBurnsBg':
                    $outputValue = ' class="'.htmlspecialchars($animationValue).'" data-ph-animation="phAnimKenBurns"';
                break;

                case 'phAnimMoveIn':
                    $outputValue = ' class="'.htmlspecialchars($animationValue).'" data-ph-animation="phAnimMoveIn"';
                break;

                default:
                    // We only add the animationValue as class, e.g. phAnimScaleInFade
                    $outputValue = ' class="'.htmlspecialchars($animationValue).'" data-ph-animation="'.htmlspecialchars($animationValue).'"';
                break;

            }

        }

        return $outputValue;
    }

    public static function getTitleObject($item) {

        $o = [];
        $o['title'] = '';
        $o['alt'] = '';
        if (($item->item_title ?? '') !== '') {
            $o['title'] = $item->item_title;
            $o['alt'] = htmlspecialchars($o['title']);
        }

        return $o;
    }

    public static function getLinkObject($item, $params, $titleObject) {

        $o = [];
        $o['starticon'] = '';
		$o['starttitle'] = '';
		$o['end'] = '';
        $o['attribute'] = '';

        if (($item->item_link_attributes ?? '') !== '') {
            $o['attribute'] = ' '.$item->item_link_attributes;
        }
		if (($item->item_link ?? '') !== '') {
			$o['starticon'] = '<a href="'.htmlspecialchars($item->item_link).'"'.$params['style_icon'].$o['attribute'].' aria-label="'.$titleObject['alt'].'">';
			$o['starttitle'] = '<a href="'.htmlspecialchars($item->item_link).'"'.$params['style_title'].$o['attribute'].'>';
			$o['end'] = '</a>';
		}

        return $o;

    }

    public static function getTitleObjectMain($params) {

        $o = [];
        $o['title'] = '';
        $o['alt'] = '';
        if (($params['main_title'] ?? '') !== '') {
            $o['title'] = $params['main_title'];
            $o['alt'] = htmlspecialchars($o['title']);
        }

        return $o;
    }

    public static function getLinkObjectMain($params, $titleObject) {

        $o = [];
        $o['starticon'] = '';
		$o['starttitle'] = '';
		$o['end'] = '';
        $o['attribute'] = '';

        if (($params['main_link_attributes'] ?? '') !== '') {
            $o['attribute'] = ' '.$params['main_link_attributes'];
        }
		if (($params['main_link'] ?? '') !== '') {
			$o['starticon'] = '<a href="'.htmlspecialchars($params['main_link']).'"'.$params['style_icon'].$o['attribute'].' aria-label="'.$titleObject['alt'].'">';
			$o['starttitle'] = '<a href="'.htmlspecialchars($params['main_link']).'"'.$params['style_title'].$o['attribute'].'>';
			$o['end'] = '</a>';
		}

        return $o;

    }
}
