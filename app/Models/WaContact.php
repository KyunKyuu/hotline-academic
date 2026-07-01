<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WaContact extends Model
{
    protected $fillable = [
        'phone_number',
        'wa_name',
        'name',
        'semester',
        'campus',
        'major',
        'referral_code',
        'group_type',
        'chat_state',
        'source',
        'click_token',
        'first_clicked_at',
        'first_chatted_at',
        'last_message_at',
        'biodata_completed_at',
        'waiting_admin_at',
        'notes',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'first_clicked_at' => 'datetime',
            'first_chatted_at' => 'datetime',
            'last_message_at' => 'datetime',
            'biodata_completed_at' => 'datetime',
            'waiting_admin_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(WaConversation::class, 'contact_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(WaMessage::class, 'contact_id');
    }

    public function analyticsEvents(): HasMany
    {
        return $this->hasMany(WaAnalyticsEvent::class, 'contact_id');
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(WaAdminFollowup::class, 'contact_id');
    }
}
