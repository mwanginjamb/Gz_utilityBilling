<?php

/** @var yii\web\View $this */

$this->title = 'Asset Inventory';
?>
<div class="site-index">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Asset Name</th>
                <th>Asset Unique Identifier</th>
                <th>Tenant</th>
                <th>Cell Number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;
            foreach ($assets as $asset):
                $count++;
                ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $asset->asset_description ?></td>
                    <td><?= $asset->asset_unique_identifier ?></td>
                    <td><?= $asset->tenant->principle_tenant_name ?></td>
                    <td><?= $asset->tenant->cell_number ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>