<thead>
    <tr>
        <th> Sr. No </th>
        <th> Lead With Reference</th>
        <th> Sender Name </th>
        <th> Sender Email </th>
        <th> Recipient Name </th>
        <th> Recipient Email </th>
    </tr>
</thead>
<tbody>
    <?php foreach ($models as $sr => $model) { ?>
        <tr>
            <td> <?php echo ++$sr ?></td>
            <td> <a href="<?php echo Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/view', 'id' => $model->getLeadReference()]) ?>" target="_blank"><?php echo $model->leadTitleWithRef ?> </a></td>
            <td> <?php echo $model->from_name ?></td>
            <td> <?php echo $model->from_email ?></td>
            <td> <?php echo $model->to_name ?></td>
            <td> <?php echo $model->to_email ?></td>
        </tr>
    <?php } ?>
</tbody>

