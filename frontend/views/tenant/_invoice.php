<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 10:59 PM
 */

use yii\bootstrap4\Html;

/* @var $this yii\web\View */

$this->title = 'Invoice Print-Out';

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Rental Invoice</h3>
            </div>
            <div class="card-body">

                <?php
                if (is_null($content)) {
                    print '<p class="alert alert-info">Invoice report is Not Available. </p>';
                }
                if ($content) { ?>
                    <iframe src="data:application/pdf;base64,<?= $content; ?>" height="950px" width="100%"></iframe>
                <?php } ?>
            </div>
        </div>
    </div>
</div>