<div>
    <div class="container-fluid">
        <div class="row my-5">
            <div class="col-lg-9 ">
                <div class="d-flex justify-content-around gap-3">
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ترتيب حسب
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= ROOT_PATH . "/post/?sort_as=ASC" ?>">ألاقدم</a></li>
                            <li><a class="dropdown-item" href="<?= ROOT_PATH . "/post/?sort_as=DESC" ?>">ألاحدث</a></li>
                        </ul>
                    </div>
                    <form class="d-flex " role="search" action="" method="post">
                        <input class="form-control ms-2" type="search" placeholder="ادخل النص" name="search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">بحث</button>
                    </form>
                </div>
                <div id="post-card" class="d-flex flex-column align-items-center my-5">
                    <!-- post -->
                    <?php
                    if ($_SESSION['search']) {
                        $result = render_search_post($_SESSION['search']);
                        if (empty($result)) {
                            echo  "لا توجد نتائج";
                        } else {
                            echo $result;
                        }
                    } else {
                        echo render_main_post($_SESSION['sort_as'] ?? "");
                    }
                    ?>


                </div>
            </div>
            <div class="col-lg-3 d-lg-block d-none border-end border-2"></div>
        </div>
    </div>
</div>