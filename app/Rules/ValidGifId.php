<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\GiphyIdService;

class ValidGifId implements Rule
{
    protected $giphyIdService;

    public function __construct(GiphyIdService $giphyIdService)
    {
        $this->giphyIdService = $giphyIdService;
    }

    public function passes($attribute, $value)
    {
        $gif = $this->giphyIdService->getGifById($value);

        if (empty($gif['data']) && isset($gif['meta']) && ($gif['meta']['status'] == 404 || $gif['meta']['status'] == 400)) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'The :attribute does not exist on Giphy.';
    }
}