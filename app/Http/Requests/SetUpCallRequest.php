<?php

namespace App\Http\Requests;


class SetUpCallRequest extends AbstractApiRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'did_number' => 'required',
            'caller_id'  => 'required',
        ];
    }

    /**
     * @return string
     */
    public function getDidNumber(): string
    {
        return $this->input('did_number');
    }

    /**
     * @return string
     */
    public function getCallerId(): string
    {
        return $this->input('caller_id');
    }
}
