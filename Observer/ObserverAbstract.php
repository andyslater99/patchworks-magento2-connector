<?php

namespace Patchworks\Connector\Observer;

use Magento\Framework\Event\ObserverInterface;
use Patchworks\Connector\Model\Rest\API as Api;

class ObserverAbstract implements ObserverInterface
{
    protected $_context;
    protected $_catalogHelper;
    protected $_customerSession;
    protected $_customerModel;
    protected $_storeManager;
    protected $_api;
    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Helper\Data $catalogHelper,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Customer $customerModel,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Api $api,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_context = $context;
        $this->_catalogHelper = $catalogHelper;
        $this->_customerSession = $customerSession;
        $this->_customerModel = $customerModel;
        $this->_storeManager = $storeManager;
        $this->_api = $api;
        $this->_scopeConfig = $scopeConfig;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        // child class will implement this one
    }
}
