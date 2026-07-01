<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wa_contacts', function (Blueprint $table): void {
            $table->id();
            $table->string('phone_number')->unique();
            $table->string('wa_name')->nullable();
            $table->string('name')->nullable();
            $table->string('semester')->nullable();
            $table->string('campus')->nullable()->index();
            $table->string('major')->nullable();
            $table->string('referral_code')->nullable()->index();
            $table->string('group_type', 1)->nullable()->index();
            $table->string('chat_state')->default('new')->index();
            $table->string('source')->nullable();
            $table->string('click_token')->nullable();
            $table->timestamp('first_clicked_at')->nullable();
            $table->timestamp('first_chatted_at')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamp('biodata_completed_at')->nullable();
            $table->timestamp('waiting_admin_at')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('wa_conversations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('contact_id')->constrained('wa_contacts')->cascadeOnDelete();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->string('status')->default('open')->index();
            $table->string('source')->nullable();
            $table->string('group_type', 1)->nullable();
            $table->string('campaign')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('wa_messages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('contact_id')->constrained('wa_contacts')->cascadeOnDelete();
            $table->foreignId('conversation_id')->nullable()->constrained('wa_conversations')->nullOnDelete();
            $table->string('direction')->index();
            $table->string('message_id')->index();
            $table->string('message_type')->default('text');
            $table->longText('body')->nullable();
            $table->json('payload')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('wa_analytics_events', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('contact_id')->nullable()->constrained('wa_contacts')->nullOnDelete();
            $table->foreignId('conversation_id')->nullable()->constrained('wa_conversations')->nullOnDelete();
            $table->string('event_type')->index();
            $table->string('source')->nullable()->index();
            $table->string('campaign')->nullable()->index();
            $table->string('reference')->nullable()->index();
            $table->string('phone_number')->nullable()->index();
            $table->json('payload')->nullable();
            $table->timestamp('occurred_at')->index();
        });

        Schema::create('wa_admin_followups', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('contact_id')->constrained('wa_contacts')->cascadeOnDelete();
            $table->string('admin_name')->nullable();
            $table->string('status')->default('pending')->index();
            $table->text('notes')->nullable();
            $table->timestamp('followed_up_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wa_admin_followups');
        Schema::dropIfExists('wa_analytics_events');
        Schema::dropIfExists('wa_messages');
        Schema::dropIfExists('wa_conversations');
        Schema::dropIfExists('wa_contacts');
    }
};
