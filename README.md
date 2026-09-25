# M4P Volume Pricing for PrestaShop 8 & 9

**Give a lower unit price for every full pack the customer puts in the cart — the pricing wholesale buyers expect, set per product.**

> **Meta description (151 chars):** Per-product volume pricing for PrestaShop: the unit price drops by a fixed amount for every full pack in the cart. Free MIT module for wholesale shops.

---

## Why volume pricing sells more

Wholesale buyers do not compare a single unit, they compare what a pallet costs. A price that
rewards bigger orders changes the size of the basket:

- **Bigger orders without a sales call** — the customer sees the better price while ordering
- **Fewer discount codes to manage** — the rule lives on the product, not in a campaign
- **Predictable margin** — a floor price stops the discount from eating the whole margin
- **No spreadsheets by e-mail** — the customer does not have to ask for a quote for a larger order

## What the module does

The module adds a small form to the product edit page in the back office. You set how many units
make a pack, how much the unit price drops per pack, and the lowest price the product may reach.
PrestaShop then applies that rule everywhere the price is calculated — in the cart, on the product
page and in the order.

### Key features

- **Per-product rule** — no global campaigns, every product has its own threshold and discount
- **Discount grows with the order** — two packs give twice the reduction, three give three times
- **Floor price** — the unit price never drops below the minimum you set
- **Off by default** — a product without the switch enabled keeps its normal price
- **No configuration screen** — everything is edited where it belongs, on the product

### How the price is calculated

For a pack of 10 with a discount of 2 and a unit price of 100: 10 items cost 98 each, 20 items cost
96 each, 30 items cost 94 each. With a floor price of 95, the same order stops at 95 no matter how
many packs are added.

## Compatibility

| | |
|---|---|
| PrestaShop | 1.7.6 – 9.x |
| PHP | 7.2.5+ |
| Requirements | none |
| Multistore | Prices are shared across shops |
| Themes | Works with any theme — the price is changed by PrestaShop itself |

The module performs no core overrides. It creates one table, `volumepricing`, and drops it on
uninstall.

## Installation

1. Upload and install the module from **Modules → Module Manager**.
2. Open any product in **Catalogue → Products**.
3. Scroll to the **volume pricing** section, enable it and set the pack size, the discount per pack
   and the minimum price.
4. Save the product and add that many units to a cart to check the new unit price.

## Configuration options

Everything is set per product, in the product edit page:

| Field | Description |
|---|---|
| **Enable volume pricing** | Turns the rule on for this product. |
| **Pack quantity threshold** | How many units make one pack. The discount is applied once per full pack. |
| **Discount per pack** | How much the unit price drops for each full pack, in shop currency. |
| **Min price** | The lowest unit price the discount may reach. Leave empty for no floor. |

## Frequently asked questions

**Does it work together with specific prices and customer group discounts?**
Yes. The module hooks into PrestaShop's own price calculation and works on the price that comes out
of it, so group reductions and specific prices are applied first.

**What happens with an incomplete pack?**
Only full packs count. With a pack of 10, ordering 19 units gives the one-pack discount.

**Is the lower price visible before adding to the cart?**
The price changes when the quantity is known — in the cart and in the order. The product page shows
the regular unit price, so it is worth describing the rule in the product description.

**What happens to my settings when I uninstall the module?**
The table with the rules is dropped, so uninstalling removes the configuration for every product.
Export it first if you plan to reinstall.

---

**Keywords:** PrestaShop volume pricing, wholesale discount, tiered pricing, pack discount, B2B
pricing, quantity discount PrestaShop.

## License

MIT — see [LICENSE](LICENSE). Free to use commercially, fork and modify; keep the copyright notice.

## Contributing

Bug reports and pull requests are welcome — see [CONTRIBUTING.md](CONTRIBUTING.md). For security
issues, follow [SECURITY.md](SECURITY.md) instead of opening a public issue.

---

Built by [Nice Code](https://nice-code.com/pl/produkty/sklep-b2b-prestashop) — we build B2B stores on PrestaShop.

© Nice Code sp. z o.o. (Modules4Presta) — released under the MIT license.
