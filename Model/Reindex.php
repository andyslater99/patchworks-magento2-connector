<?php
namespace Patchworks\Connector\Model;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

use Patchworks\Connector\Api\ReindexInterface;

class Reindex implements ReindexInterface
{

    protected $request;
    protected $indexer_factory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Indexer\Model\IndexerFactory $indexer_factory
    ) {
        $this->request = $context->getRequest();
        $this->indexer_factory = $indexer_factory;
    }

    public function reindexData()
    {
        $start = date('U');
        try {
            $indexer = $this->indexer_factory->create();
            $indexer->load($this->getReindexType());
            $indexer->reindexAll();
        } catch (\Exception $e) {
            throw new \Exception('Cant run the reindex process: ' . $e->getMessage());
        }
        return ['status' => 'complete', 'runtime' => $this->calculateRuntime($start)];
    }

    /**
     * Current time minus the start time to give run time.
     */
    protected function calculateRuntime($start)
    {
        return (date('U') - $start);
    }

    /**
     * Get the reindex type from the posted variables, throw exception if not present.
     */
    protected function getReindexType()
    {
        $params = $this->getPost();
        if (!isset($params['index'])) {
            throw new \Exception('No reindex type detected.');
        }
        return $params['index'];
    }

    /**
     * Get the post variables.
     */
    protected function getPost()
    {
        return $this->request->getParams();
    }
}