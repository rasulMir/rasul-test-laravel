<?php

namespace App\Orchid\Layouts\Posts;

use App\Models\PostTag;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class PostCreateLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('post.title')
                ->title(__('Заголовок'))
                ->placeholder(__('7 основных навыков, чтобы стать лидером.'))
                ->required(),
            TextArea::make('post.body')
                ->title(__('Текст поста'))
                ->placeholder(__('Стратегическое мышление, коммуникативные навыки, мотивация, готовность принимать риски и делегировать ответственность - это ключевые составляющие успеха в лидерстве. Развивая эти качества, каждый может стать успешным лидером и вести свою команду к успеху.'))
                ->rows(5)
                ->required(),
            Relation::make('post.tags')
                ->fromModel(PostTag::class, 'name')
                ->title(__('Тэги'))
                ->help(__('Тэги должны быть созданы и уже быть в бд.'))
                ->multiple()
                ->required(),
            Cropper::make('post.preview_image')
                ->title(__('Изображение для превью'))
                ->help(__('Загрузите изображение с устройства.'))
                ->acceptedFiles('.jpg, .jpeg, .png, .svg')
                ->targetId()
                ->required(),
            CheckBox::make('post.visibility')
                ->checked()
                ->title(__('Видимость поста'))
                ->placeholder(__('Опубликовать / Черновик'))
                ->sendTrueOrFalse(),
        ];
    }
}
