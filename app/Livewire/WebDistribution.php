<?php

namespace App\Livewire;

class WebDistribution extends ProgramList
{
    protected function getApplicationKey(): string
    {
        return 'distribution';
    }
}
