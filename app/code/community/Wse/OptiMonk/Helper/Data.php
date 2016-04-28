<?php
/**
 * optimonk plugin for Magento
 *
 * @package     Wse_OptiMonk
 * @author      Tibor Berna
 */

/**
 * Class Wse_Optimonk_Helper_Data
 */
class Wse_Optimonk_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Check whether the module is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        if ((bool)Mage::getStoreConfig('advanced/modules_disable_output/Wse_OptiMonk')) {
            return false;
        }

        return (bool)$this->getConfigValue('active', false);
    }

    /**
     * Return the OptiMonk ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->getConfigValue('id');
    }

    /**
     * Return a configuration value
     *
     * @param null $key
     * @param null $default_value
     *
     * @return mixed|null
     */
    public function getConfigValue($key = null, $default_value = null)
    {
        $value = Mage::getStoreConfig('optimonk/settings/' . $key);
        if (empty($value)) {
            $value = $default_value;
        }

        return $value;
    }

    /**
     * Fetch a specific block
     *
     * @param $name
     * @param $type
     * @param $template
     *
     * @return bool|Mage_Core_Block_Template
     */
    public function fetchBlock($name, $type, $template)
    {
        /** @var Mage_Core_Model_Layout $layout */
        if (!($layout = Mage::app()->getFrontController()->getAction()->getLayout())) {
            return false;
        }

        /** @var Mage_Core_Block_Template $block */
        if ($block = $layout->getBlock('optimonk_' . $name)) {
            $block->setTemplate('optimonk/' . $template);

            return $block;
        }

        if ($block = $layout->createBlock('optimonk/' . $type)) {
            $block->setTemplate('optimonk/' . $template);

            return $block;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getHeaderScript()
    {
        $cartScript = '';
        $block = $this->fetchBlock('entrycode', 'entrycode', 'entrycode.phtml');

        if (!$block) {
            return $cartScript;
        }

        $cartScript .= $this->getCartScript();

        $block->setChildScript($cartScript);
        $html = $block->toHtml();

        return $html;
    }

    /**
     * @return string
     */
    public function getCartScript()
    {
        /** @var Mage_Sales_Model_Quote $quote */
        $quote = Mage::getModel('checkout/cart')->getQuote();

        if ($quote->getId() > 0) {
            $cartBlock = $this->fetchBlock('cart', 'cart', 'cart.phtml');

            if ($cartBlock) {
                $cartBlock->setQuote($quote);
                $html = $cartBlock->toHtml();

                return $html;
            }
        }

        return "";
    }
}
