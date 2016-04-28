<?php
/**
 * OptiMonk plugin for Magento
 *
 * @package     Wse_OptiMonk
 */

/**
 * Class Wse_OptiMonk_Block_Entrycode
 */
class Wse_OptiMonk_Block_Entrycode extends Mage_Core_Block_Template
{
    /**
     * Return whether this module is enabled or not
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getModuleHelper()->isEnabled();
    }

    /**
     * Get the OptiMonk account ID
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getModuleHelper()->getId();
    }

    /**
     * Return a configuration value
     *
     * @param null $key
     * @param null $default_value
     *
     * @return mixed
     */
    public function getConfig($key = null, $default_value = null)
    {
        return $this->getModuleHelper()->getConfigValue($key, $default_value);
    }

    /**
     * Get the OptiMonk helper
     *
     * @return Wse_Optimonk_Helper_Data
     */
    public function getModuleHelper()
    {
        return Mage::helper('optimonk');
    }

    /**
     * Get the OptiMonk container
     *
     * @return Wse_OptiMonk_Model_Container
     */
    public function getContainer()
    {
        return Mage::getSingleton('optimonk/container');
    }

    /**
     * @return bool
     */
    public function hasAttributes()
    {
        $attributes = $this->getAttributes();
        if(!empty($attributes)) {
            return true;
        }
        return false;
    }

    /**
     * Return all attributes as JSON
     *
     * @return string
     */
    public function getAttributesAsJson()
    {
        $attributes = $this->getAttributes();
        return json_encode($attributes);
    }

    /**
     * Add a new attribute to the OM container
     *
     * @param $name
     * @param $value
     *
     * @return Varien_Object
     */
    public function addAttribute($name, $value)
    {
        return $this->getContainer()->setData($name, $value);
    }

    /**
     * Get the configured attributes for the OM container
     *
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->getContainer()->getData();
    }

    /**
     * Return a product collection
     *
     * @return bool|object
     */
    public function getProductCollection()
    {
        return false;
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function jsonEncode($data)
    {
        $string = json_encode($data);
        $string = str_replace('"', "'", $string);
        return $string;
    }

    /**
     * @param $childScript
     */
    public function setChildScript($childScript)
    {
        $this->childScript = $childScript;
    }

    /**
     * @return string
     */
    public function _toHtml()
    {
        $html = parent::_toHtml();
        if (empty($html)) {
            $html = ' ';
        }

        return $html;
    }
}
