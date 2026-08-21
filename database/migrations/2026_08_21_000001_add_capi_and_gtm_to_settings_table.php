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
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'gtm_id')) {
                $table->string('gtm_id')->nullable()->after('google_analytics');
            }
            if (!Schema::hasColumn('settings', 'meta_capi_token')) {
                $table->text('meta_capi_token')->nullable()->after('gtm_id');
            }
            if (!Schema::hasColumn('settings', 'meta_test_event_code')) {
                $table->string('meta_test_event_code')->nullable()->after('meta_capi_token');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['gtm_id', 'meta_capi_token', 'meta_test_event_code']);
        });
    }
};
