<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <flux:card>
                <flux:heading>
                    {{ __('Web Distribution') }}
                </flux:heading>
                <flux:text>
                    {{ __('Total Programs') }}: {{ \App\Models\Program::whereApplication('distribution')->count() }}
                </flux:text>
            </flux:card>

            <flux:card>
                <flux:heading>
                    {{ __('Web-MLS') }}
                </flux:heading>
                <flux:text>
                    {{ __('Total Programs') }}: {{ \App\Models\Program::whereApplication('mls')->count() }}
                </flux:text>
            </flux:card>
        </div>
    </div>
</x-layouts.app>
