<?php

use App\Enums\PageTypeEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->enum('type', PageTypeEnum::getValues())->nullable()->default(null);
            $table->string('slug', 255);
            $table->enum('status', StatusEnum::getValues())->default(StatusEnum::Active->value);
            $table->enum('quick_link', array_keys(StatusEnum::getYesNoSelectArray()))->default(StatusEnum::No->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
