<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leaves', function ($table) {
            $table->date('leave_from_date')->nullable()->after('leave_type_id');
            $table->date('leave_to_date')->nullable()->after('leave_from_date');
            $table->smallInteger('leave_duration_day')->default(0)->comment('0:N/A,1:half day,2:full day,3:specified hours')->after('leave_to_date');
            $table->smallInteger('leave_slot_day')->default(0)->comment('0:N/A,1:pre lunch,2:post lunch')->after('leave_duration_day');
            $table->string('leave_from_time')->default('')->after('leave_slot_day');
            $table->string('leave_to_time')->default('')->after('leave_slot_day');
            $table->foreign('leave_type_id')->references('leave_type_id')->on('leave_type');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leaves', function ($table) {
            $table->dropColumn('leave_from_date');
            $table->dropColumn('leave_to_date');
            $table->dropColumn(['leave_duration_day']);
            $table->dropColumn(['leave_slot_day']);
            $table->dropColumn(['leave_from_time']);
            $table->dropColumn(['leave_to_time']);
            $table->dropForeign(['leave_type_id']);
        });
    }
}
