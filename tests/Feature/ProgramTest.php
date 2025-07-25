<?php

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can assign application program ids', function () {
    $program = Program::factory()->create();
    expect(Program::getNextApplicationProgramId($program->application))->toBe($program->application_program_id + 1);
});

test('can delete recently created programs', function () {
    $user = User::factory()->create();
    $program = Program::factory()->forUser($user)->create([
        'created_at' => now()->subHour(),
    ]);

    expect($user->can('delete', $program))->toBeTrue();
});

test('cannot delete old programs', function () {
    $user = User::factory()->create();
    $program = Program::factory()->forUser($user)->create([
        'created_at' => now()->subDays(2),
    ]);

    expect($user->can('delete', $program))->toBeFalse();
});
