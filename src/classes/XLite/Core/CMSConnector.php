<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * LiteCommerce
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@litecommerce.com so we can send you a copy immediately.
 * 
 * @category   LiteCommerce
 * @package    XLite
 * @subpackage Core
 * @author     Creative Development LLC <info@cdev.ru> 
 * @copyright  Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    SVN: $Id$
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      3.0.0
 */

/**
 * CMS connector 
 * 
 * @package XLite
 * @see     ____class_see____
 * @since   3.0.0
 */
abstract class XLite_Core_CMSConnector extends XLite_Base implements XLite_Base_ISingleton
{
    /**
     * Name of the request param, which determines the redirect behaviour
     */
    const NO_REDIRECT = '____NO_REDIRECT____';


    /**
     * Current CMS name
     * 
     * @var    booln
     * @access protected
     * @since  3.0.0
     */
    protected static $currentCMS = null;


    /**
     * List of widgets which can be exported
     * 
     * @var    array
     * @access protected
     * @since  3.0
     */
    protected $widgetsList = array(
        'XLite_View_TopCategories'    => 'Categories list',
        'XLite_View_Minicart'         => 'Minicart',
        'XLite_View_Subcategories'    => 'Subcategories',
        'XLite_View_CategoryProducts' => 'Category products list',
        'XLite_View_ProductBox'       => 'Product block',
        'XLite_View_PoweredBy'        => '\'Powered by\' block',
    );

    /**
     * Page types 
     * 
     * @var    array
     * @access protected
     * @since  3.0.0
     */
    protected $pageTypes = array(
        'category'   => 'Category page',
        'product'    => 'Product page',
        'cart'       => 'Shopping cart',
        'checkout'   => 'Checkout',
        'order_list' => 'Orders list',
    );


    /**
     * getProfileDBFields 
     * 
     * @param int $cmsUserId CMS user Id
     *  
     * @return array
     * @access protected
     * @since  3.0.0
     */
    protected function getProfileDBFields($cmsUserId)
    {
        return array('cms_profile_id' => intval($cmsUserId), 'cms_name' => $this->getCMSName());
    }

    /**
     * getProfileWhereCondition 
     * 
     * @param int $cmsUserId CMS user Id
     *  
     * @return string
     * @access protected
     * @since  3.0.0
     */
    protected function getProfileWhereCondition($cmsUserId)
    {
        return XLite_Core_Converter::getInstance()->buildQuery(
            $this->getProfileDBFields($cmsUserId), '=', ' AND ', '\''
        ) . ' AND order_id = \'0\'';
    }

    /**
     * Return ID of LC profile associated with the passed ID of CMS profile
     * 
     * @param int $cmsUserId CMS profile ID
     *  
     * @return int
     * @access protected
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected function getProfileIdByCMSId($cmsUserId)
    {
        $profile = XLite_Model_CachingFactory::getObject(__METHOD__ . $cmsUserId, 'XLite_Model_Profile');

        // Not initialized
        if (!$profile->isRead) {
            $profile->find($this->getProfileWhereCondition($cmsUserId));
        }

        return $profile->get('profile_id');
    }


    /**
     * Return currently used CMS name
     *
     * @return string
     * @access public
     * @since  3.0.0
     */
    abstract public function getCMSName();

    /**
     * Return the default controller name 
     * 
     * @return string
     * @access public
     * @since  3.0.0
     */
    abstract public function getDefaultTarget();

    /**
     * Get landing link
     *
     * @return string
     * @access public
     * @since  3.0.0 EE
     */
    abstract public function getLandingLink();


    /**
     * Determines if we export content into a CMS
     *
     * @return bool
     * @access public
     * @since  3.0.0
     */
    public static function isCMSStarted()
    {
        return isset(self::$currentCMS);
    }

    /**
     * Save passed params in the requester 
     * 
     * @param array $request params to map
     *  
     * @return void
     * @access public
     * @see    ____func_see____
     * @since  3.0.0
     */
    public function mapRequest(array $request)
    {
        XLite_Core_Request::getInstance()->mapRequest($request);
    }

    /**
     * Handler should called this function first to prevent any possible conflicts
     *
     * @return void
     * @access public
     * @since  3.0.0
     */
    public function init()
    {
        self::$currentCMS = $this->getCMSName();
    }

    /**
     * Check if a widget requested from certain CMS
     *
     * @return bool
     * @access public
     * @since  3.0.0
     */
    public function checkCurrentCMS()
    {
        return $this->getCMSName() === self::$currentCMS;
    }

    /**
     * Return list of widgets which can be exported
     *
     * @return array
     * @access public
     * @since  3.0.0
     */
    public function getWidgetsList()
    {
        return $this->widgetsList;
    }

    /**
     * Get page types
     *
     * @return array
     * @access public
     * @since  3.0.0
     */
    public function getPageTypes()
    {
        return $this->pageTypes;
    }

    /**
     * Return application instance 
     * 
     * @param string $applicationId cache key
     *  
     * @return XLite
     * @access public
     * @see    ____func_see____
     * @since  3.0.0
     */
    public function getApplication($applicationId = null)
    {
        return XLite_Model_CachingFactory::getObjectFromCallback(
            __METHOD__ . $applicationId, XLite::getInstance(), 'run'
        );
    }

    /**
     * Return viewer for current page
     *
     * @param string $applicationId cache key
     *
     * @return XLite_View_Controller
     * @access public
     * @since  3.0.0
     */
    public function getViewer($applicationId = null)
    {
        return XLite_Model_CachingFactory::getObjectFromCallback(
            __METHOD__ . $applicationId, $this->getApplication($applicationId), 'getViewer'
        );
    }

    /**
     * Get controller 
     *
     * @param string $applicationId cache key
     * 
     * @return XLite_Controller_Abstract
     * @access public
     * @see    ____func_see____
     * @since  3.0.0
     */
    public function getController($applicationId = null)
    {
        return XLite_Model_CachingFactory::getObjectFromCallback(
            __METHOD__ . $applicationId, $this->getApplication($applicationId), 'getController'
        );
    }

    /**
     * Run controller 
     *
     * @param string $applicationId cache key
     *  
     * @return void
     * @access public
     * @see    ____func_see____
     * @since  3.0.0
     */
    public function runController($applicationId = null)
    {
        return XLite_Model_CachingFactory::getObjectFromCallback(
            __METHOD__ . $applicationId, $this->getApplication($applicationId), 'runController'
        );
    }

    /**
     * Return widget
     * 
     * @param string $class  widget class name
     * @param array  $params widget params
     * @param int    $delta  drupal-specific param - so called "delta"
     *  
     * @return XLite_Core_WidgetDataTransport
     * @access public
     * @since  3.0.0
     */
    public function getWidget($class, array $params = array(), $delta = 0)
    {
        return new XLite_Core_WidgetDataTransport(
            class_exists($class) ? $this->getViewer()->getWidget($params, $class) : null
        );
    }

    /**
     * Return controller for current page
     *
     * @param string $target controller target
     * @param array  $params controller params
     *
     * @return XLite_Core_WidgetDataTransport
     * @access public
     * @since  3.0.0
     */
    public function getPageInstance($target, array $params = array())
    {
        $class = XLite_Core_Converter::getControllerClass($target);

        return new XLite_Core_WidgetDataTransport(
            class_exists($class) ? new $class(array('target' => $target) + $params) : null
        );
    }

    /**
     * Add CMS-specific fields to profile data 
     * 
     * @param int   $cmsUserId CMS user Id
     * @param array $data      data to prepare
     *  
     * @return array
     * @access public
     * @since  3.0.0
     */
    public function prepareProfileData($cmsUserId, array $data)
    {
        return $this->getProfileDBFields($cmsUserId) + $data;
    }

    /**
     * Check and return (if allowed) current user profile
     * 
     * @param int $cmsUserId internal user ID in CMS
     *  
     * @return XLite_Model_Profile
     * @access public
     * @since  3.0.0
     */
    public function getProfile($cmsUserId)
    {
        return XLite_Model_Auth::getInstance()->getProfile($this->getProfileIdByCMSId($cmsUserId));
    }



    // -----> FIXME - to revise

    /**
     * Check controller access
     * FIXME - do not uncomment: this will break the "runFrontController()" functionality
     * TODO  - code must be refactored
     *
     * @return boolean
     * @access public
     * @since  3.0.0
     */
    public function isAllowed()
    {
        return true;

        /*$oldController = $this->getController();

        $this->getApplication()->setController();
        $controller = XLite_Model_CachingFactory::getObjectFromCallback(
            __METHOD__ . '-' . XLite_Core_Request::getInstance()->target,
            $this->getApplication(),
            'getController'
        );

        $result = $controller->checkAccess()
            && $this->getViewer()->isVisible();

        $this->getApplication()->setController($oldController);

        return $result;*/
    }

    /**
     * Get Clean URL 
     * 
     * @param array $args Arguments
     *  
     * @return string
     * @access public
     * @see    ____func_see____
     * @since  3.0.0
     */
    public function getCleanURL(array $args)
    {
        $url = null;

        if ('category' == $args['target'] && !empty($args['category_id'])) {

            // Category
            $category = new XLite_Model_Category(intval($args['category_id']));
            if ($category->isExists() && $category->get('clean_url')) {
                $url = preg_replace('/\/+$/Ss', '', $category->get('clean_url')) . '/';
            }

        } elseif ('product' == $args['target'] && !empty($args['product_id'])) {

            // Product
            $product = new XLite_Model_Product(intval($args['product_id']));
            if ($product->isExists() && $product->get('clean_url')) {
                $url = $product->get('clean_url');
                if (!preg_match('/(\.html|\/htm)$/Ss', $url)) {
                    $url .= '.html';
                }
            }

        }

        return $url;
    }

    /**
     * Get canonical URL by clean URL 
     * 
     * @param string $path Clean url
     *  
     * @return string
     * @access public
     * @see    ____func_see____
     * @since  3.0.0
     */
    public function getURLByCleanURL($path)
    {
        $cleanUrl = null;

        // By product

        $product = new XLite_Model_Product();
        if ($product->findByCleanUrl(preg_replace('/(?:\.html|\.htm)$/Ss', '', $path))) {
            $cleanUrl = XLite_Core_Converter::buildURL(
                'product',
                '',
                array('product_id' => $product->get('product_id'))
            );
        }

        // By category

        if (!$cleanUrl) {

            $category = new XLite_Model_Category();
            if ($category->findByCleanUrl(preg_replace('/\/+$/Ss', '', $path))) {
                $cleanUrl = XLite_Core_Converter::buildURL(
                    'category',
                    '',
                    array('category_id' => $category->get('category_id'))
                );
            }

        }

        return $cleanUrl;
    }

    /**
     * Get session TTL (in seconds) 
     * 
     * @return integer
     * @access public
     * @see    ____func_see____
     * @since  3.0.0
     */
    public function getSessionTtl()
    {
        return $this->session->getTtl();
    }
}

