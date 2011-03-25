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
 * PHP version 5.3.0
 * 
 * @category  LiteCommerce
 * @author    Creative Development LLC <info@cdev.ru> 
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   GIT: $Id$
 * @link      http://www.litecommerce.com/
 * @see       ____file_see____
 * @since     3.0.0
 */

namespace Includes\Utils;

/**
 * PHARManager 
 * 
 * @see   ____class_see____
 * @since 3.0.0
 */
abstract class PHARManager extends \Includes\Utils\AUtils
{
    /**
     * Default compression type
     */
    const COMPRESSION_TYPE = \Phar::GZ;


    /**
     * File extensions 
     * 
     * @var   array
     * @see   ____var_see____
     * @since 3.0.0
     */
    protected static $extensions = array(\Phar::GZ => 'gz', \Phar::BZ2 => 'bz2');


    // {{{ Public methods 

    /**
     * Create pack for LC core 
     * 
     * @param \XLite\Core\Pack\Distr $pack Files to pack
     *  
     * @return void
     * @access public
     * @see    ____func_see____
     * @since  3.0.0
     */
    public static function packCore(\XLite\Core\Pack\Distr $pack)
    {
        static::download($pack);
    }

    /**
     * Create pack for module
     * 
     * @param \XLite\Core\Pack\Module $pack Files to pack
     *  
     * @return void
     * @access public
     * @see    ____func_see____
     * @since  3.0.0
     */
    public static function packModule(\XLite\Core\Pack\Module $pack)
    {
        static::download($pack);
    }

    // }}}

    // {{{ PHAR-related routines

    /**
     * Download pack
     * 
     * @param \XLite\Core\Pack\APack $pack Files to pack
     *  
     * @return void
     * @access protected
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected static function download(\XLite\Core\Pack\APack $pack)
    {
        $path = LC_LOCAL_REPOSITORY . $pack->getName() . '.tar';
        $phar = static::pack($path, $pack->getDirectoryIterator(), $pack->getMetadata());

        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
        header('Content-Length: ' . filesize($path));

        echo (\Includes\Utils\FileManager::read($path));
        \Includes\Utils\FileManager::delete($path);
        exit (0);
    }

    /**
     * Create PHAR archive
     * 
     * @param string    &$name    Pack name
     * @param \Iterator $iterator Directory iterator
     * @param array     $metadata Archive description OPTIONAL
     *  
     * @return \Phar
     * @access protected
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected static function pack(&$name, \Iterator $iterator, array $metadata = array())
    {
        // To prevent existsing files usage
        \Includes\Utils\FileManager::delete($name);

        $phar = new \PharData($name);

        $phar->buildFromIterator($iterator, LC_ROOT_DIR);
        $phar->setMetadata($metadata);

        return static::compress($phar, $name);
    }

    // }}}

    // {{{ Compression

    /**
     * Check if compression is available
     * 
     * @return boolean
     * @see    ____func_see____
     * @since  3.0.0
     */
    public static function canCompress()
    {
        return \Phar::canCompress(self::COMPRESSION_TYPE);
    }

    /**
     * Check and (if available) compress TAR arctive
     * 
     * @param \PharData $phar  Archive to compress
     * @param string    &$name Archive file name
     *  
     * @return \PharData
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected static function compress(\PharData $phar, &$name)
    {
        if (static::canCompress()) {

            \Includes\Utils\FileManager::delete($name);

            if ($extension = static::getExtension()) {
                \Includes\Utils\FileManager::delete($name .= '.' . $extension);
            }

            $phar->compress(self::COMPRESSION_TYPE);
        }

        return $phar;
    }

    /**
     * Return extension for the archive file
     * 
     * @return string
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected static function getExtension()
    {
        return \Includes\Utils\ArrayManager::getIndex(static::$extensions, self::COMPRESSION_TYPE, true);
    }

    // }}}
}