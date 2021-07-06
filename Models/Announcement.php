<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function JmesPath\search;

class Announcement extends Model
{
    use HasFactory;
    const TABLE       = 'announcements';

    const ANNOUNCEMENT_CATEGORY_ID = 'announcement_category_id';
    const TITLE                    = 'title';
    const DESCRIPTION              = 'description';
    const WEBLINK                  = 'weblink';
    const CONTACT_NUMBER           = 'contact_number';
    const ASSIGNED_TO              = 'assigned_to';
    const STATUS                   = 'status';
    const BUSINESS_ID              = 'business_id';
    const BUILDING_ID              = 'building_id';
    const APARTMENT_ID             = 'apartment_id';
    const CREATED_AT               = 'created_at';

    const RELATION_BUSINESS  = 'business';
    const RELATION_BUILDING = 'building';
    const RELATION_APARTMENT = 'apartment';

    const STATUS_ACTIVE    = 'ACTIVE';
    const STATUS_INACTIVE  = 'INACTIVE';

    const ALL_STATUS          = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
    ];

    protected $fillable = [
        self::ANNOUNCEMENT_CATEGORY_ID,
        self::TITLE,
        self::DESCRIPTION,
        self::WEBLINK,
        self::CONTACT_NUMBER,
        self::ASSIGNED_TO,
        self::STATUS,
        self::BUSINESS_ID,
        self::BUILDING_ID,
        self::APARTMENT_ID,
    ];


    public function assigned_user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, self::ASSIGNED_TO, 'id', User::TABLE);
    }

    public function building(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Building::class, self::BUILDING_ID, 'id', Building::TABLE);
    }

    public function business(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Business::class, self::BUSINESS_ID, 'id', Business::TABLE);
    }

    public function apartment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Apartment::class, self::APARTMENT_ID, 'id', Apartment::TABLE);
    }

    public function announcement_category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AnnouncementCategory::class);
    }

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class, AnnouncementApartment::TABLE)->withTimestamps();
    }

    public function buildings()
    {
        return $this->belongsToMany(Building::class, AnnouncementBuilding::TABLE)->withTimestamps();
    }
}
