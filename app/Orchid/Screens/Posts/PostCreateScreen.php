<?php

namespace App\Orchid\Screens\Posts;

use App\Http\Requests\Post\PostCreateRequest;
use App\Models\Post;
use App\Orchid\Layouts\Posts\PostCreateLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class PostCreateScreen extends Screen
{
    /**
     * The permissions required to access this screen.
     */
    public function permission(): ?iterable
    {
        return [
            'platform.posts.create',
            'platform.posts.delete',
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
            PostCreateLayout::class,
        ];
    }

    public function save(PostCreateRequest $request)
    {
        $post = Post::create($request->collect('post')->except('post_tags')->toArray());
        $post->attachment()->syncWithoutDetaching($request->input('post.preview_image', []));
        $post->tags()->attach($request->input('post.post_tags'));

        Alert::info('Пост успешно создан.');

        return redirect()->route('platform.posts.index');
    }
}
