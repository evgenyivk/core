{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * USPS test real-time rates page template
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011-2012 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 *}

<br /><br /><br />

<div class="admin-title">Test U.S.P.S. rates calculation</div>

<br />

<form action="admin.php#test_" method="get" target="shipping_test">

  <input type="hidden" name="target" value="usps" />
  <input type="hidden" name="action" value="test" />

  <table cellpadding="3" cellspacing="0">

    <tr>
      <td colspan="2"><br /><b>Package properties</b></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;Package weight ({config.General.weight_unit}):</td>
      <td IF="!weight=##"><input type="text" name="weight" size="10" value="{weight:r}" /></td>
      <td IF="weight=##"><input type="text" name="weight" size="10" value="10" /></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;Package subtotal (USD):</td>
      <td IF="!subtotal=##"><input type="text" name="subtotal" size="10" value="{subtotal:r}" /></td>
      <td IF="subtotal=##"><input type="text" name="subtotal" size="10" value="200" /></td>
    </tr>

    <tr>
      <td colspan="2"><br /><b>Source address</b></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;Country:</td>
      <td>
        <input type="text" size="15" value="United States" disabled />
        <span IF="!config.Company.location_country=#US#"><span class="star">(!)</span> <a href="admin.php?target=settings&page=Company">Company country</a> has wrong value</span>
      </td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;Postal Code:</td>
      <td IF="!sourceZipcode=##"><input type="text" name="sourceZipcode" size="10" value="{sourceZipcode:r}" /></td>
      <td IF="sourceZipcode=##"><input type="text" name="sourceZipcode" size="10" value="{config.Company.location_zipcode:r}" /></td>
    </tr>

    <tr>
      <td colspan="3"><br /><b>Destination address</b></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;Country: {config.Shipping.anonymous_country}</td>
      <td IF="!destinationCountry=##"><widget class="\XLite\View\CountrySelect" field="destinationCountry" value="{destinationCountry}" /></td>
      <td IF="destinationCountry=##"><widget class="\XLite\View\CountrySelect" field="destinationCountry" country="{config.Shipping.anonymous_country}" fieldId="destinationCountry_select" /></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;Postal/ZIP Code:</td>
      <td IF="!sourceZipcode=##"><input type="text" name="destinationZipcode" size="10" value="{destinationZipcode:r}" /></td>
      <td IF="sourceZipcode=##"><input type="text" name="destinationZipcode" size="10" value="{config.Shipping.anonymous_zipcode:r}" /></td>
    </tr>

  </table>

  <br /><br />

  <widget class="\XLite\View\Button\Submit" label="Calculate rates" />

  <div>Note: a new window will open</div>

</form>
