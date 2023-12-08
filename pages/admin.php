<div dir='ltr'>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 d-none d-md-block text-end p-3" style="height: 100vh; background-color: var(--c4);color:var(--c1); position: fixed;">
                <p>
                    <button type="button" class="btn btn-primary w-100" style="background-color: var(--c1);color:var(--c4)">
                        المنشورات </button>
                </p>
                <p>
                    <a href="<?= ROOT_PATH . '/plateform' ?>">
                        <button type="button" class="btn btn-primary w-100" style="background-color: var(--c1);color:var(--c4)">
                            الحسابات </button></a>
                </p>
            </div>
            <div class="col-12 col-md-9 ms-auto" dir="rtl">
                <main>

                    <div class="container py-4" id="posts-dashboard">
                        <div class="d-flex justify-content-between">
                            <h2>أدارة المنشورات</h2>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="background-color: var(--c4);">
                                أنشاء منشور
                            </button>
                        </div>
                        <hr>
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header ">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">أنشاءمنشور</h1>
                                        <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="create_form" method="post" action="<?= ROOT_PATH . '/create_post' ?>" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">أضافة صورة</label>
                                                <input class="form-control" type="file" accept=".jpeg,.png, .gif" id="formFile" name="image">
                                            </div>
                                            <div class="mb-3">
                                                <label for="postInputContent" class="form-label">المحتوى</label>
                                                <textarea rows="5" type="text" class="form-control" id="postInputContent" name="content" value="" required minlength="10"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex gap-3 ">
                                                    <div>
                                                        <i class="fa-brands fa-facebook fs-5" style="color:blue;"></i>
                                                        <label for="fb">إضافة الى فيسبوك</label>
                                                    </div>
                                                    <input type="checkbox" name='facebook' id="fb">
                                                </div>
                                                <br>
                                                <div class="d-flex gap-3">
                                                    <div><i class="fa-brands fa-instagram fs-5" style="color:crimson"></i>
                                                        <label for="ins">إضافة الى إنستقرام</label>
                                                    </div>
                                                    <input type="checkbox" name='instagram' id="ins">
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ألغاء</button>
                                        <button type="submit" class="btn btn-primary" style="background-color: var(--c4);" form="create_form">أضافة</button>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column  my-5">
                            <?= render_admin_post() ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>