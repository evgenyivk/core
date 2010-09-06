{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Products list (table variant)
 *  
 * @author    Creative Development LLC <info@cdev.ru> 
 * @copyright Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   SVN: $Id$
 * @link      http://www.litecommerce.com/
 * @since     3.0.0
 *}

<table class="list-body list-body-table">

  <tr>
    {displayListPart(#title#)}
  </td>

  <tr FOREACH="getPageData(),product" class="info">
    {displayListPart(#info#,_ARRAY_(#product#^product))}
  </tr>

  {displayListPart(#items#)}

</table>
