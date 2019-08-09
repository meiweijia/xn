<?php

namespace App\Admin\Extensions\Form\Field;

use Encore\Admin\Admin;
use Encore\Admin\Form\Field\Select as BaseSelect;
use Illuminate\Support\Str;

class Select extends BaseSelect
{
    /**
     * Load options for other select on change.
     *
     * @param string $field
     * @param string $sourceUrl
     * @param string $idField
     * @param string $textField
     *
     * @return $this
     */
    public function load($field, $sourceUrl, $idField = 'id', $textField = 'text', bool $allowClear = true)
    {
        if (Str::contains($field, '.')) {
            $field = $this->formatName($field);
            $class = str_replace(['[', ']'], '_', $field);
        } else {
            $class = $field;
        }

        $placeholder = json_encode([
            'id' => '',
            'text' => trans('admin.choose'),
        ]);

        $script = <<<EOT
$(document).off('change', "{$this->getElementClassSelector()}");
$(document).on('change', "{$this->getElementClassSelector()}", function () {
    var target = $(this).closest('.fields-group').find(".$class");
    $.get("$sourceUrl",{q : this.value}, function (data) {
        target.find("option").remove();
        $(target).select2({
            placeholder: $placeholder,
            allowClear: $allowClear,
            data: $.map(data, function (d) {
                d.id = d.$idField;
                d.text = d.$textField;
                return d;
            })
        }).trigger('change');
        if (target.data('value')) {
            var value = target.data('value');
            target.val(value).trigger('change');
        } else {
            target.trigger('change');
        }
    });
});
$('{$this->getElementClassSelector()}').trigger('change');
EOT;

        Admin::script($script);

        return $this;
    }
}
