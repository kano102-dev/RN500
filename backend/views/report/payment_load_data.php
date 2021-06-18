<?php

use yii\helpers\Html;
?>
<thead>
    <tr>
        <th> Sr. No </th>
        <th> Package </th>
        <th> Package Start Date</th>
        <th> Package End Date</th>
        <th> Lead Reference No. </th>
        <th> Payment Status </th>
        <th> Amount ($) </th>
        <th> Transaction ID </th>
        <th> Transaction Date </th>
    </tr>
</thead>

<tbody>
    <?php foreach ($data as $sr => $row) { ?>
        <tr>
            <td> <?php echo ++$sr ?> </td>
            <td> <?php echo isset($row['package']) ? $row['package'] : '' ?> </td>
            <td> <?php echo isset($row['pkg_start_date']) ? $row['pkg_start_date'] : '' ?> </td>
            <td> <?php echo isset($row['pkg_end_date']) ? $row['pkg_end_date'] : '' ?> </td>
            <td> <?php echo isset($row['lead_title']) ? Html::a($row['lead_title'], Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/view', 'id' => $row['lead_reference_no']]), ['target' => '_blank']) : '' ?> </td>
            <td> <?php echo isset($row['payment_status']) ? $row['payment_status'] : '' ?> </td>
            <td> <?php echo isset($row['amount']) ? $row['amount'] : '' ?> </td>
            <td> <?php echo isset($row['transaction_id']) ? $row['transaction_id'] : '' ?> </td>
            <td> <?php echo isset($row['transaction_date']) ? $row['transaction_date'] : '' ?> </td>
        </tr>
    <?php } ?>
</tbody>

