<?php


namespace App\Http\Requests;


class CreateAnnouncementRequest extends PersistAnnouncementRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return parent::rules();
    }
}
