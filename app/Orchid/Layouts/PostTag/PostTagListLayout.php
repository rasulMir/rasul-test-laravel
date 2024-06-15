<?php

namespace App\Orchid\Layouts\PostTag;

use App\Models\PostTag;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PostTagListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'post_tags';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Тэги')),
            TD::make('created_at', __('Дата создания'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT),
            TD::make('updated_at', __('Дата редактирования'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('50px')
                ->render(fn (PostTag $tag) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Редактировать'))
                            ->route('platform.tags.edit', $tag->id)
                            ->icon('bs.pencil'),

                        Button::make(__('Удалить'))
                            ->icon('bs.trash3')
                            ->confirm(__('Вы точно хотите удалить данный тэг "' . $tag->name . '"?'))
                            ->method('remove', [
                                'id' => $tag->id,
                            ]),
                    ])),
        ];
    }
}
