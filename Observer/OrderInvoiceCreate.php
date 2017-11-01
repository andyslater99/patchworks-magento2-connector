<?php
namespace Patchworks\Connector\Observer;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

class OrderInvoiceCreate extends ObserverAbstract
{
    /**
     *  send REST POST request to specified callback url when an Invoice is created
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $invoice = $observer->getEvent()->getData('invoice');
        $callback_url = $this->_scopeConfig->getValue('patchworks_connector/general/order_invoice_create', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $this->_api->post($callback_url, $invoice->getData());
    }
}
