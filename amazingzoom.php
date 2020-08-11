<?php
/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once 'classes/Data/Config.php';
//require_once 'classes/Data/ModuleDisplay.php';
require_once 'classes/AmazingZoomUninstall.php';
require_once 'classes/AmazingZoomInstall.php';
require_once 'classes/Model/AmazingZoomClass.php';

class Amazingzoom extends Module
{
    protected $config_form = false;
    private $path;

    public function __construct()
    {
        $this->name = 'amazingzoom';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Smart Soft';
        $this->need_instance = 0;
        $this->path = dirname(__FILE__);

        if (strpos(__FILE__, 'Module.php') !== false) {
            $this->path .= '/../modules/'.$this->name;
        }
        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Amazing Zoom Product Image');
        $this->description = $this->l('Zoom Effect for Product Image');

        $this->confirmUninstall = $this->l('Are you sure you want uninstall module ?');
    }

    public function install()
    {
        parent::install();

        $install = new AmazingZoomInstall($this);
        $install->run();

        return true;
    }

    public function uninstall()
    {
        parent::uninstall();

        $install = new AmazingZoomUninstall($this);
        $install->run();

        return true;
    }

    public function hookAjaxCall()
    {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: 0');

        $action = Tools::getValue('action');
        $id_amazingzoom = Tools::getValue('id');

        switch ($action) {
            case 'getConfigForm':
                echo $this->renderConfigForm($id_amazingzoom);
                break;
            case 'saveConfigForm':
                echo $this->saveConfigForm($id_amazingzoom);
                break;
            case 'loadDefaultSettings':
                echo json_encode($this->saveDefaultSettings($id_amazingzoom));
                break;
            case 'copyFrom':
                echo json_encode($this->copyFrom(Tools::getValue('id'), Tools::getValue('id_to')));
                break;
        }
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        // process ajax
        if(Tools::getValue('ajax')) {
            $this->hookAjaxCall();
        }
//        /**
//         * If values have been submitted in the form, process.
//         */
//        if (((bool)Tools::isSubmit('submitAmazingzoomModule')) == true ||
//            ((bool)Tools::getValue('loadDefaultSettings')) === true) {
//            $this->postProcess();
//        }

        $this->context->smarty->assign(array(
            'pages' => AmazingZoomClass::getAll(),
            'start' => dirname(__FILE__) . '/views/templates/admin/start.tpl'
        ));

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->addJavaScriptVariable();
        $output .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/index.tpl');
        $output .= $this->hookBackHeader();
        return $output;
    }

    public function addJavaScriptVariable()
    {
        $this->context->controller->addJqueryPlugin('colorpicker');
        $this->context->controller->addJqueryUI('ui.tabs');


        $this->context->smarty->assign(array(
            'base' => $this->context->link->getAdminLink('AdminModules', false),
            'token' => Tools::getAdminTokenLite('AdminModules')
        ));

        return $this->context->smarty->fetch(
            dirname(__FILE__) . '/views/templates/admin/variable.tpl'
        );
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderToolbarForm($id_page)
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitAmazingzoomModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues($id_page), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        $form = $helper->generateForm(array($this->geToolbarConfigForm($id_page)));

        return $form;

    }

    /**
     * Create the structure of your form.
     */
    protected function geToolbarConfigForm($id_page)
    {
        return array(
            'form' => array(
                'id_from' => 'toolbarForm',
                'input' => array(
                    array(
                        'type' => 'hidden',
                        'class' => 'id_amazingzoom',
                        'name' => 'id',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Zoom'),
                        'name' => 'is_enable_' . $id_page,
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('PhotoSwipe'),
                        'name' => 'swipe_is_enable_' . $id_page,
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Default'),
                        'name' => 'use_default_' . $id_page,
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                ),
//                'submit' => array(
//                    'title' => $this->l('Save'),
//                ),
            ),
        );
    }


    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderConfigForm($id_page)
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitAmazingzoomModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues($id_page), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        $form = '';
        if((int)$id_page !== (int)$this->getDefaultId()) {
            $form .= $this->renderToolbarForm($id_page);
        }

        $form .= $helper->generateForm(array($this->getConfigForm($id_page)));

        return $form;

    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm($id_page)
    {

        $images = ImageType::getImagesTypes('products');
        $images[] = array("name" => "upload");

        $form = array(
            'form' => array(
                'id_form' => 'configForm_' . $id_page,
//                'legend' => array(
//                'title' => $this->l('Settings'),
//                'icon' => 'icon-cogs',
//                ),
                'tabs' => array(
                    'page1_' . $id_page => 'Zoom 1',
                    'page2_' . $id_page => 'Zoom 2',
                    'page5_' . $id_page => 'Photo swipe',
                    'page7_' . $id_page => 'Additional Code',
                ),
                'input' => array(
                    array(
                        'type' => 'hidden',
                        'class' => 'id_amazingzoom',
                        'name' => 'id',
                    ),
                    array(
                        'type' => 'radio-icon',
                        'name' => 'position_' . $id_page,
                        'class' => 'inline-radio',
                        'label' => $this->l('Position of zoom output window'),
                        'values' => array(
                            array('id' => 'icon-top', 'value' => 'top', 'label' => $this->l('Top')),
                            array('id' => 'icon-right', 'value' => 'right', 'label' => $this->l('Right')),
                            array('id' => 'icon-bottom', 'value' => 'bottom', 'label' => $this->l('Bottom')),
                            array('id' => 'icon-left', 'value' => 'left', 'label' => $this->l('Left')),
                            array('id' => 'icon-inside', 'value' => 'inside', 'label' => $this->l('Inside')),
                            array('id' => 'icon-circles', 'value' => 'lens', 'label' => $this->l('Lens'))
                        ),
                        'tab' => 'page1_' . $id_page
                    ),
                    array(
                        'type' => 'radio-icon',
                        'name' => 'mposition_' . $id_page,
                        'class' => 'inline-radio',
                        'label' => $this->l('Zoom output window for mobile.'),
                        'values' => array(
                            array('id' => 'icon-inside', 'value' => 'inside', 'label' => $this->l('Inside')),
                            array('id' => 'icon-fullscreens', 'value' => 'fullscreen', 'label' => $this->l('Fullscreen'))
                        ),
                        'tab' => 'page1_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Zoom output window horizontal offset in pixels from output base position.'),
                        'name' => 'Xoffset_' . $id_page,
                        'label' => $this->l('Xoffset'),
                        'size' => 0, //min
                        'maxchar' => 100, //maxx
                        'maxlength' => 1, //step,
                        'tab' => 'page1_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Zoom output window vertical offset in pixels from output base position.'),
                        'name' => 'Yoffset_' . $id_page,
                        'label' => $this->l('Yoffset'),
                        'size' => 0, //min
                        'maxchar' => 100, //maxx
                        'maxlength' => 1,//step
                        'tab' => 'page1_' . $id_page
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Zoom image type'),
                        'name' => 'image_type_' . $id_page,
                        'options' => array(
                            'query' => $images,
                            'id' => 'name',
                            'name' => 'name'
                        ),
                        'tab' => 'page1_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Fade in on open'),
                        'name' => 'fadeIn_' . $id_page,
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page1_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Fade out on close'),
                        'name' => 'fadeOut_' . $id_page,
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page1_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('You can setup default scale value of zoom on opening, from -1 to 1. Where -1 means -100%, and 1 means 100% of lens scale.'),
                        'name' => 'defaultScale_' . $id_page,
                        'label' => $this->l('defaultScale'),
                        'size' => -1, //min
                        'maxchar' => 1, //maxx
                        'maxlength' => 0.1, //step
                        'tab' => 'page1_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('scroll'),
                        'name' => 'scroll_' . $id_page,
                        'desc' => $this->l('Scale on mouse scroll.'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page1_' . $id_page
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('tint color'),
                        'lang' => false,
                        'name' => 'tint_' . $id_page,
                        'defaults' => '',
                        'id'   => 'color_0',
                        'data-hex' => true,
//                        'class'   => 'mColorPicker',
                        'tab' => 'page2_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'name' => 'tintOpacity_' . $id_page,
                        'label' => $this->l('tint opacity'),
                        'size' => -1, //min
                        'maxchar' => 1, //maxx
                        'maxlength' => 0.1, //step
                        'tab' => 'page2_' . $id_page
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('lens color'),
                        'name' => 'lens_' . $id_page,
                        'tab' => 'page2_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'name' => 'lensOpacity_' . $id_page,
                        'label' => $this->l('lens opacity'),
                        'size' => -1, //min
                        'maxchar' => 1, //maxx
                        'maxlength' => 0.1, //step
                        'tab' => 'page2_' . $id_page
                    ),
                    array(
                        'type' => 'radio-icon',
                        'name' => 'lensShape_' . $id_page,
                        'class' => 'inline-radio',
                        'label' => $this->l('lens shape'),
                        'values' => array(
                            array('id' => 'icon-box', 'value' => 'box', 'label' => $this->l('Box')),
                            array('id' => 'icon-circles', 'value' => 'circle', 'label' => $this->l('Circle')),
                        ),
                        'tab' => 'page2_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('lensCollision'),
                        'name' => 'lensCollision_' . $id_page,
                        'desc' => $this->l('Lens will collide and not go out of main image borders. This option is always false for position "lens".'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page2_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('title'),
                        'name' => 'title_' . $id_page,
                        'desc' => $this->l('Output title/caption of the image, in the zoom output window..'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page2_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('bg'),
                        'name' => 'bg_' . $id_page,
                        'desc' => $this->l('Zoom image output as background, works only when position is set to "lens".'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page2_' . $id_page
                    ),
                    array(
                        'type' => 'text',
                        'class' => '',
                        'desc' => $this->l('Css path to your image.'),
                        'name' => 'css_selector_' . $id_page,
                        'label' => $this->l('Selector image / trigger'),
                        'tab' => 'page2_' . $id_page
                    ),

                    array(
                        'type' => 'text',
                        'class' => '',
                        'desc' => $this->l('Css path to your thumbnails.'),
                        'name' => 'thumb_selector_' . $id_page,
                        'label' => $this->l('Selector thumbnails'),
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('show/hide opacity'),
                        'name' => 'swipe_showHideOpacity_' . $id_page,
                        'desc' => $this->l('If set to false: background opacity and image scale will be animated (image opacity is always 1)'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Initial zoom-in transition duration in milliseconds. Set to 0 to disable.'),
                        'name' => 'swipe_showAnimationDuration_' . $id_page,
                        'label' => $this->l('Show animation duration'),
                        'size' => 0, //min
                        'maxchar' => 500, //maxx
                        'maxlength' => 1, //step,
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Initial zoom-out transition duration in milliseconds. Set to 0 to disable.'),
                        'name' => 'swipe_hideAnimationDuration_' . $id_page,
                        'label' => $this->l('Hide animation duration'),
                        'size' => 0, //min
                        'maxchar' => 500, //maxx
                        'maxlength' => 1, //step,
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Should be a number from 0 to 1, e.g. 0.7.'),
                        'name' => 'swipe_bgOpacity_' . $id_page,
                        'label' => $this->l('Background opacity'),
                        'size' => 0, //min
                        'maxchar' => 1, //maxx
                        'maxlength' => 0.1, //step,
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Spacing ratio between slides. For example, 0.12 will render as a 12% of sliding viewport width (rounded).'),
                        'name' => 'swipe_spacing_' . $id_page,
                        'label' => $this->l('Spacing'),
                        'size' => 0, //min
                        'maxchar' => 1, //maxx
                        'maxlength' => 0.1, //step,
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Allow pan to next'),
                        'name' => 'swipe_allowPanToNext_' . $id_page,
                        'desc' => $this->l('Allow swipe navigation to next/prev item when current item is zoomed.'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Maximum zoom level when performing spread (zoom) gesture. 2 means that image can be zoomed 2x from original size. Try to avoid huge values.'),
                        'name' => 'swipe_maxSpreadZoom_' . $id_page,
                        'label' => $this->l('Max spread zoom'),
                        'size' => 0, //min
                        'maxchar' => 5, //maxx
                        'maxlength' => 1, //step,
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Loop'),
                        'name' => 'swipe_loop_' . $id_page,
                        'desc' => $this->l('Loop slides when using swipe gesture. If set to true you will be able to swipe from last to first image.'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Pinch too close'),
                        'name' => 'swipe_pinchToClose_' . $id_page,
                        'desc' => $this->l('Pinch to close gallery gesture. The gallery`s background will gradually fade out as the user zooms out.'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Close on scroll'),
                        'name' => 'swipe_closeOnScroll_' . $id_page,
                        'desc' => $this->l('Close gallery on page scroll. Option works just for devices without hardware touch support.'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Close on vertical drag'),
                        'name' => 'swipe_closeOnVerticalDrag_' . $id_page,
                        'desc' => $this->l('Close gallery when dragging vertically and when image is not zoomed. Always false when mouse is used.'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Arrow keys'),
                        'name' => 'swipe_showHideOpacity_' . $id_page,
                        'desc' => $this->l('Keyboard left or right arrow key navigation.'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Modal'),
                        'name' => 'swipe_modal_' . $id_page,
                        'desc' => $this->l('Controls whether PhotoSwipe should expand to take up the entire viewport. If false, the PhotoSwipe element will take the size of the positioned parent of the template.'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'tab' => 'page5_' . $id_page
                    ),

                    array(
                        'type' => 'textarea',
                        'label' => $this->l('JavaScript Code'),
                        'name' => 'js_' . $id_page,
                        'id' => 'js_' . $id_page,
                        'class' => '',
                        'tab' => 'page7_' . $id_page,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Css Code'),
                        'name' => 'css_' . $id_page,
                        'id' => 'css_' . $id_page,
                        'class' => '',
                        'tab' => 'page7_' . $id_page,
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
                'buttons' => array(
                    array(
                        'id' => 'load_default',
                        'title' => $this->l('Load Install Default'),
                        'href' => AdminController::$currentIndex.'&loadDefaultSettings=1&configure='.
                            $this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
                        'icon' => 'process-icon-configure'
                    ),
                    array(
                        'id' => 'copy_model',
                        'title' => $this->l('Copy From'),
                        'href' => AdminController::$currentIndex.'&copyModel=1&configure='.
                            $this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
                        'icon' => 'process-icon-duplicate'
                    )
                )
            ),
        );

        if((int)$id_page !== $this->getDefaultId()) {
            $form['form']['tabs']['page6_' . $id_page] = 'Display Page';
            $form['form']['input'][] = array(
                'type' => 'duallist',
                'label' => $this->l('Page'),
                'name' => 'controller_' . $id_page,
                'id' => 'controller',
                'class' => '',
                'multiple' => true,
                'options' => array(
                    'options' => array(
                        'query' => $this->getPages(),
                        'id' => 'page',
                        'name' => 'page',
                        'link' => 'link'
                    ),
                ),
                'tab' => 'page6_' . $id_page
            );
        }

        return $form;
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            if (method_exists($this->context->controller, 'addJquery')) {
                $this->context->controller->addJquery();

                $this->context->controller->addJS($this->_path . 'views/js/range-slider.js');
                $this->context->controller->addCSS($this->_path . 'views/css/range-slider.css');
                $this->context->controller->addJS($this->_path . 'views/js/back.js');
                $this->context->controller->addCSS($this->_path . 'views/css/back.css');
                $this->context->controller->addCSS($this->_path . 'views/css/duallist.css');

                $this->context->controller->addJS($this->_path . 'views/js/duallist.js');
                $this->context->controller->addJS($this->_path . 'views/js/jquery.cooki-plugin.js');

                $this->context->controller->addJS($this->_path . 'views/js/ace.js');
                $this->context->controller->addJS($this->_path . 'views/js/theme-tomorrow.js');
                $this->context->controller->addJS($this->_path . 'views/js/mode-css.js');
                $this->context->controller->addJS($this->_path . 'views/js/mode-javascript.js');
            }
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader($params)
    {
        $controller = $this->context->controller->php_self;
        $templateFile = 'amazingzoom.tpl';
        $id_cache = 'amazingzoom|' . $controller;

        if (!$this->isCached($templateFile, $this->getCacheId($id_cache))) {

            $active_amazingzooms = AmazingZoomClass::getEnabled();
            $default_amazingzoom =  AmazingZoomClass::getDefaultSettings();

            $amazingzoom = array();

            foreach ($active_amazingzooms as $key => $active_amazingzoom) {
                $controllers = explode(',', $active_amazingzoom['controller']);
                if (in_array($controller, $controllers)) {
                    if ($active_amazingzoom['use_default']) {
                        $amazingzoom[$key] = $default_amazingzoom[0];
                        $amazingzoom[$key]['use_default'] = $active_amazingzoom['use_default'];
                        $amazingzoom[$key]['is_enable'] = $active_amazingzoom['is_enable'];
                        $amazingzoom[$key]['controller'] = $active_amazingzoom['controller'];
                        $amazingzoom[$key]['name'] = $active_amazingzoom['name'];
                        $amazingzoom[$key]['css_selector'] = $active_amazingzoom['css_selector'];

                        $amazingzoom[$key]['js'] = $active_amazingzoom['js'];
                        $amazingzoom[$key]['css'] = $active_amazingzoom['css'];
                    } else {
                        $amazingzoom[$key] = $active_amazingzoom;
                    }

                    $amazingzoom[$key]['image_type'] = ($active_amazingzoom['image_type'] === 'upload' ? '' :
                        '-' . $active_amazingzoom['image_type']);

                    $amazingzoom[$key]['js'] =
                        str_replace('{css_selector}',  $amazingzoom[$key]['css_selector'],  $amazingzoom[$key]['js']);
                    $amazingzoom[$key]['css'] =
                        str_replace('{css_selector}',   $amazingzoom[$key]['css_selector'], $amazingzoom[$key]['css']);

                }
            }

            if ($amazingzoom) {
                $this->smarty->assign(array(
                    'this_path' => $this->_path,
                    'path' => $this->path,
                    'amazingzooms' => $amazingzoom,
                    'is_zoom_enable' => $this->isZoomEnable($amazingzoom),
                    'is_swipe_enable' => $this->isSwipeEnable($amazingzoom),
                    'is_17' => (_PS_VERSION_ >= 1.7 ? true : false)
                ));

            }
        }

        return $this->display(
            __FILE__, 'views/templates/front/amazingzoom.tpl',
            $this->getCacheId($id_cache)
        );
    }

    public function hookDisplayBeforeBodyClosingTag($params)
    {
        return $this->hookHeader($params);
    }

    public function clearCache()
    {
        $this->_clearCache('*');
    }

    public function hookDisplayProductListFunctionalButtons()
    {
        /* Place your code here. */
    }

    private function saveDefaultSettings($id_amazingzoom)
    {
        $ps_version = (_PS_VERSION_ >= 1.7 ? "17" : "");
        $amazingZoomClass = new AmazingZoomClass($id_amazingzoom);
        require_once dirname(__FILE__) . '/classes/ModuleDisplay/' . $ps_version . '/' .
            str_replace(' ', '', $amazingZoomClass->name) . $ps_version . '.php';
        $class = basename($file, '.php');

        if (class_exists($class)) {
            $obj = new $class;
            $obj->save();

            $this->clearCache();
        }


        return array(
            'form' => $this->renderConfigForm($id_amazingzoom),
            'message' => $this->displayConfirmation(
                $this->l('Settings load successfully.')
            )
        );
    }

    public function getConfigFormValues($id_page)
    {
        $amazingZoomClass = new AmazingZoomClass($id_page);
        $fields_values = (array) $amazingZoomClass;

        foreach ($fields_values as $key => $fields_value) {
            if($key !== 'id') {
                $fields_values[$key . '_' . $id_page] = $fields_value;
                unset($fields_values[$key]);
            }
        }

        $fields_values['controller' . '_' . $id_page] =
            explode(',', $fields_values['controller' . '_' . $id_page]);

        return $fields_values;
    }

    private function saveConfigForm($id_amazingzoom)
    {
        $this->postValidation($id_amazingzoom);

        if(!empty($this->_errors)) {
            $errors = '';
            foreach ($this->_errors as $error) {
                $errors = '<div class="module_error alert alert-danger" >' . $error . '</div>';
            }
            return $errors;
            exit();
        }


        $amazingZoomClass = new AmazingZoomClass($id_amazingzoom);
        $amazingZoomClass->copyFromPost($id_amazingzoom);
        $amazingZoomClass->js = str_replace("'", '"', $amazingZoomClass->css);
        $amazingZoomClass->save();

        $this->clearCache();

        return $this->displayConfirmation(
            $this->l('Settings saved successfully.')
        );
    }


    private function postValidation($id_amazingzoom)
    {
        if (!$this->isUniqueCssElement($css_selector = Tools::getValue('css_selector_' . $id_amazingzoom),
            $id_amazingzoom)) {
            $this->_errors[] = $this->l('You already use "' . $css_selector . '" as image selector.');
        }
    }

    private function getDefaultId()
    {
        return (int)AmazingZoomClass::getDefaultSettingsId();
    }

    private function getPages()
    {
        $controllers = Dispatcher::getControllers(_PS_FRONT_CONTROLLER_DIR_);
        $result = array();
        foreach ($controllers as $key => $controller) {
            $name = str_replace('Controller', '', $controller);
            $name = preg_replace('/\B[A-Z]/', '-$0', $name);
            $name = strtolower($name);

            $result[$key]['page'] = $name;
            $result[$key]['link'] = $this->context->link->getPageLink($key);

            if($key === 'category') {
                $category = new Category((int) Configuration::get('PS_HOME_CATEGORY'));
                $result[$key]['link'] = $category->getLink();
            }

            if($key === 'product') {
                $product = new Product($this->getFirstEnabled('product'));
                $result[$key]['link'] = Context::getContext()->link->getProductLink($product);
            }

            if($key === 'manufacturer') {
                $manufacturer = new Manufacturer($this->getFirstEnabled('manufacturer'));
                $result[$key]['link'] = Context::getContext()->link->getManufacturerLink($manufacturer);
            }

            if($key === 'supplier') {
                $supplier = new Supplier($this->getFirstEnabled('supplier'));
                $result[$key]['link'] = Context::getContext()->link->getManufacturerLink($supplier);
            }
        }

        return $result;
    }

    private function isUniqueCssElement($css_selector, $id_amazingzoom)
    {
        $pages = DB::getInstance()->executeS(
            'SELECT * FROM `' . _DB_PREFIX_ . 'amazingzoom` WHERE css_selector = "' . $css_selector . '" AND
            `id_amazingzoom` != ' . $id_amazingzoom
        );

        return ($pages ? false : true);
    }

    private function copyFrom($id, $id_to)
    {
        $zoom_copy = new AmazingZoomClass($id_to);

        $zoom = new AmazingZoomClass($id);
        $zoom->id = $id_to;
        $zoom->name = $zoom_copy->name;
        $zoom->controller = $zoom_copy->controller;
        $zoom->css_selector = $zoom_copy->css_selector;
        $zoom->css = $zoom_copy->css;
        $zoom->js = $zoom_copy->js;
        $zoom->save();

        $this->clearCache();

        return array(
            'form' => $this->renderConfigForm($id_to),
            'message' => $this->displayConfirmation(
                $this->l('Settings load successfully.')
            )
        );
    }

    private function isZoomEnable($amazingzoom)
    {
        foreach ($amazingzoom as $ae) {
            if($ae['is_enable']) {
                return true;
            }
        }

        return false;
    }

    private function isSwipeEnable($amazingzoom)
    {
        foreach ($amazingzoom as $ae) {
            if($ae['swipe_is_enable']) {
                return true;
            }
        }

        return false;
    }

    private function getFirstEnabled($entity)
    {
        $id = DB::getInstance()->getValue(
            'SELECT id_' . $entity . ' FROM `' . _DB_PREFIX_ . $entity .'` WHERE active = 1'
        );

        return $id;
    }
}
