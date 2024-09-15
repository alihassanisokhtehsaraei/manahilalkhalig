<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdms', function (Blueprint $table) {
            $table->id();
            $table->string('no')->nullable();
            $table->string('docType')->nullable();
            $table->string('mgmtCode')->nullable();
            $table->string('actCode')->nullable();
            $table->string('version')->nullable();
            $table->string('title')->nullable();
            $table->string('modDesc')->nullable();
            $table->string('s17020')->nullable();
            $table->string('s17025')->nullable();
            $table->string('s9001')->nullable();
            $table->string('s14001')->nullable();
            $table->string('s45001')->nullable();
            $table->string('pages')->nullable();
            $table->string('userLevel1')->nullable();
            $table->string('userLevel2')->nullable();
            $table->string('userLevel3')->nullable();
            $table->string('releaseDate')->nullable();
            $table->dateTime('releaseDateGregorian')->nullable();
            $table->integer('status')->nullable();
            $table->boolean('place1')->nullable();
            $table->boolean('place2')->nullable();
            $table->boolean('place3')->nullable();
            $table->boolean('place4')->nullable();
            $table->boolean('place5')->nullable();
            $table->boolean('place6')->nullable();
            $table->boolean('place7')->nullable();
            $table->boolean('place8')->nullable();
            $table->boolean('place9')->nullable();
            $table->boolean('place10')->nullable();
            $table->boolean('place11')->nullable();
            $table->boolean('place12')->nullable();
            $table->boolean('place13')->nullable();
            $table->boolean('place14')->nullable();
            $table->boolean('place15')->nullable();
            $table->boolean('place16')->nullable();
            $table->boolean('place17')->nullable();
            $table->boolean('branch1')->nullable();
            $table->boolean('branch2')->nullable();
            $table->boolean('branch3')->nullable();
            $table->boolean('branch4')->nullable();
            $table->boolean('branch5')->nullable();
            $table->boolean('branch6')->nullable();
            $table->boolean('branch7')->nullable();
            $table->boolean('branch8')->nullable();
            $table->boolean('branch9')->nullable();
            $table->boolean('branch10')->nullable();
            $table->string('creator')->nullable();
            $table->string('userInCharge1')->nullable();
            $table->dateTime('userInCharge1Date')->nullable();
            $table->string('userInCharge2')->nullable();
            $table->dateTime('userInCharge2Date')->nullable();
            $table->string('userInCharge3')->nullable();
            $table->dateTime('userInCharge3Date')->nullable();
            $table->string('userInCharge4')->nullable();
            $table->dateTime('userInCharge4Date')->nullable();
            $table->string('pdfUrl')->nullable();
            $table->string('nativeUrl')->nullable();
            $table->string('ip')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tdms');
    }
};
