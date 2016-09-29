<?php
namespace Patchworks\Connector\Api;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

interface ImageInterface
{
    /**
     * Search the media/import folder for images to import.
     * @return mixed
     */
    public function imageSearch();
}