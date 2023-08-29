<?php

it('fails to run github:fetch-releases command', function () {
    putenv('GITHUB_PERSONAL_ACCESS_TOKEN=""');
    $this->artisan('github:fetch-releases')
        ->expectsOutput(trans('messages.github.releases.fail'))
        ->assertExitCode(0);
})->group('github');

it('Runs github:fetch-releases command successfully', function () {
    $this->artisan('github:fetch-releases')
        ->expectsOutput(trans('messages.github.releases.success'))
        ->assertExitCode(0);
})->group('github');

