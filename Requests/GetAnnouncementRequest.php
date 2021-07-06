<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class GetAnnouncementRequest extends FormRequest
{
    const PARAMETER_LIMIT       = 'limit';
    const PARAMETER_FILTER      = 'filter';
    const FILTER_BUSINESS_ID    = 'business_id';
    const FILTER_BUILDING_ID    = 'building_id';
    const FILTER_CATEGORY_ID    = 'announcement_category_id';
    const FILTER_APARTMENT_ID   = 'apartment_id';
    const FILTER_TITLE          = 'title';
    const FILTER_STATUS         = 'status';
    const FILTER_ASSIGNED_TO    = 'assigned_to';
    const FILTER_CONTACT_NUMBER = 'contact_number';
    const SORT                  = 'sort';
    const SORT_FIELD            = 'field';
    const SORT_TYPE             = 'type';
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
