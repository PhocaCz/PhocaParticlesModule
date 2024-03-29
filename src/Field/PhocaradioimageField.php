<?php

/**
 * Joomla! Content Management System
 *
 * @copyright  (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */



namespace Joomla\Module\PhocaParticles\Site\Field;

use Joomla\CMS\Form\Field\ListField;




// phpcs:disable PSR1.Files.SideEffects
\defined('JPATH_PLATFORM') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Form Field class for the Joomla Platform.
 * Provides radio button inputs
 *
 * @link   https://html.spec.whatwg.org/multipage/input.html#radio-button-state-(type=radio)
 * @since  1.7.0
 */
class PhocaradioimageField extends ListField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  1.7.0
     */


    protected $type = 'Phocaradioimage';


    /**
     * Name of the layout being used to render the field
     *
     * @var    string
     * @since  3.5
     */
    protected $layout = 'field.phocaradioimage';


    protected function getLayoutPaths()
    {


        $paths   = parent::getLayoutPaths();
        $paths[] = JPATH_SITE . '/modules/mod_phocaparticles/layouts';

        return $paths;
    }

    /**
     * Method to get the data to be passed to the layout for rendering.
     *
     * @return  array
     *
     * @since   3.5
     */
    protected function getLayoutData()
    {
        $data = parent::getLayoutData();




        $extraData = array(
            'options' => $this->getOptions(),
            'value'   => (string) $this->value,
        );

        return array_merge($data, $extraData);
    }
}
