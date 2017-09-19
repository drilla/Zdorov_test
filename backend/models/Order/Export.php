<?php
/**
 * Created by PhpStorm.
 * User: drilla
 * Date: 19.09.17
 * Time: 22:08
 */

namespace backend\models\Order;

use common\models\Order;

abstract class Export
{
    public static function getReadableFilename() {
        $nowDate = new \DateTimeImmutable();
        $name = 'order_list_' . $nowDate->format('d_m_y') . '.csv';

        return $name;
    }

    /**
     * вернет путь к файлу
     *
     * @param Order[] $orders
     */
    public static function generateCsv(array $orders) : string {

        $file = tempnam('/tmp', 'export_');

        $resource = fopen($file, 'w+');
        foreach ($orders as $order) {
            $data = [
                $order->id,
                $order->client_name,
                $order->getProduct()->name,
                $order->getProduct()->price,
                $order->client_phone,
                $order->status
            ];

            fputcsv($resource, $data, ',');
        }

        return $file;
    }
}