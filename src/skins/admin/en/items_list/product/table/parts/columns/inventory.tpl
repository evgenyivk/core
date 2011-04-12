{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Item price
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   GIT: $Id$
 * @link      http://www.litecommerce.com/
 * @since     1.0.0
 * @ListChild (list="itemsList.product.table.admin.search.columns", weight="70")
 *}

<td>
  <input type="text" class="inventory" size="10" value="{product.inventory.getAmount():r}" name="{getNamePostedData(#amount#,product.getProductId())}" disabled="{!product.inventory.getEnabled()}" />
</td>
