<?php

namespace App\Orchid\Screens\Posts;

use App\Http\Requests\Post\PostCreateRequest;
use App\Models\Post;
use App\Orchid\Layouts\Posts\PostCreateLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostEditScreen extends Screen
{
    /**
     * The permissions required to access this screen.
     */
    public function permission(): ?iterable
    {
        return [
            'platform.posts.edit',
        ];
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Post $post): iterable
    {
        return [
            'post' => $post->load('attachment'),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Редактирование поста.');
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
            Layout::block(PostCreateLayout::class)
                ->title(__('Редактирование поста.'))
                ->description(__('Отредактируйте пост правильно заполнив все поля.'))
                ->commands(
                    Button::make(__('Сохранить'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('edit')
                ),
        ];
    }

    public function edit(Post $post, PostCreateRequest $request)
    {
        $post->update($request->collect('post')->except('tags')->toArray());
        $post->attachment()->sync($request->input('post.preview_image', []));
        $post->tags()->sync($request->input('post.tags'));

        Toast::info(__('Пост успешно обновлено.'));
        return redirect()->route('platform.posts.index');
    }
}
