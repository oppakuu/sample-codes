<?php


namespace App\Http\Resources;


use App\Models\Announcement as AnnouncementModel;
use Illuminate\Http\Resources\Json\JsonResource;

class Announcement extends JsonResource
{
    const ID                       = 'id';
    const ANNOUNCEMENT_CATEGORY_ID = 'announcement_category_id';
    const ANNOUNCEMENT_CATEGORY    = 'announcement_category';
    const TITLE                    = 'title';
    const DESCRIPTION              = 'description';
    const WEBLINK                  = 'weblink';
    const CONTACT_NUMBER           = 'contact_number';
    const ASSIGNED_TO              = 'assigned_to';
    const ASSIGNED_USER            = 'assigned_user';
    const STATUS                   = 'status';
    const BUSINESS_ID              = 'business_id';
    const BUSINESS                 = 'business';
    const BUILDING_ID              = 'building_id';
    const BUILDING                 = 'building';
    const BUILDINGS                = 'buildings';
    const APARTMENT_ID             = 'apartment_id';
    const APARTMENT                = 'apartment';
    const APARTMENTS               = 'apartments';
    const CREATED_AT               = 'created_at';

    public function toArray($request)
    {
        return [
            self::ID                         => $this->id,
            self::ANNOUNCEMENT_CATEGORY_ID   => $this->announcement_category_id,
            self::TITLE                      => $this->title,
            self::DESCRIPTION                => $this->description,
            self::WEBLINK                    => $this->weblink,
            self::CONTACT_NUMBER             => $this->contact_number,
            self::ASSIGNED_TO                => $this->assigned_to,
            self::STATUS                     => $this->status,
            self::BUSINESS_ID                => $this->business_id,
            self::BUILDING_ID                => $this->building_id,
            self::APARTMENT_ID               => $this->apartment_id,
            self::CREATED_AT                 => $this->created_at,
            self::ANNOUNCEMENT_CATEGORY      => new AnnouncementCategory($this->announcement_category),
            self::ASSIGNED_USER              => new User($this->assigned_user),
            self::BUSINESS                   => new Business($this->whenLoaded(AnnouncementModel::RELATION_BUSINESS)),
            self::BUILDING                   => new Building($this->whenLoaded(AnnouncementModel::RELATION_BUILDING)),
            self::APARTMENT                  => new Apartment($this->whenLoaded(AnnouncementModel::RELATION_APARTMENT)),
            self::APARTMENTS                 => Apartment::collection($this->whenLoaded('apartments')),
            self::BUILDINGS                  => Building::collection($this->whenLoaded('buildings')),
        ];
    }
}
