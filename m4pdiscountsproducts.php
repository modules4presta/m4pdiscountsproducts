<?php

/**
 * m4pdiscountsproducts
 *
 * @author    Modules4Presta <contact@modules4presta.io>
 * @copyright 2026 Nice Code sp. z o.o. (Modules4Presta)
 * @license   https://opensource.org/licenses/MIT MIT License
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class M4pDiscountsProducts extends Module
{
    public function __construct()
    {
        $this->name = 'm4pdiscountsproducts';
        $this->tab = 'pricing_promotion';
        $this->version = '1.0.0';
        $this->author = 'Modules4Presta';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->ps_versions_compliancy = ['min' => '1.7.6.0', 'max' => _PS_VERSION_];

        parent::__construct();

        $this->displayName = $this->trans('Volume Pricing', [], 'Modules.M4pdiscountsproducts.Admin');
        $this->description = $this->trans('Allows setting per-product volume discounts based on pack size.', [], 'Modules.M4pdiscountsproducts.Admin');
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('displayAdminProductsExtra')
            && $this->registerHook('actionProductUpdate')
            && $this->registerHook('actionProductPriceCalculation')
            && $this->installDb();
    }

    public function uninstall()
    {
        return $this->uninstallDb()
            && parent::uninstall();
    }

    protected function installDb()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."volumepricing` (
            `id_product` INT(10) UNSIGNED NOT NULL,
            `pack_qty` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `pack_discount` DECIMAL(13,2) NOT NULL DEFAULT 0,
            `min_price` DECIMAL(30,2) DEFAULT NULL,
            `enabled` TINYINT(1) NOT NULL DEFAULT 0,
            PRIMARY KEY (`id_product`)
        ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8;";

        return Db::getInstance()->execute($sql);
    }

    protected function uninstallDb()
    {
        $sql = "DROP TABLE IF EXISTS `"._DB_PREFIX_."volumepricing`;";
        return Db::getInstance()->execute($sql);
    }

    /**
     * Display fields in product edit page
     */
    public function hookDisplayAdminProductsExtra($params)
    {
        $id_product = (int)$params['id_product'];
        $data = Db::getInstance()->getRow(
            'SELECT * FROM `'._DB_PREFIX_.'volumepricing` WHERE id_product = '. $id_product
        );

        $this->context->smarty->assign([
            'values' => [
                'volume_enabled' => isset($data['enabled']) ? $data['enabled'] : 0,
                'volume_pack_qty' => isset($data['pack_qty']) ? $data['pack_qty'] : '',
                'volume_pack_discount' => isset($data['pack_discount']) ? $data['pack_discount'] : '',
                'volume_pack_min_price' => isset($data['min_price']) ? $data['min_price'] : '',
            ],
            'currency' => $this->context->currency,
            'currentIndex' => AdminController::$currentIndex,
        ]);

        return $this->display(__FILE__, 'views/templates/admin/volume_pricing_form.tpl');
    }

    /**
     * Save data on product update
     */
    public function hookActionProductUpdate($params)
    {
        if (!Tools::getIsset('volume_enabled')) {
            return;
        }

        $product = $params['product'];
        $id_product = (int)$product->id;

        $enabled = (int)Tools::getValue('volume_enabled');
        $pack_qty = (int)Tools::getValue('volume_pack_qty');
        $pack_discount = (float)Tools::getValue('volume_pack_discount');
        $min_price = (float) Tools::getValue('volume_pack_min_price');

        $exists = Db::getInstance()->getValue(
            'SELECT COUNT(*) FROM `'._DB_PREFIX_.'volumepricing` WHERE id_product = '. $id_product
        );

        if ($exists) {
            Db::getInstance()->update('volumepricing', [
                'enabled' => $enabled,
                'pack_qty' => $pack_qty,
                'pack_discount' => $pack_discount,
                'min_price' => $min_price,
            ], 'id_product = '. $id_product);
        } else {
            Db::getInstance()->insert('volumepricing', [
                'id_product' => $id_product,
                'enabled' => $enabled,
                'pack_qty' => $pack_qty,
                'pack_discount' => $pack_discount,
                'min_price' => $min_price,
            ]);
        }
    }

    /**
     * Adjust price in cart
     */
    public function hookActionProductPriceCalculation(&$params)
    {
        $id_product = (int)$params['id_product'];
        $qty = (int)$params['quantity'];
        $data = Db::getInstance()->getRow(
            'SELECT * FROM `'._DB_PREFIX_.'volumepricing` WHERE id_product = '. $id_product
        );

        if ($data && $data['enabled'] && $data['pack_qty'] > 0 && $qty >= $data['pack_qty']) {
            $packs = floor($qty / (int)$data['pack_qty']);
            $discount_per_item = $packs * (float) $data['pack_discount'];
            $new_price = max((float)$params['price'] - $discount_per_item, 0);

            if (
                !empty($data['min_price'])
                && $new_price < (float) $data['min_price']
            ) {
                $params['price'] = (float) $data['min_price'];
            } elseif ($new_price > 0) {
                $params['price'] = $new_price;
            } else {
                $maxQtyWithPriceAboveZero = floor((float) $params['price'] / (float) $data['pack_discount']);
                $params['price'] = (float) $params['price'] - ($maxQtyWithPriceAboveZero * (float) $data['pack_discount']);
            }
        }
    }
}
