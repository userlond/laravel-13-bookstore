<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'author_id' => [
                'required',
                'integer',
                'exists:authors,id',
                new class implements ValidationRule
                {
                    public function validate(string $attribute, mixed $value, Closure $fail): void
                    {
                        if (auth()->user()->subscriptions->where('author_id', $value)->count() > 0) {
                            $fail('You already subscribed on the author.');
                        }
                    }
                },
            ],
        ];
    }
}
