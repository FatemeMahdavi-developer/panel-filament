<?php

use App\Enums\PatientStatusEnum;
use App\Enums\PatientTypeEnum;

return [
    PatientTypeEnum::class => [
        PatientTypeEnum::CAT->name => 'گربه',
        PatientTypeEnum::DOG->name => 'سگ',
        PatientTypeEnum::RABBIT->name => 'خرگوش',
        PatientTypeEnum::SNAKE->name => 'مار',
    ],
    PatientStatusEnum::class =>[
        PatientStatusEnum::PENDING->name => 'در انتظار معاینه',
        PatientStatusEnum::IN_SURGERY->name => 'در اتاق عمل',
        PatientStatusEnum::RECOVERING->name => 'در حال بهبود',
        PatientStatusEnum::CRITICAL->name =>  'اورژانسی',
        PatientStatusEnum::DECEASED->name =>   'فوت شده',
    ]
];
