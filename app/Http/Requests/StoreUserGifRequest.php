<?php

namespace App\Http\Requests;

use App\Rules\ValidGifId;
use App\Services\GiphyIdService;
use App\Rules\GifIdExistsForUser;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserGifRequest extends FormRequest
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
    public function rules(ValidGifId $validGifId)
    {
        return [
            'alias' => 'required|string',
            'gif_id' => ['required', 'string', $validGifId, new GifIdExistsForUser($this->user_id)],
            'user_id' => 'required|numeric',
        ];
    }
}