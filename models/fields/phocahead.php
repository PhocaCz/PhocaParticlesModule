<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('JPATH_BASE') or die;
jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldPhocaHead extends JFormField
{
	protected $type = 'PhocaHead';
	protected function getLabel() { return '';}

	protected function getInput() {

		JHTML::stylesheet( 'media/mod_phocaparticles/css/options.css' );
		echo '<div style="clear:both;"></div>';
		$phocaImage	= ( (string)$this->element['phocaimage'] ? $this->element['phocaimage'] : '' );
		$image 		= '';

		if ($phocaImage != ''){
			$image 	= Joomla\CMS\HTML\HTMLHelper::_('image', 'media/mod_phocaparticles/images/' . $phocaImage, '' );
		}

		if ($this->element['default']) {
			if ($image != '') {
				return '<div class="ph-options-head">'
				.'<div>'. $image.' <strong>'. JText::_($this->element['default']) . '</strong></div>'
				.'</div>';
			} else {
				return '<div class="ph-options-head">'
				.'<strong>'. JText::_($this->element['default']) . '</strong>'
				.'</div>';
			}
		} else {
			return parent::getLabel();
		}
		echo '<div style="clear:both;"></div>';
	}
}
?>
