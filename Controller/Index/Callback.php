<?php
namespace Patchworks\Connector\Controller\Index;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

class Callback extends \Magento\Framework\App\Action\Action
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
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Receive standard callback data. for callback testing purposes
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $postData = $this->getRequest()->getPost();
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($postData);
    }
}
