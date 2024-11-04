<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/21/2020
 * Time: 2:39 PM
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Alert;
use frontend\assets\AdminlteAsset;

AdminlteAsset::register($this);

$webroot = Yii::getAlias(@$webroot);
$absoluteUrl = \yii\helpers\Url::home(true);


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.75">


    <!-- PWA SHIT -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#134474">
    <link rel="apple-touch-icon" href="/images/manifest/96.png" />
    <meta name="apple-mobile-web-app-status-bar" content="#01A54F">
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?= \yii\helpers\Url::home(true) ?>/images/icons/apple-touch-icon.webp">
    <link rel="icon" type="image/webp" sizes="32x32"
        href="<?= \yii\helpers\Url::home(true) ?>/images/icons/favicon-32x32.webp">
    <link rel="icon" type="image/webp" sizes="16x16"
        href="<?= \yii\helpers\Url::home(true) ?>/images/icons/favicon-16x16.webp">
    <link rel="icon" type="image/webp" href="<?= \yii\helpers\Url::home(true) ?>/images/icons/favicon.webp">

    <!-- / PWA SHIT -->


    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
    <style>
        @viewport {
            zoom: 0.75;
            min-zoom: 0.5;
            max-zoom: 0.9;
        }
    </style>
</head>

<?php $this->beginBody() ?>

<body class="hold-transition sidebar-mini layout-fixed accent-info">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-info">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?= $absoluteUrl ?>site" class="nav-link">Home</a>
                    </li>

                    <?php if (Yii::$app->controller->id == 'applicantprofile') { ?>

                        <li class="nav-item d-none d-sm-inline-block">
                            <?= Html::a('My Applications', ['utility/applications'], ['class' => "nav-link"]) ?>

                        </li>

                    <?php } ?>

                <?php endif; ?>
                <!--<li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>-->
            </ul>

            <!-- SEARCH FORM -->
            <!--<form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>-->

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto ">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <!--<i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>-->
                    </a>

                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-th-large"></i>

                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!--<span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>-->






                        <div class="dropdown-divider"></div>
                        <?= (!Yii::$app->user->isGuest) ? Html::a('<i class="fas fa-user mx-1"></i> Profile', '/employee', ['class' => 'dropdown-item']) : ''; ?>
                        <div class="dropdown-divider"></div>
                        <?= (!Yii::$app->user->isGuest) ? Html::a('<i class="fas fa-users mx-1"></i> UTAP Team', '/site/credits', ['class' => 'dropdown-item', 'title' => 'Credits: UTAP/ Employee Self Service Portal Development Team', 'target' => '_blank']) : ''; ?>
                        <div class="dropdown-divider"></div>
                        <?= (!Yii::$app->user->isGuest) ? Html::a('<i class="fas fa-users mx-1"></i> Help Desk', '/issue/create', ['class' => 'dropdown-item', 'title' => 'ESS Help Desk: Escalate any ESS issue via this facility', 'target' => '_blank']) : ''; ?>
                        <div class="dropdown-divider"></div>
                        <?= (!Yii::$app->user->isGuest) ? Html::a('<i class="fas fa-sign-out-alt mx-1"></i> Logout (' . \Yii::$app->user->id . ')', '/site/logout/', ['class' => 'dropdown-item']) : ''; ?>
                        <div class="dropdown-divider"></div>
                        <?= (Yii::$app->user->isGuest) ? Html::a('<i class="fas fa-lock-open mx-1"></i> Login', '/site/login/', ['class' => 'dropdown-item']) : ''; ?>






                    </div>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="false" href="#">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>-->
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-dark-info">
            <!-- Brand Logo -->
            <a href="<?= $absoluteUrl ?>site" class="brand-link">
                <!--<img src="<?= $webroot ?>/images/Logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                     style="opacity: .8">-->
                <span class="brand-text font-weight-light"><b><?= Yii::$app->params['generalTitle'] ?></b></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?/*= $webroot */ ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?/*= $absoluteUrl */ ?>employee/" class="d-block"><?/*= (!Yii::$app->user->isGuest)? ucwords($employee->First_Name.' '.$employee->Last_Name): ''*/ ?></a>
                    </div>
                </div>-->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->


                        <!--Approval Management -->
                        <?php if (1): ?>
                            <li
                                class="nav-item has-treeview <?= Yii::$app->utility->currentCtrl('approvals') ? 'menu-open' : '' ?>">

                                <a href="#"
                                    class="nav-link <?= Yii::$app->utility->currentCtrl('approvals') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p>
                                        Properties
                                        <i class="fas fa-angle-left right"></i>
                                        <span
                                            class="badge badge-info right"><?= Yii::$app->dashboard->countProperties() ?></span>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>property"
                                            class="nav-link <?= Yii::$app->utility->currentaction('property', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p>List</p>
                                            <span
                                                class="badge badge-info right"><?= Yii::$app->dashboard->countProperties() ?></span>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        <?php endif; ?>
                        <!--end Aprroval Management-->

                        <!-- Leave -->
                        <li
                            class="nav-item has-treeview  <?= Yii::$app->utility->currentCtrl(['tenant']) ? 'menu-open' : '' ?>">
                            <a href="#"
                                class="nav-link <?= Yii::$app->utility->currentCtrl('tenant') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-paper-plane"></i>
                                <p>
                                    Tenants
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>tenant"
                                        class="nav-link <?= Yii::$app->utility->currentaction('tenant', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-door-open nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <!-- Fleet mgt -->


                        <li
                            class="nav-item has-treeview  <?= Yii::$app->utility->currentCtrl(['payperiod', 'payperiodstatus']) ? 'menu-open' : '' ?>">
                            <a href="#"
                                class="nav-link <?= Yii::$app->utility->currentCtrl(['payperiod', 'payperiodstatus']) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-car"></i>
                                <p>
                                    Invoicing
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>payperiod"
                                        class="nav-link <?= Yii::$app->utility->currentaction('payperiod', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-car nav-icon"></i>
                                        <p>Payperiods List</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <!--<li class="breadcrumb-item"><a href="site">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>-->
                                <?=
                                    Breadcrumbs::widget([
                                        'itemTemplate' => "<li class=\"breadcrumb-item\"><i>{link}</i></li>\n", // template for all links
                                        'homeLink' => [
                                            'label' => Yii::t('yii', 'Home'),
                                            'url' => Yii::$app->homeUrl,
                                        ],
                                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                    ])
                                    ?>
                            </ol>

                        </div><!-- /.col-6 bread ish -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?= \common\widgets\Alert::widget() ?>
                    <?= $content ?>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->


        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; <?= Yii::$app->params['generalTitle'] ?> - <?= date('Y') ?> <a href="#">
                    <?= strtoupper(Yii::$app->params['demoCompany']) ?></a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b><?= Yii::signature() ?></b>
            </div>
        </footer>


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-light">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->




    </div>

</body>


<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage(); ?>