<!DOCTYPE html>
<html dir="rtl" lang="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الرئيسية</title>
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/master.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

    <nav id="header" class="navbar navbar-expand-lg py-3 fs-5 fw-bold sticky-top" style="font-family: DroidKufi-Bold;">
        <div class="container  ">
            <a class="navbar-brand fw-bold fs-4" href="<?= ROOT_PATH . '/admin' ?>">Web Bootcamp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item ">
                        <a class="nav-link active " aria-current="page" href="<?= ROOT_PATH ?>">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link primary-f" href="<?= ROOT_PATH . '/post' ?>">منشوراتنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT_PATH . '/plateform' ?>">منصاتنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT_PATH . '/about' ?>">حولنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT_PATH . '/contact' ?>">اتصل بنا</a>
                    </li>
                    <li class="nav-item">
                        <?php if (is_login()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT_PATH . '/logout' ?>">
                            <button class="btn btn-primary" style="background-color: var(--c4);">
                                تسجيل الخروج
                            </button>
                        </a>
                    </li>
                <?php } else { ?>
                    <a class="nav-link" href="<?= ROOT_PATH . '/login' ?>">
                        <button class="btn btn-primary" style="background-color: var(--c4);">
                            تسجيل الدخول
                        </button>
                    </a> <?php
                        } ?>

                </li>

                </ul>
            </div>
        </div>
    </nav>