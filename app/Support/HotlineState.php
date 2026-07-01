<?php

namespace App\Support;

class HotlineState
{
    public const NEW = 'new';
    public const AWAITING_BIODATA = 'awaiting_biodata';
    public const AWAITING_NAME = 'awaiting_name';
    public const AWAITING_SEMESTER = 'awaiting_semester';
    public const AWAITING_CAMPUS = 'awaiting_campus';
    public const AWAITING_MAJOR = 'awaiting_major';
    public const AWAITING_REFERRAL = 'awaiting_referral';
    public const WAITING_ADMIN = 'waiting_admin';
    public const CLOSED = 'closed';

    public static function guidedStates(): array
    {
        return [
            self::AWAITING_NAME,
            self::AWAITING_SEMESTER,
            self::AWAITING_CAMPUS,
            self::AWAITING_MAJOR,
        ];
    }
}
