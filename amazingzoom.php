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
        $path = dirname(__FILE__);

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
        }

        $this->clearCache();
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
                        'label' => $this->l('Enable'),
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
                        'label' => $this->l('Default Settings'),
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
        if($id_page !== $this->getDefaultId()) {
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

        return array(
            'form' => array(
                'id_form' => 'configForm_' . $id_page,
//                'legend' => array(
//                'title' => $this->l('Settings'),
//                'icon' => 'icon-cogs',
//                ),
                'tabs' => array(
                    'page1_' . $id_page => 'Position',
                    'page2_' . $id_page => 'Effect',
                    'page3_' . $id_page => 'Style',
                    'page4_' . $id_page => 'Advanced',
                    'page5_' . $id_page => 'Controllers',
                    'page6_' . $id_page => 'Befo',
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
                        'desc' => $this->l('Position of zoom output window, one of the next properties is available "top", "left", "right", "bottom", "inside", "lens", "#ID".'),
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
                        'label' => $this->l('Position of zoom output window for mobile devices'),
                        'desc' => $this->l('Position of zoom output window in adaptive mode (i.e. for mobile devices) available properties: "inside", "fullscreen"'),
                        'values' => array(
                            array('id' => 'icon-inside', 'value' => 'inside', 'label' => $this->l('Inside')),
                            array('id' => 'icon-fullscreens', 'value' => 'fullscreen', 'label' => $this->l('Fullscreen'))
                        ),
                        'tab' => 'page1_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('rootOutput'),
                        'name' => 'rootOutput_' . $id_page,
                        'desc' => $this->l('In the HTML structure, this option gives an ability to output xzoom element, to the end of the document body or relative to the parent element of main source image.'),
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
                        'label' => $this->l('Image type'),
                        'name' => 'image_type_' . $id_page,
                        'options' => array(
                            'query' => $images,
                            'id' => 'name',
                            'name' => 'name'
                        ),
                        'desc' =>$this->l('Zoom image type.'),
                        'tab' => 'page1_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('fadeIn'),
                        'name' => 'fadeIn_' . $id_page,
                        'desc' => $this->l('Fade in effect, when zoom is opening.'),
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
                        'label' => $this->l('fadeTrans'),
                        'name' => 'fadeTrans_' . $id_page,
                        'desc' => $this->l('Fade transition effect, when switching images by clicking on thumbnails.'),
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
                        'label' => $this->l('fadeOut'),
                        'name' => 'fadeOut_' . $id_page,
                        'desc' => $this->l('Fade out effect, when zoom is closing.'),
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
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Smooth move effect of the big zoomed image in the zoom output window. The higher value will make movement smoother.'),
                        'name' => 'smoothZoomMove_' . $id_page,
                        'label' => $this->l('smoothZoomMove'),
                        'size' => 1, //min
                        'maxchar' => 10, //maxx
                        'maxlength' => 1, //step
                        'tab' => 'page2_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Smooth move effect of lens.'),
                        'name' => 'smoothLensMove_' . $id_page,
                        'label' => $this->l('smoothLensMove'),
                        'size' => 1, //min
                        'maxchar' => 10, //maxx
                        'maxlength' => 1, //step
                        'tab' => 'page3_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Smooth move effect of scale.'),
                        'name' => 'smoothScale_' . $id_page,
                        'label' => $this->l('smoothScale'),
                        'size' => 1, //min
                        'maxchar' => 10, //maxx
                        'maxlength' => 1, //step
                        'tab' => 'page3_' . $id_page
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
                        'tab' => 'page3_' . $id_page
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
                        'tab' => 'page3_' . $id_page
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('tint'),
                        'lang' => false,
                        'name' => 'tint_' . $id_page,
                        'defaults' => '',
                        'id'   => 'color_0',
                        'data-hex' => true,
//                        'class'   => 'mColorPicker',
                        'desc' => $this->l('Tint color. Color must be provided in format like "#color". We are not recommend you to use named css colors.'),
                        'tab' => 'page3_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Tint opacity from 0 to 1.'),
                        'name' => 'tintOpacity_' . $id_page,
                        'label' => $this->l('tintOpacity'),
                        'size' => -1, //min
                        'maxchar' => 1, //maxx
                        'maxlength' => 0.1, //step
                        'tab' => 'page3_' . $id_page
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('lens'),
                        'name' => 'lens_' . $id_page,
                        'desc' => $this->l('Lens color. Color must be provided in format like "#color". We are not recommend you to use named css colors.'),
                        'tab' => 'page3_' . $id_page
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Lens opacity from 0 to 1.'),
                        'name' => 'lensOpacity_' . $id_page,
                        'label' => $this->l('lensOpacity'),
                        'size' => -1, //min
                        'maxchar' => 1, //maxx
                        'maxlength' => 0.1, //step
                        'tab' => 'page3_' . $id_page
                    ),
                    array(
                        'type' => 'radio-icon',
                        'name' => 'lensShape_' . $id_page,
                        'class' => 'inline-radio',
                        'label' => $this->l('lensShape'),
                        'desc' => $this->l('Lens shape "box" or "circle".'),
                        'values' => array(
                            array('id' => 'icon-box', 'value' => 'box', 'label' => $this->l('Box')),
                            array('id' => 'icon-circles', 'value' => 'circle', 'label' => $this->l('Circle')),
                        ),
                        'tab' => 'page3_' . $id_page
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
                        'tab' => 'page3_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('lensReverse'),
                        'name' => 'lensReverse_' . $id_page,
                        'desc' => $this->l('When selected position "inside" and this option is set to true, the lens direction of moving will be reversed.'),
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
                        'tab' => 'page4_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('openOnSmall'),
                        'name' => 'openOnSmall_' . $id_page,
                        'desc' => $this->l('Option to control whether to open or not the zoom on original image, that is smaller than preview.'),
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
                        'tab' => 'page4_' . $id_page
                    ),
                    array(
                        'type' => 'text',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Custom width of zoom window in pixels. For auto write auto.'),
                        'name' => 'zoomWidth_' . $id_page,
                        'label' => $this->l('zoomWidth'),
                        'tab' => 'page4_' . $id_page
                    ),
                    array(
                        'type' => 'text',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Custom height of zoom window in pixels. For auto write auto.'),
                        'name' => 'zoomHeight_' . $id_page,
                        'label' => $this->l('zoomHeight'),
                        'tab' => 'page4_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('hover'),
                        'name' => 'hover_' . $id_page,
                        'desc' => $this->l('With this option you can make a selection action on thumbnail by hover mouse point on it.'),
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
                        'tab' => 'page4_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('adaptive'),
                        'name' => 'adaptive_' . $id_page,
                        'desc' => $this->l('Adaptive functionality.'),
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
                        'tab' => 'page4_' . $id_page
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('adaptiveReverse'),
                        'name' => 'adaptiveReverse_' . $id_page,
                        'desc' => $this->l('Same as lensReverse, but only available when adaptive is true.'),
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
                        'tab' => 'page4_' . $id_page
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
                        'tab' => 'page4_' . $id_page
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
                        'tab' => 'page4_' . $id_page
                    ),
                    array(
                        'type' => 'text',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('This image selector will be used to render zoom.'),
                        'name' => 'css_selector_' . $id_page,
                        'label' => $this->l('Selector image'),
                        'tab' => 'page4_' . $id_page
                    ),
                    array(
                        'type' => 'duallist',
                        'label' => $this->l('Controllers'),
                        'name' => 'controller_' . $id_page,
                        'id' => 'controller',
                        'class' => '',
                        'multiple' => true,
                        'options' => array(
                            'options' => array(
                                'query' => $this->getMetaPages(),
                                'id' => 'page',
                                'name' => 'page',
                            ),
                        ),
                        'tab' => 'page5_' . $id_page
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('JavaScript Code'),
                        'name' => 'js_' . $id_page,
                        'id' => 'js_' . $id_page,
                        'tab' => 'page6_' . $id_page
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Css Code'),
                        'name' => 'css_' . $id_page,
                        'id' => 'css_' . $id_page,
                        'tab' => 'page6_' . $id_page
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
                'buttons' => array(
                    array(
                        'id' => 'load_default',
                        'title' => $this->l('Load Default'),
                        'href' => AdminController::$currentIndex.'&loadDefaultSettings=1&configure='.
                            $this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
                        'icon' => 'process-icon-configure'
                    )
                )
            ),
        );
    }

//    /**
//     * Save form data.
//     */
//    protected function postProcess()
//    {
//        if (Tools::isSubmit('submitAmazingzoomModule')) {
//            $this->saveSettings();
//        } elseif (Tools::getValue('loadDefaultSettings')) {
//            $this->saveDefaultSettings($id_page);
//        }
//    }

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
        $active_amazingzooms = AmazingZoomClass::getEnabled();
        $amazingzoom = array();

        $controller = $this->context->controller;
        foreach ($active_amazingzooms as $key => $active_amazingzoom) {
            $controller = implode('', array_map(
                'ucfirst',
                explode('-', $active_amazingzoom['controller'])
            ));
            $controller .= 'Controller';
            if ($this->context->controller instanceof $controller) {
                if($active_amazingzoom['use_default']) {
                    $amazingzoom[$key] = $active_amazingzooms[0];
                    $amazingzoom[$key]['use_default'] =  $active_amazingzoom['use_default'];
                    $amazingzoom[$key]['is_enable'] =  $active_amazingzoom['is_enable'];
                    $amazingzoom[$key]['controller'] =  $active_amazingzoom['controller'];
                    $amazingzoom[$key]['name'] =  $active_amazingzoom['name'];
                    $amazingzoom[$key]['css_selector'] =  $active_amazingzoom['css_selector'];
                    $amazingzoom[$key]['js'] =  $active_amazingzoom['js'];
                    $amazingzoom[$key]['css'] =  $active_amazingzoom['css'];
                } else {
                    $amazingzoom[$key] = $active_amazingzoom;
                }

                $amazingzoom[$key]['image_type'] = ($active_amazingzoom['image_type'] === 'upload' ? '' :
                    '-' . $active_amazingzoom['image_type']);
//
//                $amazingzoom[$key]['css_selector'] = (_PS_VERSION_ >= 1.7 ? $active_amazingzoom['css_selector_17'] :
//                    $active_amazingzoom['css_selector_16']);
//
//                $amazingzoom[$key]['js'] = dirname(__FILE__) .
//                    '/views/templates/front/back/' .
//                    strtolower(str_replace(' ', '_', $active_amazingzoom['name'])) . '.tpl';
            }
        }

        if($amazingzoom) {
            $this->smarty->assign(array(
                'this_path' => $this->_path,
                'amazingzooms' => $amazingzoom,
                'is_17' => (_PS_VERSION_ >= 1.7 ? true : false)
            ));

            return $this->display(__FILE__, 'views/templates/front/front.tpl');
        }
    }

    public function hookDisplayBeforeBodyClosingTag($params)
    {
        return $this->hookHeader($params);
    }

    public function clearCache()
    {
        $this->_clearCache('front.tpl');
    }

    public function hookDisplayProductListFunctionalButtons()
    {
        /* Place your code here. */
    }

    private function saveDefaultSettings($id_amaizingzoom)
    {
        $settings = Config::getDefaultConfig();
        $amazingZoomClass = new AmazingZoomClass($id_amaizingzoom);
        $amazingZoomClass->getDefaultValues();
        $amazingZoomClass->save();

        return array(
            'form' => $this->renderConfigForm($id_amaizingzoom),
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
        $this->postValidation();

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
        $amazingZoomClass->save();

        return $this->displayConfirmation(
            $this->l('Settings saved successfully.')
        );
    }


    private function postValidation()
    {
//        if (!Tools::getValue('CHEQUE_NAME')) {
//            $this->_errors[] = $this->l('The "Payee" field is required.');
//        }
    }

    private function getDefaultId()
    {
        return AmazingZoomClass::getDefaultSettingsId();
    }

    private function getMetaPages()
    {
        return DB::getInstance()->executeS('SELECT * FROM `' . _DB_PREFIX_ . 'meta`');
    }
}
