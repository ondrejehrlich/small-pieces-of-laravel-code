<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use App\Interfaces\Likeable;
use Illuminate\Foundation\Http\FormRequest;

class LikeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'likeable' => [
                "required",
                "string",
                function ($attribute, $value, $fail) {
                    $class = $this->getClass($value);

                    if (!class_exists($class, true)) {
                        $fail($class . " is not a valid class");
                    }
                    if (!in_array('Illuminate\\Database\\Eloquent\\Model', class_parents($class))) {
                        $fail($class . " is not a model");
                    }

                    if (!in_array(Likeable::class, class_implements($class))) {
                        $fail($class . " is not a likeable");
                    }
                },
            ],
            'id' => [
                "required",
                function ($attribute, $value, $fail) {
                    $class = $this->getClass($this->input('likeable'));

                    if (!$class::where('id', $value)->exists()) {
                        $fail($value . " is not present in database");
                    }
                },
            ],        ];
    }

    /**
     * Likeable.
     *
     * @return Likeable
     */
    public function likeable(): Likeable
    {
        $class = $this->getClass($this->input('likeable'));

        return $class::findOrFail($this->input('id'));
    }

    /**
     * Get class.
     *
     * @param string $value
     * @return string
     */
    protected function getClass($value): string
    {
        return "App\\Models\\" . Str::studly($value);
    }
}
