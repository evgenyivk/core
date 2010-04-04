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
 * @subpackage ____sub_package____
 * @author     Creative Development LLC <info@cdev.ru> 
 * @copyright  Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    SVN: $Id$
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      3.0.0
 */


/**
 * XLite_View_FormField_Input 
 * 
 * @package    XLite
 * @subpackage ____sub_package____
 * @since      3.0.0
 */
class XLite_View_FormField_Input extends XLite_View_FormField_Input_Abstract
{
    /**
     * Widget param names 
     */

    const PARAM_TYPE = 'type';


    /**
     * Define widget params
     *
     * @return void
     * @access protected
     * @since  3.0.0
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_TYPE => new XLite_Model_WidgetParam_String('Type', null),
        );
    }


    /**
     * Return field type
     * 
     * @return string
     * @access public
     * @since  3.0.0
     */
    public function getFieldType()
    {
        return $thsi->getParam(self::PARAM_TYPE);
    }
}

