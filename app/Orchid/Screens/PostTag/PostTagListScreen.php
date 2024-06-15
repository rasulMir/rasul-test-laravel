<?php

namespace App\Orchid\Screens\PostTag;

use App\Models\PostTag;
use App\Orchid\Layouts\PostTag\PostTagListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class PostTagListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'post_tags' => PostTag::paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Все тэги');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Создать'))
                ->icon('bs.plus')
                ->route('platform.tags.create'),
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
            PostTagListLayout::class,
        ];
    }

    public function remove(Request $request)
    {
        PostTag::findOrFail($request->get('id'))->delete();
        Toast::info(__('Тэг был успешно удален.'));
        return redirect()->route('platform.tags.index');
    }
}
