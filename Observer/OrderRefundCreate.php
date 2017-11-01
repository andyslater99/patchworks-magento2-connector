<?php
namespace Patchworks\Connector\Observer;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

class OrderRefundCreate extends ObserverAbstract
{
    /**
     *  send REST POST request to specified callback url when a credit memo issued
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $payment = $observer->getEvent()->getData('payment');
        $creditmemo = $observer->getEvent()->getData('creditmemo');
        $data = array(
            'payment' => $payment->getData(),
            'creditmemo' => $creditmemo->getData(),
        );
        $callback_url = $this->_scopeConfig->getValue('patchworks_connector/general/order_refund_create', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $this->_api->post($callback_url, $data);
    }
}
