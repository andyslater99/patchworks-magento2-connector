<?php
namespace Patchworks\Connector\Observer;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

class CustomerUpdate extends ObserverAbstract
{
    /**
     *  send REST POST request to specified callback url when a customer is updated
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $email = $observer->getEvent()->getData('email');
        $customer = $this->_customerModel
            ->setWebsiteId($this->_storeManager->getStore()->getWebsiteId())
            ->loadByEmail($email);
        $callback_url = $this->_scopeConfig->getValue('patchworks_connector/general/customer_update', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $this->_api->post($callback_url, $customer->getData());
    }
}
