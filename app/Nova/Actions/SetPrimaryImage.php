<?php

namespace App\Nova\Actions;

use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class SetPrimaryImage extends Action
{
    public $name = 'Set as Primary';

    public $showOnIndex = false;

    public $showOnTableRow = true;

    public function handle(ActionFields $fields, Collection $models): mixed
    {
        $image = $models->first();

        if (! $image) {
            return Action::danger('No image selected.');
        }

        // Unset all other primaries for this product
        $image->product->images()
            ->where('id', '!=', $image->id)
            ->update(['is_primary' => false]);

        $image->update(['is_primary' => true]);

        return Action::message('Image set as primary.');
    }

    public function fields(NovaRequest $request): array
    {
        return [];
    }
}
