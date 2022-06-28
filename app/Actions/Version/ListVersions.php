<?php

namespace App\Actions\Version;

use App\Models\Version;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\WithAttributes;

class ListVersions
{
    use AsAction, WithAttributes;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_version' => 'sometimes|string|exists:versions,number',
        ];
    }

    /**
     * @param $attributes
     */
    public function handle($attributes)
    {
        $this->fill($attributes);
        $this->validateAttributes();

        if ($this->has('current_version')) {
            $currentVersion = optional(Version::whereNumber($this->get('current_version'))->first())->id;
        }

        $query = Version::query();

        if (isset($currentVersion)) {
            $query->where('id', '>', $currentVersion);
        }

        return $query->get();
    }
}
