<?php
namespace Patchworks\Connector\Model;

/**
 * Patchworks Connector Module for Magento 2.x
 *
 * Copyright: Patchworks Integration Limited
 * Support: support@patchworks.co.uk
 * Web: www.patchworks.co.uk
 */

use Patchworks\Connector\Api\StocklevelInterface;

class Stocklevel extends Base implements StocklevelInterface
{
    protected $debug = [];

    /**
     * Loop through all of the stock levels and inject in to the database.
     * @return array
     */
    public function getStockLevels()
    {
        $this->setupDbConnection();
        $table = $this->db->getTableName('cataloginventory_stock_item');
        $p_table = $this->db->getTableName('catalog_product_entity');
        $pi_table = $this->db->getTableName('catalog_product_entity_int');
        $status_att_id = $this->getAttributeId('status');
        $fields = [
            $table . '.product_id',
            $table . '.qty',
            $table . '.backorders',
            $table . '.is_in_stock',
            $table . '.low_stock_date',
            $table . '.manage_stock',
            $p_table . '.sku',
            $p_table . '.type_id'
        ];
        $query = 'SELECT ' . implode(', ', $fields) . ' FROM `' . $table
            . '` LEFT JOIN `' . $p_table . '` ON ' . $table . '.product_id = ' . $p_table . '.entity_id '
            . 'LEFT JOIN `' . $pi_table . '` ON ' . $table . '.product_id = ' . $pi_table . '.entity_id '
            . 'WHERE ' . $table . '.is_in_stock = 1 AND ' . $p_table . '.type_id = "simple" '
            . 'AND ' . $pi_table . '.attribute_id = ' . $status_att_id . ' AND ' . $pi_table . '.value = 1 '
            . 'AND ' . $pi_table . '.store_id = 0 GROUP BY ' . $p_table . '.entity_id';
        try {
            $stocklevels = $this->db->fetchAll($query);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
        return $stocklevels;
    }

    /**
     * Loop through all of the stock levels and inject in to the database.
     * @return array
     */
    public function setStockLevels()
    {
        $data = $this->getInputData();
        $this->debug['start_time'] = date('U');
        if (isset($data['stock_items']) && count($data['stock_items']) > 0) {
            $this->setupDbConnection();
            foreach ($data['stock_items'] as $item) {
                if (!isset($item['entity_id'])) {
                    if (!$item['entity_id'] = $this->getProductEntityId($item['sku'], 'simple')) {
                        $this->debug['failed'][] = $item['sku'];
                        continue;
                    }
                }
                $this->setStockQty($item['entity_id'], $item['qty']);
                $this->setStockStatus($item['entity_id'], $item['qty']);

                $this->debug['simple_ids'][] = $item['entity_id'];
            }
        }
//        if (count($this->debug['simple_ids']) > 0) {
//            $this->debug['config_ids'] = $this->updateConfigurables($simple_ids);
//        }
        $this->debug['end_time'] = date('U');
        return ['debug' => $this->debug];
    }

    /**
     * Set the stock status in the database.
     * @param int $entity_id
     * @param int $qty
     * @param int $stock_status
     * @param int $location
     * @return int $entity_id
     */
    protected function setStockStatus($entity_id, $qty = 0, $stock_status = 1, $location = 1)
    {
        $table = $this->db->getTableName('cataloginventory_stock_item');
        $stock_data = [
            'qty' => $qty,
            'stock_id' => $location,
            'stock_status' => $stock_status
        ];
        try {
            $this->db->insert($table, array_merge($stock_data, ['website_id' => 0, 'product_id' => $entity_id]));
        } catch (\Exception $e) {
            // -- caught Exception, try updating the record instead.
            unset($stock_data['stock_id']);
            $this->db->update($table, $stock_data, [
                'stock_id = ' . $location,
                'product_id = ' . $entity_id,
                'website_id = ' . 0
            ]);
        }
    }

    /**
     * Set the stock quantity in the database.
     * @param int $entity_id
     * @param int $qty
     * @param int $stock_status
     * @param int $location
     * @return int $entity_id
     */
    protected function setStockQty($entity_id, $qty = 0, $stock_status = 1, $location = 1)
    {
        $table = $this->db->getTableName('cataloginventory_stock_item');

        $stock_data = [
            'stock_id' => $location,
            'qty' => $qty,
            'is_in_stock' => $stock_status
        ];
        try {
            $this->db->insert($table, array_merge($stock_data, ['product_id' => $entity_id]));
        } catch (\Exception $e) {
            unset($stock_data['stock_id']);
            $this->db->update($table, $stock_data, ['stock_id = ' . $location, 'product_id = ' . $entity_id]);
        }
    }

    /**
     * Get the data thats been posted to the API
     * @return array $data
     */
    protected function getInputData()
    {
        $jsonStr = file_get_contents("php://input");
        try {
            $json = json_decode($jsonStr, true);
            return $json;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}