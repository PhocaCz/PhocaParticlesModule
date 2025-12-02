<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Form\Field\TextField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;

jimport('joomla.html.html');
jimport('joomla.form.formfield');



class JFormFieldPhocaCombobox extends TextField
{
    protected $type = 'PhocaCombobox';
    protected $layout = 'joomla.form.field.text';

    protected function getInput()
    {
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
        $wa->registerAndUseStyle(
            'phoca.combobox',
            'media/mod_phocaparticles/css/combobox.css',
            [],
            ['version' => 'auto']
        );


        // Set list attribute correctly
        $this->element['list'] = $this->id . '-datalist';

        $inputHtml = parent::getInput();

        $datalistId = $this->id . '-datalist';
        $options = [];

        foreach ($this->element->children() as $option) {
            if ($option->getName() === 'option') {
                $options[] = (string) $option['value'];
            }
        }

        $datalistHtml = '<datalist id="' . htmlspecialchars($datalistId) . '">';
        foreach ($options as $value) {
            $datalistHtml .= '<option value="' . htmlspecialchars($value) . '"></option>';
        }
        $datalistHtml .= '</datalist>';

        return $inputHtml . "\n" . $datalistHtml;
    }
}
