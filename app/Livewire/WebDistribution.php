<?php

namespace App\Livewire;

use App\Livewire\ProgramList;

class WebDistribution extends ProgramList
{

    protected function getApplicationKey(): string
    {
        return 'distribution';
    }
}
