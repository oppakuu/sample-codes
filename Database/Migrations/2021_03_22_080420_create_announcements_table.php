<?php

use App\Models\Announcement;
use App\Models\AnnouncementCategory;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Announcement::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(Announcement::ANNOUNCEMENT_CATEGORY_ID);
            $table->string(Announcement::TITLE);
            $table->text(Announcement::DESCRIPTION);
            $table->string(Announcement::WEBLINK);
            $table->string(Announcement::CONTACT_NUMBER);
            $table->unsignedBigInteger(Announcement::ASSIGNED_TO)->nullable();
            $table->unsignedBigInteger(Announcement::BUSINESS_ID)->nullable();
            $table->unsignedBigInteger(Announcement::BUILDING_ID)->nullable();
            $table->unsignedBigInteger(Announcement::APARTMENT_ID)->nullable();
            $table->string(Announcement::STATUS);
            $table->timestamps();

            $table->foreign(Announcement::ANNOUNCEMENT_CATEGORY_ID)
                ->references(AnnouncementCategory::ID)->on(AnnouncementCategory::TABLE)
                ->onUpdate('cascade');

            $table->foreign(Announcement::ASSIGNED_TO)
                ->references(User::ID)->on(User::TABLE)
                ->onUpdate('cascade');

            $table->foreign(Announcement::APARTMENT_ID)
                ->references(Apartment::ID)->on(Apartment::TABLE)
                ->onUpdate('cascade');

            $table->foreign(Announcement::BUSINESS_ID)
                ->references(Business::ID)->on(Business::TABLE)
                ->onUpdate('cascade');

            $table->foreign(Announcement::BUILDING_ID)
                ->references(Building::ID)->on(Building::TABLE)
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Announcement::TABLE);
    }
}
