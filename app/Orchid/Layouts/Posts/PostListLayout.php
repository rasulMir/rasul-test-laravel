<?php

namespace App\Orchid\Layouts\Posts;

use App\Models\Post;
use App\Models\PostTag;
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
                ->defaultHidden(),
            TD::make('attachment', __('Изображение'))
                ->render(function (Post $post) {
                    $image = $post->attachment()->first();

                    return $image
                        ? '<img src="' . $image->url . '" height="80px" />'
                        : '&mdash;';
                })
                ->align(TD::ALIGN_CENTER),
            TD::make('title', __('Заголовок')),
            TD::make('body', __('Текст'))
                ->defaultHidden(),
            TD::make('tags', __('Теги'))
                ->render(
                    fn (Post $post) => implode($post->tags->map(fn (PostTag $item) => $item->name . ';<br>')->toArray())
                )
                ->width(180),
            TD::make('visibility', __('Видимость'))
                ->render(fn (Post $post) => __($post->visibility ? 'Опубликован' : 'Черновик')),
            TD::make('created_at', __('Дата создания'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden(),
            TD::make('updated_at', __('Дата редактирования'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden(),
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
