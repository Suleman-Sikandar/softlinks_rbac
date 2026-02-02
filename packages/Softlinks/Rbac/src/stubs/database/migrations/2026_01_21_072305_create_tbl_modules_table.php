<?php

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
        Schema::create('tbl_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_category_id')->constrained('tbl_module_categories')->onDelete('cascade');
            $table->string('module_name')->nullable();
            $table->string('route')->nullable();
            $table->boolean('show_in_menu')->default(false)->comment('no=0, yes=1');
            $table->string('css_class')->nullable();
            $table->integer('display_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_modules');
    }
};
