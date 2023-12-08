<div class="">
    <div class="container py-5 ">

        <h3 class="text-center mb-5">تسجيل الدخول</h3>
        <form class="p-md-5 border rounded-3 bg-body-tertiary" method="post">
            <?php if (isset($_SESSION['login_message']) && $_SESSION['login_message'] != null) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_SESSION['login_message'] ?>
                </div><?php
                    } ?>
            <div class="form-floating mb-3">

                <input type="text" id="form4Example1" class="form-control" name="username" minlength="7" required placeholder="اسم المستخدم" />

                <label class="form-label " for="form4Example1">اسم المستخدم</label>

            </div>

            <div class="form-floating mb-3">

                <input type="password" id="form4Example2" class="form-control" name="password" minlength="8" required placeholder="كلمة السر" />
                <label class="form-label" for="form4Example2">كلمة السر</label>

            </div>


            <button type="submit" class="w-100 btn btn-lg btn-primary" style="background-color: var(--c4);">أرسال</button>

        </form>


    </div>
</div>