<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnnouncementCategoryRequest;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\GetAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;
use App\Models\AnnouncementCategory;
use App\Http\Resources\Announcement as AnnouncementResource;
use App\Http\Resources\AnnouncementCategory as AnnouncementCategoryResource;

class AnnouncementController extends Controller
{

    /**
     * @param GetAnnouncementRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(GetAnnouncementRequest $request)
    {
        $limit = $request->input(GetAnnouncementRequest::PARAMETER_LIMIT, 10);
        $filter = $request->input(GetAnnouncementRequest::PARAMETER_FILTER);
        $announcements = Announcement::with('business', 'building', 'apartment');
        if(isset($filter[GetAnnouncementRequest::FILTER_BUSINESS_ID])){
            $businessId = $filter[GetAnnouncementRequest::FILTER_BUSINESS_ID];
            $announcements = $announcements->where(Announcement::BUSINESS_ID, $businessId);
        }
        if(isset($filter[GetAnnouncementRequest::FILTER_APARTMENT_ID])){
            $apartmentId = $filter[GetAnnouncementRequest::FILTER_APARTMENT_ID];
            $announcements = $announcements->where(Announcement::APARTMENT_ID, $apartmentId);
        }
        if(isset($filter[GetAnnouncementRequest::FILTER_CATEGORY_ID])){
            $categoryId = $filter[GetAnnouncementRequest::FILTER_CATEGORY_ID];
            $announcements = $announcements->where(Announcement::ANNOUNCEMENT_CATEGORY_ID, $categoryId);
        }
        if(isset($filter[GetAnnouncementRequest::FILTER_BUILDING_ID])){
            $buildingId = $filter[GetAnnouncementRequest::FILTER_BUILDING_ID];
            $announcements = $announcements->where(Announcement::BUILDING_ID, $buildingId);
        }
        if(isset($filter[GetAnnouncementRequest::FILTER_STATUS])){
            $status = $filter[GetAnnouncementRequest::FILTER_STATUS];
            $announcements = $announcements->where(Announcement::STATUS, $status);
        }
        if(isset($filter[GetAnnouncementRequest::FILTER_ASSIGNED_TO])){
            $assignedTo = $filter[GetAnnouncementRequest::FILTER_ASSIGNED_TO];
            $announcements = $announcements->where(Announcement::ASSIGNED_TO, $assignedTo);
        }
        if(isset($filter[GetAnnouncementRequest::FILTER_CONTACT_NUMBER])){
            $contactNumber = $filter[GetAnnouncementRequest::FILTER_CONTACT_NUMBER];
            $announcements = $announcements->where(Announcement::CONTACT_NUMBER, $contactNumber);
        }
        if(isset($filter[GetAnnouncementRequest::FILTER_TITLE])){
            $title = $filter[GetAnnouncementRequest::FILTER_TITLE];
            $announcements = $announcements->where(Announcement::TITLE, $title);
        }

        $sort = $request->input(GetAnnouncementRequest::SORT);
        if (isset($sort[GetAnnouncementRequest::SORT_FIELD])) {
            $sortField = $sort[GetAnnouncementRequest::SORT_FIELD];
            $sortType  = $sort[GetAnnouncementRequest::SORT_TYPE];
            $announcements  = $announcements->orderBy($sortField, $sortType);
        }

        $announcements = $announcements->paginate($limit);

        return AnnouncementResource::collection($announcements->load('buildings', 'apartments'));
    }

    /**
     * @param CreateAnnouncementRequest $request
     * @return AnnouncementResource
     */
    public function store(CreateAnnouncementRequest $request): AnnouncementResource
    {
        $categoryId         = $request->input(CreateAnnouncementRequest::PARAMETER_ANNOUNCEMENT_CATEGORY_ID);
        $title              = $request->input(CreateAnnouncementRequest::PARAMETER_TITLE);
        $description        = $request->input(CreateAnnouncementRequest::PARAMETER_DESCRIPTION);
        $weblink            = $request->input(CreateAnnouncementRequest::PARAMETER_WEBLINK);
        $contactNumber      = $request->input(CreateAnnouncementRequest::PARAMETER_CONTACT_NUMBER);
        $businessId         = $request->input(CreateAnnouncementRequest::PARAMETER_BUSINESS_ID);
        $buildingId         = $request->input(CreateAnnouncementRequest::PARAMETER_BUILDING_ID);
        $apartmentId        = $request->input(CreateAnnouncementRequest::PARAMETER_APARTMENT_ID);
        $apartments         = $request->input(CreateAnnouncementRequest::PARAMETER_APARTMENTS);
        $buildings          = $request->input(CreateAnnouncementRequest::PARAMETER_BUILDINGS);
        $user = auth()->user();

        $announcementData = [
            Announcement::ANNOUNCEMENT_CATEGORY_ID  => $categoryId,
            Announcement::TITLE                     => $title,
            Announcement::DESCRIPTION               => $description,
            Announcement::WEBLINK                   => $weblink,
            Announcement::CONTACT_NUMBER            => $contactNumber,
            Announcement::ASSIGNED_TO               => $user->id,
            Announcement::BUSINESS_ID               => $businessId,
            Announcement::BUILDING_ID               => $buildingId,
            Announcement::APARTMENT_ID              => $apartmentId,
            Announcement::STATUS                    => Announcement::STATUS_ACTIVE,
        ];

        $announcement = Announcement::create($announcementData);
        $announcement->apartments()->attach($apartments);
        $announcement->buildings()->attach($buildings);

        return new AnnouncementResource($announcement);
    }

    public function update(Announcement $announcement, UpdateAnnouncementRequest $request): AnnouncementResource
    {
        $categoryId         = $request->input(UpdateAnnouncementRequest::PARAMETER_ANNOUNCEMENT_CATEGORY_ID);
        $title              = $request->input(UpdateAnnouncementRequest::PARAMETER_TITLE);
        $description        = $request->input(UpdateAnnouncementRequest::PARAMETER_DESCRIPTION);
        $weblink            = $request->input(UpdateAnnouncementRequest::PARAMETER_WEBLINK);
        $contactNumber      = $request->input(UpdateAnnouncementRequest::PARAMETER_CONTACT_NUMBER);
        $businessId         = $request->input(UpdateAnnouncementRequest::PARAMETER_BUSINESS_ID);
        $buildingId         = $request->input(UpdateAnnouncementRequest::PARAMETER_BUILDING_ID);
        $apartmentId        = $request->input(UpdateAnnouncementRequest::PARAMETER_APARTMENT_ID);
        $user = auth()->user();

        $announcementData = [
            Announcement::ANNOUNCEMENT_CATEGORY_ID  => $categoryId,
            Announcement::TITLE                     => $title,
            Announcement::DESCRIPTION               => $description,
            Announcement::WEBLINK                   => $weblink,
            Announcement::CONTACT_NUMBER            => $contactNumber,
            Announcement::ASSIGNED_TO               => $user->id,
            Announcement::BUSINESS_ID               => $businessId,
            Announcement::BUILDING_ID               => $buildingId,
            Announcement::APARTMENT_ID              => $apartmentId,
            Announcement::STATUS                    => Announcement::STATUS_ACTIVE,
        ];

        $announcement->update($announcementData);

        return new AnnouncementResource($announcement);
    }

    public function storeAnnouncementCategory(CreateAnnouncementCategoryRequest $request): AnnouncementCategoryResource
    {
        $name = $request->input(CreateAnnouncementCategoryRequest::PARAMETER_NAME);
        $announcementCategoryData = [
            AnnouncementCategory::NAME => $name,
        ];
        $announcementCategory = AnnouncementCategory::create($announcementCategoryData);

        return new AnnouncementCategoryResource(($announcementCategory));
    }

    public function getAnnouncementCategory()
    {
        $announcementCategories = AnnouncementCategory::select('*')->paginate(10);
        return AnnouncementCategoryResource::collection($announcementCategories);
    }
}
