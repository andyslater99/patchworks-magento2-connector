<?php
namespace Patchworks\Connector\Api;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

interface StocklevelInterface
{
    /**
     * Set the stock levels on mass.
     * @return mixed
     */
    public function setStockLevels();

    /**
     * Get the stock levels on mass.
     * @return mixed
     */
    public function getStockLevels();
}