<?php

/** @var yii\web\View $this */

$this->title = 'Asset Inventory';
?>
<div class="site-index">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title fw-bold">Asset Inventory</h1>
            <p class="card-text">Below is a list of all assets along with their associated tenants.</p>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
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

        </div>
    </div>
</div>

<!-- Add data tables support -->
<?php
$script = <<<JS
    $(document).ready(function () {
        $('.table').DataTable();
    });
JS;
$this->registerJs($script);