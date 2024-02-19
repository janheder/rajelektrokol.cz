{**
 * Copyright 2022 ModuleFactory
 *
 * @author    ModuleFactory
 * @copyright ModuleFactory all rights reserved.
 * @license   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *}

{if $fsch_rule == 'page_type'}
    <p>
        By default every HTML Block has a <strong>"Page Type equals to Any Page"</strong> display rule.
        This configuration always returns true for testing, so this display rule won't affect the visibility of the HTML Block.
    </p>
    <p>
        If you select a specific type then the block only visible on that type of page, like only on product pages or
        only on category pages etc.
    </p>
{elseif $fsch_rule == 'category'}
    <p>
        By selecting a category, the HTML Block only visible on the selected category page.
    </p>
{elseif $fsch_rule == 'category_parent'}
    <p>
        By selecting a parent category, the HTML Block only visible on the category pages which has assigned to the selected parent category.
    </p>
{elseif $fsch_rule == 'category_children'}
    <p>
        By selecting a category, the HTML Block only visible on the category pages which are children of the selected category.
    </p>
{elseif $fsch_rule == 'product'}
    <p>
        By selecting a product, the HTML Block only visible on the selected product page.
    </p>
{elseif $fsch_rule == 'product_category'}
    <p>
        By selecting a category, the HTML Block only visible on the product pages which has assigned to the selected category.
    </p>
{elseif $fsch_rule == 'product_default_category'}
    <p>
        By selecting a default category, the HTML Block only visible on the product pages which has assigned to the selected default category.
    </p>
{elseif $fsch_rule == 'product_manufacturer'}
    <p>
        By selecting a manufacturer, the HTML Block only visible on the product pages which has assigned to the selected manufacturer.
    </p>
{elseif $fsch_rule == 'product_supplier'}
    <p>
        By selecting a supplier, the HTML Block only visible on the product pages which has assigned to the selected supplier.
    </p>
{elseif $fsch_rule == 'product_availability'}
    <p>
        Product Availability preferences, when the product is out of stock. This is only this preferences of the product, not checks for quantity.
    </p>
{elseif $fsch_rule == 'product_quantity'}
    <p>
        By setting up a quantity, the HTML Block only visible on the product pages which has met the sat up quantity criteria.
    </p>
{elseif $fsch_rule == 'product_price'}
    <p>
        By setting up a price, the HTML Block only visible on the product pages which has met the sat up price criteria. The price is the base price without taxes.
    </p>
{elseif $fsch_rule == 'product_price_specific'}
    <p>
        Visible when product has specific price (discounted):<br /> <strong>"Product has Specific Price (Discounted) equals to true"</strong>
    </p>
    <p>
        Visible when product not has specific price (not discounted):<br /> <strong>"Product has Specific Price (Discounted) not equals to true"</strong>
    </p>
{elseif $fsch_rule == 'product_available_for_order'}
    <p>
        Visible when product available for order (add to cart button displayed):<br /> <strong>"Product Available for Order equals to true"</strong>
    </p>
    <p>
        Visible when product not available for order (add to cart button not displayed):<br /> <strong>"Product Available for Order not equals to true"</strong>
    </p>
{elseif $fsch_rule == 'product_show_price'}
    <p>
        Visible when the product price is displayed:<br /> <strong>"Product Show Price equals to true"</strong>
    </p>
    <p>
        Visible when the product price is not displayed:<br /> <strong>"Product Show Price not equals to true"</strong>
    </p>
{elseif $fsch_rule == 'product_online_only'}
    <p>
        Visible when the product is available for only online purchase:<br /> <strong>"Product Online Only equals to true"</strong>
    </p>
    <p>
        Visible when the product is available for retail store purchase as well:<br /> <strong>"Product Online Only not equals to true"</strong>
    </p>
{elseif $fsch_rule == 'product_on_sale'}
    <p>
        Visible when the product "On sale" flag is checked:<br /> <strong>"Product on Sale equals to true"</strong>
    </p>
    <p>
        Visible when the product "On sale" flag is not checked:<br /> <strong>"Product on Sale not equals to true"</strong>
    </p>
{elseif $fsch_rule == 'product_condition'}
    <p>
        Visible when the product condition is the selected.
    </p>
{elseif $fsch_rule == 'product_visibility'}
    <p>
        Visible when the product visibility is the selected.
    </p>
{elseif $fsch_rule == 'product_tag'}
    <p>
        By selecting a Tag, the HTML Block only visible on the product pages which has the selected tag.
    </p>
{elseif $fsch_rule == 'product_weight'}
    <p>
        By setting up a weight (kg), the HTML Block only visible on the product pages which has met the sat up weight criteria. The weight is in kilogramm (kg).
    </p>
{elseif $fsch_rule == 'manufacturer'}
    <p>
        By selecting a manufacturer, the HTML Block only visible on the selected manufacturer page.
    </p>
{elseif $fsch_rule == 'supplier'}
    <p>
        By selecting a supplier, the HTML Block only visible on the selected supplier page.
    </p>
{elseif $fsch_rule == 'cms_page'}
    <p>
        By selecting a cms page, the HTML Block only visible on the selected cms page.
    </p>
{elseif $fsch_rule == 'cms_page_category'}
    <p>
        By selecting a cms category, the HTML Block only visible on the cms pages which has assigned to the selected cms category.
    </p>
{elseif $fsch_rule == 'cms_category'}
    <p>
        By selecting a cms category, the HTML Block only visible on the selected cms category page.
    </p>
{elseif $fsch_rule == 'customer'}
    <p>
        By selecting a customer, the HTML Block only visible when the selected customer is logged in.
    </p>
{elseif $fsch_rule == 'customer_gender'}
    <p>
        By selecting a customer gender, the HTML Block only visible when the logged in customer's gender is the selected customer gender.
    </p>
{elseif $fsch_rule == 'customer_group'}
    <p>
        By selecting a customer group, the HTML Block only visible when the current context's customer group is the selected customer group or
        the logged in customer is assigned to the selected customer group.
    </p>
{elseif $fsch_rule == 'customer_bought_product'}
    <p>
        By selecting a product, the HTML Block only visible when the logged in customer previously bought the selected product.
    </p>
{elseif $fsch_rule == 'customer_bought_category'}
    <p>
        By selecting a category, the HTML Block only visible when the logged in customer previously bought a product from the selected category.
    </p>
{elseif $fsch_rule == 'customer_newsletter_subscription'}
    <p>
        <strong>Subscribed</strong> means, the logged in customer is previously subscribed via the built-in newsletter form or via the registration form.
    </p>
    <p>
        Visible when subscribed:<br /> <strong>"Customer Newsletter Subscription equals to true"</strong>
    </p>
    <p>
        Visible when not subscribed:<br /> <strong>"Customer Newsletter Subscription not equals to true"</strong>
    </p>
{elseif $fsch_rule == 'cart_has_current_product'}
    <p>
        The HTML Block only visible when the cart contains the currently viewed product.
    </p>
{elseif $fsch_rule == 'cart_has_product'}
    <p>
        By selecting a product, the HTML Block only visible when the cart contains the selected product.
    </p>
{elseif $fsch_rule == 'cart_has_category'}
    <p>
        By selecting a category, the HTML Block only visible when the cart contains a product from the selected category.
    </p>
{elseif $fsch_rule == 'cart_total'}
    <p>
        By setting up a total amount, the HTML Block only visible when the cart total has met the sat up criteria. The cart total amount is with taxes and without shipping costs.
    </p>
{elseif $fsch_rule == 'cart_weight'}
    <p>
        By setting up a cart weight (kg), the HTML Block only visible when the cart total weight has met the sat up criteria. The weight is in kilogramm (kg).
    </p>
{elseif $fsch_rule == 'location_zone'}
    <p>
        By selecting a zone, the HTML Block only visible when the current context's zone is the selected zone or
        the logged in customer primary address's zone is the selected zone.
    </p>
{elseif $fsch_rule == 'location_country'}
    <p>
        By selecting a country, the HTML Block only visible when the current context's country is the selected country or
        the logged in customer primary address's country is the selected country.
    </p>
{elseif $fsch_rule == 'referral_url'}
    <p>
    The address of the webpage where a person clicked a link that sent them to your page.
    </p>
    <p>
    The referrer is the webpage that sends visitors to your site using a link. In other words, it's the webpage that a
    person was on right before they landed on your page.
    </p>
{elseif $fsch_rule == 'request_uri'}
    <p>
        The Request URI is the part of the URL what is after the Base URL, except the anchor (#this-is-anchor).
    </p>
    <p>
        The URl is <code>https://www.domain.com/my-content-url.html?param1=value1&amp;param2=value2#some-anchor</code>
    </p>
    <p>
        The Base URL is <code>https://www.domain.com/</code>
    </p>
    <p>
        Then the Request URI is <code>/my-content-url.html?param1=value1&amp;param2=value2</code>
    </p>
    <p>
        The Request URI is always starts with slash <code>/</code>
    </p>
{elseif $fsch_rule == 'query_string'}
    <p>
        The Request URI is the part of the URL what is after the question mark (?), except the anchor (#this-is-anchor).
    </p>
    <p>
        The URL is <code>https://www.domain.com/my-content-url.html?param1=value1&amp;param2=value2#some-anchor</code>
    </p>
    <p>
        Then the Query String is <code>param1=value1&amp;param2=value2</code>
    </p>
{elseif $fsch_rule == 'query_parameter'}
    <p>
        The Query Parameter is key-value pair in the Query String
    </p>
    <p>
        The URL is <code>https://www.domain.com/my-content-url.html?param1=value1&amp;param2=value2</code>
    </p>
    <p>
        The given URL has two query parameter: <code>param1</code>, <code>param2</code>
    </p>
    <p>
        If you want to test the <code>param1</code> value, please set the parameter name to <code>param1</code> and
        set the condition for the parameter value.
    </p>
{elseif $fsch_rule == 'currency'}
    <p>
        By selecting a currency, the HTML Block only visible when the current context's currency is the selected currency.
    </p>
{elseif $fsch_rule == 'mobile'}
    <p>
        Visible when the device is mobile:<br /> <strong>"Mobile Phone equals to true"</strong>
    </p>
    <p>
        Visible when the device is not mobile:<br /> <strong>"Mobile Phone not equals to true"</strong>
    </p>
{elseif $fsch_rule == 'tablet'}
    <p>
        Visible when the device is tablet:<br /> <strong>"Tablet equals to true"</strong>
    </p>
    <p>
        Visible when the device is not tablet:<br /> <strong>"Tablet not equals to true"</strong>
    </p>
{elseif $fsch_rule == 'desktop'}
    <p>
        Visible when the device is desktop:<br /> <strong>"Desktop equals to true"</strong>
    </p>
    <p>
        Visible when the device is not desktop:<br /> <strong>"Desktop not equals to true"</strong>
    </p>
{elseif $fsch_rule == 'date_time'}
    <p>
        By setting up a Date Time rule, the HTML Block only visible when the current date time has met the sat up criteria.
    </p>
    <p>
        Format: <strong>2022-10-14 17:00</strong>
    </p>
{elseif $fsch_rule == 'date'}
    <p>
        By setting up a Date rule, the HTML Block only visible when the current date has met the sat up criteria.
    </p>
    <p>
        Format: <strong>2022-10-14</strong>
    </p>
{elseif $fsch_rule == 'time'}
    <p>
        By setting up a Time rule, the HTML Block only visible when the current time has met the sat up criteria.
    </p>
    <p>
        Format: <strong>17:00</strong>
    </p>
{/if}
