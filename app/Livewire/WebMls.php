<?php

namespace App\Livewire;

class WebMls extends ProgramList
{
    protected function getApplicationKey(): string
    {
        return 'mls';
    }
}
