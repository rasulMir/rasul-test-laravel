<?php

namespace App\Orchid\Layouts\Posts;

use App\Models\Post;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PostListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'posts';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', __('#'))
                ->canSee(false),
            TD::make('title', __('Заголовок')),
            TD::make('body', __('Текст'))
                ->canSee(false),
            TD::make('post_category_id', __('Тег'))
                ->render(fn (Post $post) => $post->category->name),
            TD::make('visibility', __('Видимость'))
                ->render(fn (Post $post) => $post->visibility ? __('Опубликован') : __('Черновик')),
            TD::make('created_at', __('Дата создания'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->canSee(false),
            TD::make('updated_at', __('Дата редактирования'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->canSee(false),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('50px')
                ->render(fn (Post $post) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Редактировать'))
                            ->route('platform.posts.edit', $post->id)
                            ->icon('bs.pencil'),

                        Button::make(__('Удалить'))
                            ->icon('bs.trash3')
                            ->confirm(__('Вы точно хотите удалить данный пост?'))
                            ->method('remove', [
                                'id' => $post->id,
                            ]),
                    ])),

        ];
    }
}
