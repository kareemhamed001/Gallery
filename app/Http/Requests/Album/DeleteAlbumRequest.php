<?php

namespace App\Http\Requests\Album;

use Illuminate\Foundation\Http\FormRequest;

class DeleteAlbumRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'move_to' => 'nullable|numeric'
        ];
    }
}
