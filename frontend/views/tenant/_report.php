<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <section class="main"
        style="margin: 3em 3em; display: flex;flex-direction: column; align-items:center;justify-content: center;">

        <h1>Rental Invoice</h1>
        <h2><?= $line->tenant->unit->property->name ?> </h2>

        <table>
            <tr>
                <td><b>Unit<b></td>
                <td><?= $line->tenant->house_number ?></td>
            </tr>
            <tr>
                <td><b>Pay Period<b></td>
                <td><?= $line->paymentheader->payperiod->body ?></td>
            </tr>
            <tr>
                <td><b>Tenant Name<b></td>
                <td><?= $line->tenant_name ?></td>
            </tr>
        </table>


        <br>

        <h3>Water Utilization</h3>

        <table>
            <thead>
                <tr>
                    <td><b>Opening Readings</b></td>
                    <td><b>Closing Readings</b></td>
                    <td><b>Unit Consumed</b></td>
                    <td><b>Cost Per Unit</b></td>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $line->opening_water_readings ?></td>
                    <td><?= $line->closing_water_readings ?></td>
                    <td><?= $line->units_used ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($line->agreed_water_rate, 'Ksh') ?></td>
                </tr>
            </tbody>
        </table>
        <br>

        <h2>Payment Details</h2>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rent</td>
                    <td><?= Yii::$app->formatter->asCurrency($line->agreed_rent_payable, 'Ksh.') ?></td>
                </tr>
                <tr>
                    <td>Water Utility Bill</td>
                    <td><?= Yii::$app->formatter->asCurrency($line->water_bill, 'Ksh') ?></td>
                </tr>
                <tr>
                    <td>Garbage Collection</td>
                    <td><?= Yii::$app->formatter->asCurrency($line->service_charge, 'Ksh') ?></td>
                </tr>
                <tr></tr>
                <tr>
                    <td><b>Total</b></td>
                    <td><b><?= Yii::$app->formatter->asCurrency(($line->agreed_rent_payable + $line->water_bill + $line->service_charge), 'Ksh.') ?>
                        </b></td>
                </tr>
            </tbody>
        </table>

        <br>

        <h3>Pay Via</h3>

        <table>
            <tr>
                <th>Paybill</th>
                <td>xxxxxxx</td>
            </tr>
            <tr>
                <th>Account Number</th>
                <td>yyyyyyy</td>
            </tr>

        </table>


        <br>

        <address>
            <strong><?= env('DEVELOPER') ?></strong>
            &copy; <?= date('Y') ?> All rights reserved.
        </address>

    </section>
</body>

</html>