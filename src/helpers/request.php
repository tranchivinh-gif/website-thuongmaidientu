<?php

include_once __DIR__ . "/../controller/RequestCtrl.php";


function renderCustomerRequestByOrderID($orderid, $productid)
{
    $requestCtrl = new RequestCtrl();

    $result = $requestCtrl->getCustomerRequestByOrderID($orderid, $productid);

    // check success
    if (!$result["success"]) {
        echo "<tr><td colspan='8'>{$result["message"]}</td></tr>";
        return;
    }

    $requests = $result["customerrequestlist"];

    if (empty($requests)) {
        echo "<tr><td colspan='8'>Không có yêu cầu nào</td></tr>";
        return;
    }

    foreach ($requests as $item) {
        echo "<tr>";

        echo "<td>{$item["RequestID"]}</td>";
        echo "<td>{$item["UserName"]}</td>";
        echo "<td>{$item["Phone"]}</td>";
        echo "<td>{$item["Title"]}</td>";
        echo "<td>{$item["Content"]}</td>";

        // ảnh
        if (!empty($item["Image"])) {
            echo "<td><img class = 'img' src='{$item["Image"]}' width='80'></td>";
        } else {
            echo "<td>Không có ảnh</td>";
        }

        echo "<td>
               <button>duyệt</button>
                <button>không duyệt</button>
              </td>";

        echo "</tr>";
    }
}
