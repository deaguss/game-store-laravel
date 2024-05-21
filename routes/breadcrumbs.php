<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


 // Admin
 Breadcrumbs::for('admin', function (BreadcrumbTrail $trail) {
    $trail->push('Admin', route('admin.'));
});

// Admin > Profile
Breadcrumbs::for('admin.profile', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Profile', route('admin.profile.'));
});

// Admin > Billboard
Breadcrumbs::for('admin.billboard', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Billboard', route('admin.billboard.'));
});

// Admin > Billboard > Create
Breadcrumbs::for('admin.billboard.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.billboard');
    $trail->push('Create', route('admin.billboard.create'));
});

// Admin > Billboard > Edit
Breadcrumbs::for('admin.billboard.edit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('admin.billboard');
    $trail->push('Edit', route('admin.billboard.edit', $id));
});

// Admin > Billboard > Deleted
Breadcrumbs::for('admin.billboard.deleted', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.billboard');
    $trail->push('Deleted', route('admin.billboard.deleted'));
});

Breadcrumbs::for('admin.category', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Category', route('admin.category.'));
});

Breadcrumbs::for('admin.category.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.category');
    $trail->push('Create', route('admin.category.create'));
});

Breadcrumbs::for('admin.category.edit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('admin.category');
    $trail->push('Edit', route('admin.category.edit', $id));
});

Breadcrumbs::for('admin.category.deleted', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.category');
    $trail->push('Deleted', route('admin.category.deleted'));
});

Breadcrumbs::for('admin.game', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Game', route('admin.game.'));
});

Breadcrumbs::for('admin.game.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.game');
    $trail->push('Create', route('admin.game.create'));
});

Breadcrumbs::for('admin.game.edit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('admin.game');
    $trail->push('Edit', route('admin.game.edit', $id));
});

Breadcrumbs::for('admin.game.deleted', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.game');
    $trail->push('Deleted', route('admin.game.deleted'));
});

Breadcrumbs::for('admin.users', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('User', route('admin.users.'));
});

Breadcrumbs::for('admin.users.edit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('admin.users');
    $trail->push('Edit', route('admin.users.edit', $id));
});

Breadcrumbs::for('admin.users.deleted', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.users');
    $trail->push('Deleted', route('admin.users.deleted'));
});

// // Admin
// Breadcrumbs::for('admin', function (BreadcrumbTrail $trail) {
//     $trail->push('Admin', route('admin.'));
// });

// // Function to create breadcrumbs
// function createBreadcrumb($parent, $name, $route)
// {
//     Breadcrumbs::for($route, function (BreadcrumbTrail $trail) use ($parent, $name, $route) {
//         if ($parent) {
//             // Check if the parent breadcrumb is defined, if not, add a default one
//             if (!Breadcrumbs::exists($parent)) {
//                 $trail->push('Home', route('home')); // Default breadcrumb for missing parent
//             }
//             $trail->parent($parent);
//         }
//         $trail->push($name, route($route));
//     });
// }

// // Examples of usage

// // Admin > Profile
// createBreadcrumb('admin', 'Profile', 'admin.profile');

// // Admin > Billboard
// createBreadcrumb('admin', 'Billboard', 'admin.billboard');

// // Admin > Billboard > Create
// createBreadcrumb('admin.billboard', 'Create', 'admin.billboard.create');

// // Admin > Billboard > Edit
// createBreadcrumb('admin.billboard', 'Edit', 'admin.billboard.edit');

// // Admin > Billboard > Deleted
// createBreadcrumb('admin.billboard', 'Deleted', 'admin.billboard.deleted');

// // Admin > Category
// createBreadcrumb('admin', 'Category', 'admin.category');

// // Admin > Category > Create
// createBreadcrumb('admin.category', 'Create', 'admin.category.create');

// // Admin > Category > Edit
// createBreadcrumb('admin.category', 'Edit', 'admin.category.edit');

// // Admin > Game
// createBreadcrumb('admin', 'Game', 'admin.game');

// // Admin > Game > Create
// createBreadcrumb('admin.game', 'Create', 'admin.game.create');

// // Admin > Game > Edit
// createBreadcrumb('admin.game', 'Edit', 'admin.game.edit');

// // Admin > Game > Deleted
// createBreadcrumb('admin.game', 'Deleted', 'admin.game.deleted');

// // Admin > Users
// createBreadcrumb('admin', 'Users', 'admin.users');

// // Admin > Users > Edit
// createBreadcrumb('admin.users', 'Edit', 'admin.users.edit');

// // Admin > Users > Deleted
// createBreadcrumb('admin.users', 'Deleted', 'admin.users.deleted');
