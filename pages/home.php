<div id="hero">
    <p class="display-1 fw-bold">منصة مخيم تطوير الويب</p>
</div>
<div class="component-1"></div>
<div id="overview-section" class="container my-5 text-center">
    <div class="py-5">
        <p class="fs-1 mb-3">مخيم تطوير الويب</p>
        <p class="fs-3">مشاركة منشورات مخيم تطوير الويب ضمن برنامج تطوير قدرات الشباب.</p>
    </div>
</div>
<div id="posts-section">
    <div class="container">
        <div class="card">
            <h5 class="card-header">أحدث منشوراتنا</h5>
            <div class="card-body">
                <div class="row">
                    <?= render_recent_post() ?></div>
            </div>
            <div class="card-footer text-body-secondary">
                <a href="#" class="nav-link">المزيد من المنشورات</a>
            </div>
        </div>
    </div>
</div>