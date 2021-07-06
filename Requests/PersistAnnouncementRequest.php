<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class PersistAnnouncementRequest extends FormRequest
{
    const PARAMETER_ANNOUNCEMENT_CATEGORY_ID = 'announcement_category_id';
    const PARAMETER_TITLE                    = 'title';
    const PARAMETER_DESCRIPTION              = 'description';
    const PARAMETER_WEBLINK                  = 'weblink';
    const PARAMETER_CONTACT_NUMBER           = 'contact_number';
    const PARAMETER_BUSINESS_ID              = 'business_id';
    const PARAMETER_BUILDING_ID              = 'building_id';
    const PARAMETER_APARTMENT_ID             = 'apartment_id';
    const PARAMETER_BUILDINGS                = 'buildings';
    const PARAMETER_APARTMENTS               = 'apartments';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            self::PARAMETER_ANNOUNCEMENT_CATEGORY_ID          => 'required',
            self::PARAMETER_TITLE                             => 'required',
            self::PARAMETER_DESCRIPTION                       => 'required',
            self::PARAMETER_WEBLINK                           => 'required',
            self::PARAMETER_CONTACT_NUMBER                    => 'required',
            self::PARAMETER_BUSINESS_ID                       => 'nullable',
            self::PARAMETER_BUILDING_ID                       => 'nullable',
            self::PARAMETER_APARTMENT_ID                      => 'nullable',
            self::PARAMETER_BUILDINGS                         => 'array',
            self::PARAMETER_APARTMENTS                        => 'array',
        ];
    }
}
