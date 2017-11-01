<?php
namespace Patchworks\Connector\Observer;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

class CustomerDelete extends ObserverAbstract
{
    /**
     *  send REST POST request to specified callback url when a customer is deleted
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getEvent()->getData('customer');
        $callback_url = $this->_scopeConfig->getValue('patchworks_connector/general/customer_delete', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $this->_api->post($callback_url, $customer->getData());
    }
}
