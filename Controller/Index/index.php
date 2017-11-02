<?php
namespace Patchworks\Connector\Controller\Index;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var  \Magento\Framework\View\Result\Page
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * Show that the module has been installed.
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $response = [
            'message' => __('Patchworks Connector Installed')
        ];
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($response);
    }
}
