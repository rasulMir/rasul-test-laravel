<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [

            // post
            Menu::make(__('Все посты'))
                ->title(__('Посты'))
                ->icon('bs.stickies')
                ->route('platform.posts.index')
                ->active('platform.posts.index'),
            Menu::make(__('Создание постов'))
                ->icon('bs.sticky')
                ->route('platform.posts.create')
                ->active('platform.posts.create')
                ->canSee(auth()->user()->hasAccess('platform.posts.create')),
            // post

            // post-tag
            Menu::make(__('Тэги'))
                ->title(__('Тэги'))
                ->icon('bs.tags')
                ->route('platform.tags.index')
                ->active('platform.tags.index'),
            // post-tag

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Контроль доступа')),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),

            ItemPermission::group(__('Администратор'))
                ->addPermission('platform.posts.create', __('Создание поста'))
                ->addPermission('platform.posts.delete', __('Удаление поста')),

            ItemPermission::group(__('Модератор'))
                ->addPermission('platform.posts.edit', __('Редактирование поста')),
        ];
    }
}
