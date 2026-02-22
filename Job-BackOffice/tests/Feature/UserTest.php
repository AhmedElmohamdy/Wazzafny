<?php

use App\Models\User;

test('creates a user pass', function () {

    // Arrange
    $data = [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'password' => '123456789',
        'role' => 'admin'
    ];

    // Act
    $result = User::create($data);

    // Assert
    expect($result->name)->toBe($data['name']);
});

test('creates a user fail', function () {

    // Arrange
    $data = [
        'name' => '',
        'email' => 'john.doe@example.com',
    ];

    // Act
    try {
        $result = User::create($data);
        $fail = false;
    } catch (\Illuminate\Database\QueryException $e) {
        $fail = true;
    }

    // Assert
    expect($fail)->toBeTrue();
    expect(User::where('email', 'john.doe@example.com')->exists())->toBeFalse();
});
