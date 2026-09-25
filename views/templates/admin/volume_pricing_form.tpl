{**
 * m4pdiscountsproducts
 *
 * @author    Modules4Presta <contact@modules4presta.io>
 * @copyright 2026 Nice Code sp. z o.o. (Modules4Presta)
 * @license   https://opensource.org/licenses/MIT MIT License
 *}

<div class="panel mt-4">
    <div class="alert alert-info">{l s='Remember to keep an eye on the quantity of products, because if the quantity is lower than the one entered in the “Package quantity threshold” field, the discount will not be calculated.' d='Modules.M4pdiscountsproducts.Admin'}</div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="volume_enabled">
            {l s='Enable volume pricing' d='Modules.M4pdiscountsproducts.Admin'}
        </label>
        <div class="col-sm-9">
            <div class="switch">
            <input type="radio" name="volume_enabled" id="volume_enabled_on" value="1" {if $values.volume_enabled}checked{/if} />
            <label for="volume_enabled_on">{l s='Yes' d='Modules.M4pdiscountsproducts.Admin'}</label>
            <input type="radio" name="volume_enabled" id="volume_enabled_off" value="0" {if !$values.volume_enabled}checked{/if} />
            <label for="volume_enabled_off">{l s='No' d='Modules.M4pdiscountsproducts.Admin'}</label>
            <a class="slide-button btn"></a>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="volume_pack_qty">
            {l s='Pack quantity threshold' d='Modules.M4pdiscountsproducts.Admin'}
        </label>
        <div class="col-sm-9">
            <input type="number" name="volume_pack_qty" id="volume_pack_qty" value="{$values.volume_pack_qty}" min="1" class="form-control" />
            <small>{l s='Enter how often you want the product price to decrease.' d='Modules.M4pdiscountsproducts.Admin'}</small>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="volume_pack_discount">
            {l s='Discount per pack (in currency)' d='Modules.M4pdiscountsproducts.Admin'}
        </label>

        <div class="col-sm-9">
            <div class="input-group">
                <input type="text" name="volume_pack_discount" id="volume_pack_discount" value="{$values.volume_pack_discount}" class="form-control" aria-describedby="basic-currency" />

                <div class="input-group-append">
                    <span class="input-group-text" id="basic-currency">{$currency->sign}</span>
                </div>
            </div>

            <small>{l s='The price for one unit of the product will be reduced by the specified amount for each number of packages added.' d='Modules.M4pdiscountsproducts.Admin'}</small>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="volume_pack_min_price">
            {l s='Min price per pack (in currency)' d='Modules.M4pdiscountsproducts.Admin'}
        </label>

        <div class="col-sm-9">
            <div class="input-group">
                <input type="text" name="volume_pack_min_price" id="volume_pack_min_price" value="{$values.volume_pack_min_price}" class="form-control" aria-describedby="basic-currency" />

                <div class="input-group-append">
                    <span class="input-group-text" id="basic-currency">{$currency->sign}</span>
                </div>
            </div>

            <small>{l s='Minimal price of product which can be after discounts.' d='Modules.M4pdiscountsproducts.Admin'}</small>
        </div>
    </div>
</div>
