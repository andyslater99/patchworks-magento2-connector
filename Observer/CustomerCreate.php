<?php
namespace Patchworks\Connector\Observer;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

class CustomerCreate extends ObserverAbstract
{
    /**
     *  send REST POST request to specified callback url when a new customer is created
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getEvent()->getData('customer');
        $customer_data = array(
            'created_in' => $customer->getCreatedIn(),
            'email' => $customer->getEmail(),
            'firstname' => $customer->getFirstname(),
            'lastname' => $customer->getLastname(),
            'store_id' => $customer->getStoreId(),
            'website_id' => $customer->getWebsiteId(),
            'group_id' => $customer->getGroupId(),
            'created_at' => $customer->getCreatedAt(),
            'updated_at' => $customer->getUpdatedAt(),
            'confirmation' => $customer->getConfirmation(),
            'id' => $customer->getId()
        );
        $callback_url = $this->_scopeConfig->getValue('patchworks_connector/general/customer_create', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $this->_api->post($callback_url, $customer_data);
    }
}
