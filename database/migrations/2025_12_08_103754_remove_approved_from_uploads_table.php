<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('submitted', function (Blueprint $table) {
            if (Schema::hasColumn('submitted', 'approved')) {
                $table->dropColumn('approved');
            }
        });
    }

    public function down()
    {
        Schema::table('submitted', function (Blueprint $table) {
            $table->boolean('approved')->default(false);
        });
    }


};
