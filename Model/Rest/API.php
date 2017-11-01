<?php
namespace Patchworks\Connector\Model\Rest;

use Magento\Framework\HTTP\Client\Curl;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

class API
{
    const LOG_BEFORE = 'Sent Data';
    const LOG_AFTER = 'Received Response';
    const LOG_ERROR = 'Error';

    protected $_curl;
    protected $_context;
    protected $_storeManager;
    protected $_logger;
    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Curl $curl,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_context = $context;
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
        $this->_curl = $curl;
        $this->_logger = $logger;
    }

    /**
     * send REST POST request to external URL
     *
     */
    public function post($url, $data)
    {
        try {
            $this->logger(self::LOG_BEFORE, $url, $data);
            $this->_curl->post($url, $data);
            $response = $this->_curl->getBody();
            $this->logger(self::LOG_AFTER, $url, array('body' => $response));
        }
        catch (Exception $e) {
            $this->logger(self::LOG_ERROR, $url, array('error_msg' => $e->getMessage()));
        }
    }

    /**
     * log sent/received data if debug mode enabled
     *
     */
    public function logger($type, $url, $data)
    {
        if ($this->_scopeConfig->getValue('patchworks_connector/general/logger', \Magento\Store\Model\ScopeInterface::SCOPE_STORE)) {
            $level = 'DEBUG';
            $message = "[Patchworks Connector] {$type} {$url} ";
            $this->_logger->log($level, $message, $data);
        }
    }
}
