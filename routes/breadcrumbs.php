
<?php

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', url('/'));
});

Breadcrumbs::for('admin_users.list', function ($trail) {
    $trail->parent('home');
    $trail->push('admin_users一覧', url('/admin_users'));
});
Breadcrumbs::for('admin_users.form', function ($trail) {
    $trail->parent('admin_users.list');
    $trail->push('admin_users詳細', url('/'));
});

Breadcrumbs::for('profile.list', function ($trail) {
    $trail->parent('home');
    $trail->push('profile一覧', url('/profile'));
});
Breadcrumbs::for('profile.form', function ($trail) {
    $trail->parent('profile.list');
    $trail->push('profile詳細', url('/'));
});

Breadcrumbs::for('users.list', function ($trail) {
    $trail->parent('home');
    $trail->push('users一覧', url('/users'));
});
Breadcrumbs::for('users.form', function ($trail) {
    $trail->parent('users.list');
    $trail->push('users詳細', url('/'));
});
