<?php
/**
 * OptiMonk plugin for Magento 1.x
 *
 * @package     Wse_OptiMonk
 * @author      Tibor Berna
 */
class Wse_OptiMonk_Model_Observer
{
    /**
     * Listen to the event core_block_abstract_to_html_after
     *
     * @parameter Varien_Event_Observer $observer
     * @return $this
     */
    public function coreBlockAbstractToHtmlAfter($observer)
    {
        if ($this->getModuleHelper()->isEnabled() == false) {
            return $this;
        }

        $block = $observer->getEvent()->getBlock();
        if($block->getNameInLayout() == 'root') {

            $transport = $observer->getEvent()->getTransport();
            $html = $transport->getHtml();

            $script = Mage::helper('optimonk')->getHeaderScript();

            if (empty($script)) {
                return $this;
            }

            $html = preg_replace('/\<body([^\>]+)\>/', '\0'.$script, $html);

            $transport->setHtml($html);
        }

        return $this;
    }

    /**
     * @return Wse_Optimonk_Helper_Data
     */
    protected function getModuleHelper()
    {
        return Mage::helper('optimonk');
    }
}
