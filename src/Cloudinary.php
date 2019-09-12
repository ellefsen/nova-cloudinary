<?php

namespace Aeon\Cloudinary;

use Laravel\Nova\Fields\Field;

class Cloudinary extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'cloudinary';

    /**
     * Set the hues that may be selected by the color picker.
     *
     * @param  array  $hues
     * @return $this
     */
    public function transformations(array $transformations)
    {
        return $this->withMeta(['transformations' => $transformations]);
    }

    /**
     * Set the hues that may be selected by the color picker.
     *
     * @param  array  $hues
     * @return $this
     */
    public function type(string $type)
    {
        return $this->withMeta(['type' => $type]);
    }
}
