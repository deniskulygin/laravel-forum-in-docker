<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use App\Reply;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * Class CreatePostRequest
 *
 * @package App\Http\Forms
 */
class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('create', new Reply);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamfree'
        ];
    }
    
    /**
     * @throws ThrottleException
     */
    protected function failedAuthorization(): void
    {
        throw new ThrottleException('You are replying too frequently. Please, take a break.');
    }
}
