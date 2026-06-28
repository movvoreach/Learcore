<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'email_otp_code')) {
                $table->string('email_otp_code', 10)->nullable()->after('email_verified_at');
            }

            if (! Schema::hasColumn('users', 'email_otp_sent_at')) {
                $table->timestamp('email_otp_sent_at')->nullable()->after('email_otp_code');
            }

            if (! Schema::hasColumn('users', 'email_otp_expires_at')) {
                $table->timestamp('email_otp_expires_at')->nullable()->after('email_otp_sent_at');
            }

            if (! Schema::hasColumn('users', 'email_otp_verified_at')) {
                $table->timestamp('email_otp_verified_at')->nullable()->after('email_otp_expires_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'email_otp_verified_at')) {
                $table->dropColumn('email_otp_verified_at');
            }

            if (Schema::hasColumn('users', 'email_otp_expires_at')) {
                $table->dropColumn('email_otp_expires_at');
            }

            if (Schema::hasColumn('users', 'email_otp_sent_at')) {
                $table->dropColumn('email_otp_sent_at');
            }

            if (Schema::hasColumn('users', 'email_otp_code')) {
                $table->dropColumn('email_otp_code');
            }
        });
    }
};
