<?php

namespace App\Livewire;

use App\Models\Program;
use Flux\Flux;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

abstract class ProgramList extends Component
{
    public string $newProgramName = '';

    public function render(): View
    {
        return view('livewire.program-list', [
            'programs' => $this->getPrograms(),
        ]);
    }

    public function saveNewProgram(): void
    {
        try {
            $program = Program::create([
                'user_id' => auth()->id(),
                'application' => $this->getApplicationKey(),
                'name' => $this->newProgramName,
                'application_program_id' => Program::getNextApplicationProgramId($this->getApplicationKey()),
            ]);

            Flux::toast("Program $program->name successfully created", __('Success'), variant: 'success');
            $this->newProgramName = '';
        } catch (LockTimeoutException $e) {
            Flux::toast($e->getMessage(), variant: 'danger');
        }
    }

    public function removeProgram(Program $program): void
    {
        $program->delete();

        Flux::toast("Program $program->name successfully deleted", __('Success'), variant: 'success');
    }

    abstract protected function getApplicationKey(): string;

    private function getPrograms(): Collection
    {
        return Program::whereApplication($this->getApplicationKey())->orderByDesc('application_program_id')->get();
    }
}
