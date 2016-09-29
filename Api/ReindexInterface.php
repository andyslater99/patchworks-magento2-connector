<?php
namespace Patchworks\Connector\Api;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

interface ReindexInterface
{

    /**
     * Trigger a reindex remotely.
     * @param string $indexer
     * @return mixed
     */
    public function reindexData();
}