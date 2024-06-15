<?php

namespace App\Orchid\Screens\PostTag;

use App\Http\Requests\PostTag\PostTagCreateRequest;
use App\Models\PostTag;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostTagEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(PostTag $tag): iterable
    {
        return [
            'post_tag' => $tag,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Редактирование тэга.');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Изменить'))
                ->icon('bs.check-circle')
                ->method('edit'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(Layout::rows([
                Input::make('post_tag.name')
                    ->title(__('Название тэга'))
                    ->placeholder(__('Футбол'))
                    ->required(),
            ]))
                ->title(__('Введите название тэга'))
                ->description(__('Введите название тэга правильно заполнив все поля'))
                ->commands(
                    Button::make(__('Изменить'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('edit')
                ),
        ];
    }

    public function edit(PostTag $tag, PostTagCreateRequest $request)
    {
        $tag->fill($request->input('post_tag'))->save();

        Toast::info(__('Тэг успешно обновлен.'));
        return redirect()->route('platform.tags.index');
    }
}
