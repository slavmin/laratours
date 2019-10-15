<?php

Breadcrumbs::for('admin.auth.team.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('menus.backend.access.teams.management'), route('admin.auth.team.index'));
});

Breadcrumbs::for('admin.auth.team.create', function ($trail) {
    $trail->parent('admin.auth.team.index');
    $trail->push(__('menus.backend.access.teams.create'), route('admin.auth.team.create'));
});

Breadcrumbs::for('admin.auth.team.deactivated', function ($trail) {
    $trail->parent('admin.auth.team.index');
    $trail->push(__('menus.backend.access.teams.deactivated'), route('admin.auth.team.deactivated'));
});

Breadcrumbs::for('admin.auth.team.deleted', function ($trail) {
    $trail->parent('admin.auth.team.index');
    $trail->push(__('menus.backend.access.teams.deleted'), route('admin.auth.team.deleted'));
});

Breadcrumbs::for('admin.auth.team.show', function ($trail, $id) {
    $trail->parent('admin.auth.team.index');
    $trail->push(__('menus.backend.access.teams.view'), route('admin.auth.team.show', $id));
});

Breadcrumbs::for('admin.auth.team.edit', function ($trail, $id) {
    $trail->parent('admin.auth.team.index');
    $trail->push(__('menus.backend.access.teams.edit'), route('admin.auth.team.edit', $id));
});