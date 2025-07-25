<div>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>{{ __('ID') }}</flux:table.column>
            <flux:table.column>{{ __('Name') }}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            <flux:table.row class="font-bold">
                <flux:table.cell>
                    {{ __('New') }}
                </flux:table.cell>
                <flux:table.cell>
                    <form wire:submit.prevent="saveNewProgram" class="flex flex-row space-x-4">
                        <flux:input wire:model="newProgramName"/>
                        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
                    </form>
                    <flux:error name="newProgramName" />
                </flux:table.cell>

                <flux:table.cell />
            </flux:table.row>

            @foreach($programs as $program)
                <flux:table.row>
                    <flux:table.cell>
                        {{ $program->application_program_id }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $program->name }}
                    </flux:table.cell>

                    <flux:table.cell>
                        @can('delete', $program)
                            <flux:button variant="danger" wire:click="removeProgram({{ $program->getKey() }})">
                                <flux:icon.trash />
                            </flux:button>
                        @endcan
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
