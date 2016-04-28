<?php
/**
 * OptiMonk plugin for Magento
 *
 * @package     Wse_OptiMonk
 * @author      Tibor Berna
 */

/**
 * Class Wse_OptiMonk_Block_Cart
 */
class Wse_OptiMonk_Block_Cart extends Wse_OptiMonk_Block_Entrycode
{
    /**
     * Return all cart/quote items as array
     *
     * @return string
     */
    public function getProducts()
    {
        /** @var Mage_Sales_Model_Quote $quote */
        $quote = $this->getQuote();
        if (empty($quote)) {
            return array();
        }

        $data = array();
        foreach($quote->getAllVisibleItems() as $item) {
            /** @var Mage_Sales_Model_Quote_Item $item */
            $product = $item->getProduct();

            $data[$item->getSku()] = array(
                "product_id" => $product->getId(),
                "name" => $product->getName(),
                "price" => $item->getPrice(),
                "row_total" => $item->getRowTotal(),
                "quantity" => $item->getQty(),
                "category_ids" => "|" . implode("|", $product->getCategoryIds()) . "|"
            );
        }

        return $data;
    }

    /**
     * Return all quote items as JSON
     *
     * @return string
     */
    public function getItemsAsJson()
    {   
        return json_encode($this->getProducts());
    }
}
