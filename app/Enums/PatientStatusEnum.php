<?php

namespace App\Enums;

enum PatientStatusEnum: string
{
    case PENDING = 'pending';
    case IN_SURGERY = 'in_surgery';
    case RECOVERING = 'recovering';
    case CRITICAL = 'critical';
    case DECEASED = 'deceased';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'در انتظار معاینه',
            self::IN_SURGERY => 'در اتاق عمل',
            self::RECOVERING => 'در حال بهبود',
            self::CRITICAL => 'اورژانسی',
            self::DECEASED => 'فوت شده',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'gray',
            self::IN_SURGERY => 'warning',
            self::RECOVERING => 'success',
            self::CRITICAL => 'danger',
            self::DECEASED => 'secondary',
        };
    }
}
