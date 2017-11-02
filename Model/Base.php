<?php
namespace Patchworks\Connector\Model;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

use Magento\Backend\App\Action\Context;
USE \Magento\Framework\App\ResourceConnection;

class Base
{
    /** @var \Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION */
    protected $db = false;

    /** @var ResourceConnection */
    protected $_resource;

    public function __construct(Context $context, ResourceConnection $resource)
    {
        $this->_resource = $resource;
    }

    /**
     * Get the database connection.
     * @return object
     */
    protected function setupDbConnection()
    {
        $this->db = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
    }

    /**
     * Get the product entity id from the database based on the SKU.
     * @param string $sku
     * @param string $type_id
     * @return int $entity_id
     */
    protected function getProductEntityId($sku, $type_id = 'simple')
    {
        $entity_id = $this->db->fetchOne($this->db->select()->from('catalog_product_entity',
            'entity_id')->where('sku = ?', $sku)->limit(1));
        return $entity_id;
    }

    /**
     * Return attribute id from given attribute code
     * @param $attribute_code
     */
    public function getAttributeId($attribute_code, $entity_type_id=4)
    {
        $this->setupDbConnection();
        $attribute_id = $this->db->fetchOne($this->db->select()->from('eav_attribute', 'attribute_id')
            ->where('attribute_code = ?', $attribute_code)->where('entity_type_id = ?', $entity_type_id)->limit(1));
        return $attribute_id;
    }
}