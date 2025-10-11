<?php

use App\Enums\PatientStatusEnum;
use App\Enums\PatientTypeEnum;

return [
    PatientTypeEnum::class => [
        PatientTypeEnum::CAT->name => 'Cat',
        PatientTypeEnum::DOG->name => 'Dog',
        PatientTypeEnum::RABBIT->name => 'Rabbit',
        PatientTypeEnum::SNAKE->name => 'Snak',
    ],

    PatientStatusEnum::class =>[
        PatientStatusEnum::PENDING->name => 'Pending',
        PatientStatusEnum::IN_SURGERY->name => 'In Surgery',
        PatientStatusEnum::RECOVERING->name => 'Recovering',
        PatientStatusEnum::CRITICAL->name => 'Critical',
        PatientStatusEnum::DECEASED->name => 'Deceased',
    ]
];
