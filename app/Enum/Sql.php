<?php

namespace App\Enum;

enum Sql:string
{
    case WORKERS_BY_ORDER_TYPES = "
    SELECT

    workers.id,
    workers.name,
    workers.second_name,
    workers.surname,
    workers.phone,
    workers.created_at,
    workers.updated_at,
     JSON_ARRAYAGG(
        JSON_OBJECT(
            'id', order_types.id,
            'name', order_types.name
        )
    ) as order_types

    FROM workers
    LEFT JOIN worker_ex_order_types ON workers.id = worker_ex_order_types.worker_id
    INNER JOIN order_types ON worker_ex_order_types.order_type_id = order_types.id
    WHERE order_types.id NOT IN (:idOrderTypesCollection)
    GROUP BY workers.id
    HAVING COUNT(worker_ex_order_types.order_type_id) <= :countOrderTypes";

}
