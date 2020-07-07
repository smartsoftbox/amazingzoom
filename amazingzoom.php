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

class Amazingzoom extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'amazingzoom';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Smart Soft';
        $this->need_instance = 0;
        $path = dirname(__FILE__);

        if (strpos(__FILE__, 'Module.php') !== false) {
            $path .= '/../modules/'.$this->name;
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

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        $this->saveDefaultSettings();
        parent::install();

        if (version_compare(_PS_VERSION_, '1.7.0', '>=') === true) {
            $this->registerHook('displayBeforeBodyClosingTag');
        } else {
            $this->registerHook('header');
        }

        return $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayProductListFunctionalButtons');
    }

    public function uninstall()
    {
        Configuration::deleteByName('AMAZINGZOOM_LIVE_MODE');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitAmazingzoomModule')) == true ||
            ((bool)Tools::getValue('loadDefaultSettings')) === true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');
        $output .= $this->hookBackHeader();
        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
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
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'radio-icon',
                        'name' => Config::AMAZINGZOOM_position,
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
                    ),
                    array(
                        'type' => 'radio-icon',
                        'name' => Config::AMAZINGZOOM_mposition,
                        'class' => 'inline-radio',
                        'label' => $this->l('Position of zoom output window for mobile devices'),
                        'desc' => $this->l('Position of zoom output window in adaptive mode (i.e. for mobile devices) available properties: "inside", "fullscreen"'),
                        'values' => array(
                            array('id' => 'icon-inside', 'value' => 'inside', 'label' => $this->l('Inside')),
                            array('id' => 'icon-fullscreens', 'value' => 'lens', 'label' => $this->l('Fullscreen'))
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('rootOutput'),
                        'name' => Config::AMAZINGZOOM_rootOutput,
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
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Zoom output window horizontal offset in pixels from output base position.'),
                        'name' => Config::AMAZINGZOOM_Xoffset,
                        'label' => $this->l('Xoffset'),
                        'size' => 0, //min
                        'maxchar' => 100, //maxx
                        'maxlength' => 1 //step
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Zoom output window vertical offset in pixels from output base position.'),
                        'name' => Config::AMAZINGZOOM_Yoffset,
                        'label' => $this->l('Yoffset'),
                        'size' => 0, //min
                        'maxchar' => 100, //maxx
                        'maxlength' => 1 //step
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('fadeIn'),
                        'name' => Config::AMAZINGZOOM_fadeIn,
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
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('fadeTrans'),
                        'name' => Config::AMAZINGZOOM_fadeTrans,
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
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('fadeOut'),
                        'name' => Config::AMAZINGZOOM_fadeOut,
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
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Smooth move effect of the big zoomed image in the zoom output window. The higher value will make movement smoother.'),
                        'name' => Config::AMAZINGZOOM_smoothZoomMove,
                        'label' => $this->l('smoothZoomMove'),
                        'size' => 1, //min
                        'maxchar' => 10, //maxx
                        'maxlength' => 1 //step
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Smooth move effect of lens.'),
                        'name' => 'AMAZINGZOOM_smoothLensMove',
                        'label' => $this->l('smoothLensMove'),
                        'size' => 1, //min
                        'maxchar' => 10, //maxx
                        'maxlength' => 1 //step
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Smooth move effect of scale.'),
                        'name' => Config::AMAZINGZOOM_smoothScale,
                        'label' => $this->l('smoothScale'),
                        'size' => 1, //min
                        'maxchar' => 10, //maxx
                        'maxlength' => 1 //step
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('You can setup default scale value of zoom on opening, from -1 to 1. Where -1 means -100%, and 1 means 100% of lens scale.'),
                        'name' => Config::AMAZINGZOOM_defaultScale,
                        'label' => $this->l('defaultScale'),
                        'size' => -1, //min
                        'maxchar' => 1, //maxx
                        'maxlength' => 0.1 //step
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('scroll'),
                        'name' => Config::AMAZINGZOOM_scroll,
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
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('tint'),
                        'name' => Config::AMAZINGZOOM_tint,
                        'desc' => $this->l('Tint color. Color must be provided in format like "#color". We are not recommend you to use named css colors.'),
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Tint opacity from 0 to 1.'),
                        'name' => Config::AMAZINGZOOM_tintOpacity,
                        'label' => $this->l('tintOpacity'),
                        'size' => -1, //min
                        'maxchar' => 1, //maxx
                        'maxlength' => 0.1 //step
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('lens'),
                        'name' => 'AMAZINGZOOM_lens',
                        'desc' => $this->l('Lens color. Color must be provided in format like "#color". We are not recommend you to use named css colors.'),
                    ),
                    array(
                        'type' => 'slider',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Lens opacity from 0 to 1.'),
                        'name' => Config::AMAZINGZOOM_lensOpacity,
                        'label' => $this->l('lensOpacity'),
                        'size' => -1, //min
                        'maxchar' => 1, //maxx
                        'maxlength' => 0.1 //step
                    ),
                    array(
                        'type' => 'radio-icon',
                        'name' => Config::AMAZINGZOOM_lensShape,
                        'class' => 'inline-radio',
                        'label' => $this->l('lensShape'),
                        'desc' => $this->l('Lens shape "box" or "circle".'),
                        'values' => array(
                            array('id' => 'icon-box', 'value' => 'box', 'label' => $this->l('Box')),
                            array('id' => 'icon-circles', 'value' => 'circle', 'label' => $this->l('Circle')),
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('lensCollision'),
                        'name' => Config::AMAZINGZOOM_lensCollision,
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
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('lensReverse'),
                        'name' => Config::AMAZINGZOOM_lensReverse,
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
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('openOnSmall'),
                        'name' => Config::AMAZINGZOOM_openOnSmall,
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
                    ),
                    array(
                        'type' => 'text',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Custom width of zoom window in pixels.'),
                        'name' => Config::AMAZINGZOOM_zoomWidth,
                        'label' => $this->l('zoomWidth'),
                    ),
                    array(
                        'type' => 'text',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Custom height of zoom window in pixels.'),
                        'name' => Config::AMAZINGZOOM_zoomHeight,
                        'label' => $this->l('zoomHeight'),
                    ),
                    array(
                        'type' => 'text',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Class name for source "div" container..'),
                        'name' => Config::AMAZINGZOOM_sourceClass,
                        'label' => $this->l('sourceClass'),
                    ),
                    array(
                        'type' => 'text',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Class name for loading "div" container that appear before zoom opens, when image is still loading.'),
                        'name' => Config::AMAZINGZOOM_loadingClass,
                        'label' => $this->l('loadingClass'),
                    ),
                    array(
                        'type' => 'text',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Class name for lens "div".'),
                        'name' => Config::AMAZINGZOOM_lensClass,
                        'label' => $this->l('lensClass'),
                    ),
                    array(
                        'type' => 'text',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Class name for zoom window(div).'),
                        'name' => Config::AMAZINGZOOM_zoomClass,
                        'label' => $this->l('zoomClass'),
                    ),
                    array(
                        'type' => 'text',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Class name that will be added to active thumbnail image.'),
                        'name' => Config::AMAZINGZOOM_activeClass,
                        'label' => $this->l('activeClass'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('hover'),
                        'name' => Config::AMAZINGZOOM_hover,
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
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('adaptive'),
                        'name' => Config::AMAZINGZOOM_adaptive,
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
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('adaptiveReverse'),
                        'name' => Config::AMAZINGZOOM_adaptiveReverse,
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
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('title'),
                        'name' => Config::AMAZINGZOOM_title,
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
                    ),
                    array(
                        'type' => 'text',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Class name for caption "div" container.'),
                        'name' => Config::AMAZINGZOOM_titleClass,
                        'label' => $this->l('titleClass'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('bg'),
                        'name' => Config::AMAZINGZOOM_bg,
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
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
                'buttons' => array(
                    array(
                        'title' => $this->l('Load Default'),
                        'href' => AdminController::$currentIndex.'&loadDefaultSettings=1&configure='.
                            $this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
                        'icon' => 'process-icon-configure'
                    )
                )
            ),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        if (Tools::isSubmit('submitAmazingzoomModule')) {
            $this->saveSettings();
        } elseif (Tools::getValue('loadDefaultSettings')) {
            $this->saveDefaultSettings();
        }
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
            }
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader($params)
    {
        if ($this->context->controller instanceof ProductController)
        {
//            $this->context->controller->addCSS($this->_path.'/views/css/xzoom.css');
//            $this->context->controller->addJS($this->_path.'views/js/xzoom.js');

//            $this->context->controller->addJS($this->_path.'/views/js/front.js');
//            $this->context->controller->addCSS($this->_path.'/views/css/front.css');

            $configuration = $this->getConfigFormValues();
            $this->smarty->assign('this_path', $this->_path);
            $this->smarty->assign($configuration);

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

    private function saveDefaultSettings()
    {
        $settings = Config::getDefaultConfig();

        foreach ($settings as $option => $default_value) {
            Configuration::updateValue($option, $default_value);
        }
    }

    protected function saveSettings()
    {
        $settings = Config::getDefaultConfig();

        foreach (array_keys($settings) as $option) {
            Configuration::updateValue($option, Tools::getValue($option));
        }
    }

    public function getConfigFormValues()
    {
        $settings = Config::getDefaultConfig();
        $form_values = array();
        foreach (array_keys($settings) as $option) {
            $value = Configuration::get($option);
            $form_values[$option] = ($value ? $value : 0);
        }

        return $form_values;
    }
}
