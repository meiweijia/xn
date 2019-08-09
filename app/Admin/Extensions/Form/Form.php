<?php

namespace App\Admin\Extensions\Form;

use App\Admin\Extensions\Form\Field\Select;
use Encore\Admin\Form\Field;

/**
 * Class Form.
 *
 * @method Field\Select         select($column, $label = '')
 */
class Form extends \Encore\Admin\Form
{
    /**
     * Available fields.
     *
     * @var array
     */
    public static $availableFields = [
        'button'         => Field\Button::class,
        'checkbox'       => Field\Checkbox::class,
        'color'          => Field\Color::class,
        'currency'       => Field\Currency::class,
        'date'           => Field\Date::class,
        'dateRange'      => Field\DateRange::class,
        'datetime'       => Field\Datetime::class,
        'dateTimeRange'  => Field\DatetimeRange::class,
        'datetimeRange'  => Field\DatetimeRange::class,
        'decimal'        => Field\Decimal::class,
        'display'        => Field\Display::class,
        'divider'        => Field\Divider::class,
        'embeds'         => Field\Embeds::class,
        'email'          => Field\Email::class,
        'file'           => Field\File::class,
        'hasMany'        => Field\HasMany::class,
        'hidden'         => Field\Hidden::class,
        'id'             => Field\Id::class,
        'image'          => Field\Image::class,
        'ip'             => Field\Ip::class,
        'mobile'         => Field\Mobile::class,
        'month'          => Field\Month::class,
        'multipleSelect' => Field\MultipleSelect::class,
        'number'         => Field\Number::class,
        'password'       => Field\Password::class,
        'radio'          => Field\Radio::class,
        'rate'           => Field\Rate::class,
        'select'         => Select::class,
        'slider'         => Field\Slider::class,
        'switch'         => Field\SwitchField::class,
        'text'           => Field\Text::class,
        'textarea'       => Field\Textarea::class,
        'time'           => Field\Time::class,
        'timeRange'      => Field\TimeRange::class,
        'url'            => Field\Url::class,
        'year'           => Field\Year::class,
        'html'           => Field\Html::class,
        'tags'           => Field\Tags::class,
        'icon'           => Field\Icon::class,
        'multipleFile'   => Field\MultipleFile::class,
        'multipleImage'  => Field\MultipleImage::class,
        'captcha'        => Field\Captcha::class,
        'listbox'        => Field\Listbox::class,
        'table'          => Field\Table::class,
        'timezone'       => Field\Timezone::class,
        'keyValue'       => Field\KeyValue::class,
        'list'           => Field\ListField::class,
    ];
}
