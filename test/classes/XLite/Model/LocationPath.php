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
 * @subpackage Model
 * @author     Creative Development LLC <info@cdev.ru> 
 * @copyright  Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    SVN: $Id$
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      3.0.0
 */

/**
 * Current location path
 * 
 * @package XLite
 * @see     ____class_see____
 * @since   3.0.0
 */
class XLite_Model_LocationPath extends XLite_Base
{
    /**
     * List of location nodes 
     * 
     * @var    array
     * @access protected
     * @since  3.0.0
     */
    protected $nodes = array();

    /**
     * Set the params 
     * 
     * @param array $nodes list of location nodes
     *  
     * @return void
     * @access public
     * @since  3.0.0
     */
    public function __construct(array $nodes = array())
    {
        if (!empty($nodes)) {
            $this->nodes = $nodes;
        }
    }

    /**
     * Add location node 
     * 
     * @param XLite_Model_Location $node location node
     *  
     * @return void
     * @access public
     * @since  3.0.0
     */
    public function addNode(XLite_Model_Location $node)
    {
        $this->nodes[] = $node;
    }

    /**
     * Return list of location nodes
     * 
     * @return array
     * @access public
     * @since  3.0.0
     */
    public function getNodes()
    {
        return $this->nodes;
    }
}
