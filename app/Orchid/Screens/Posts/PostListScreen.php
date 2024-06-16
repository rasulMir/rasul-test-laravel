<?php

namespace App\Orchid\Screens\Posts;

use App\Models\Post;
use App\Models\PostTag;
use App\Orchid\Layouts\Posts\PostListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class PostListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'posts' => Post::with('attachment')->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Посты');
    }

    public function description(): ?string
    {
        return __('Показаны все посты включая опубликованные/черновики.');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Создать пост'))
                ->icon('bs.plus-circle')
                ->href(route('platform.posts.create'))
                ->canSee(auth()->user()->hasAccess('platform.posts.create')),
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
            PostListLayout::class,
        ];
    }

    public function remove(Request $request)
    {
        $post = Post::findOrFail($request->get('id'));
        $tags = $post->tags->map(fn (PostTag $item) => $item->id)->toArray();
        $post->tags()->detach(array_values($tags));
        $post->attachment()->delete();

        $post->delete();
        Toast::info(__('Пост был успешно удален.'));
        return redirect()->route('platform.posts.index');
    }
}
