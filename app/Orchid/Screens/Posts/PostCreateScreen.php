<?php

namespace App\Orchid\Screens\Posts;

use App\Http\Requests\Post\PostCreateRequest;
use App\Models\Post;
use App\Orchid\Layouts\Posts\PostCreateLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PostCreateScreen extends Screen
{
    /**
     * The permissions required to access this screen.
     */
    public function permission(): ?iterable
    {
        return [
            'platform.posts.create',
        ];
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Создание поста.');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Сохранить'))
                ->icon('bs.check-circle')
                ->method('save'),
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
            Layout::block(PostCreateLayout::class)
                ->title(__('Создание поста.'))
                ->description(__('Создаите пост правильно заполнив все поля.'))
                ->commands(
                    Button::make(__('Сохранить'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('save')
                ),
        ];
    }

    public function save(PostCreateRequest $request)
    {
        $post = Post::create($request->collect('post')->except('tags')->toArray());
        $post->attachment()->attach($request->input('post.preview_image', []));
        $post->tags()->attach($request->input('post.tags'));

        Alert::info('Пост успешно создан.');

        return redirect()->route('platform.posts.index');
    }
}
