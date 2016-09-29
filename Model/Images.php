<?php
namespace Patchworks\Connector\Model;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

use Patchworks\Connector\Api\ImageInterface;

class Images implements ImageInterface
{

    protected $request;
    protected $directory_list;
    protected $images = [];

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Filesystem\DirectoryList $directory_list
    ) {
        $this->request = $context->getRequest();
        $this->directory_list = $directory_list;
    }

    /**
     * Find images in the media/import/ folder based on the SKU code.
     */
    public function imageSearch()
    {
        $sku = $this->getPostedSku();
        $location = $this->getImportDir();
        $file_types = $this->getFileTypes();

        $result = $this->searchForFiles($sku, $location);
        if (count($result) > 0) {
            $output = [];
            foreach ($result as $image) {
                if ($this->isAllowedImage($image, $file_types)) {
                    $output[] = $image;
                }
            }
        } else {
            $output = ['status' => false, 'message' => 'No images found.'];
        }
        return $output;
    }

    /**
     * Check if the image found is in the correct (allowed) format.
     */
    protected function isAllowedImage($filename, $allowed_types)
    {
        $file_extension = explode('.', $filename);
        $file_extension = end($file_extension);
        if (in_array($file_extension, $allowed_types)) {
            return true;
        }
        return false;
    }

    /**
     * Search in a give path for files that begin with a certain value.
     */
    protected function searchForFiles($lookup, $location)
    {
        $result = glob($location . $lookup . "*");
        return $result;
    }

    /**
     * Return the path to the media/import folder.
     */
    protected function getImportDir()
    {
        return $this->directory_list->getPath('media') . DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR;
    }

    /**
     * Get array of allowed file extensions for the images.
     */
    protected function getFileTypes()
    {
        return ['jpg', 'jpeg', 'tiff', 'gif'];
    }

    /**
     * Get the SKU code from the posted variables, throw exception if not present.
     */
    protected function getPostedSku()
    {
        $params = $this->getPost();
        if (!isset($params['sku'])) {
            throw new \Exception('No SKU code detected.');
        }
        return $params['sku'];
    }

    /**
     * Get the post variables.
     */
    protected function getPost()
    {
        return $this->request->getParams();
    }
}