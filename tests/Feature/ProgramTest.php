<?php

use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can assign application program ids', function () {
    $program = Program::factory()->create();
    expect(Program::getNextApplicationProgramId($program->application))->toBe($program->application_program_id + 1);
});
