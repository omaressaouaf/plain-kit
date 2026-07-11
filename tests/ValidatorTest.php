<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\Validator;

class ValidatorTest extends TestCase
{
    public function test_exists_returns_true_for_non_empty_values(): void
    {
        $this->assertTrue(Validator::exists('hello'));
        $this->assertTrue(Validator::exists(1));
        $this->assertTrue(Validator::exists(['a']));
    }

    public function test_exists_returns_false_for_empty_values(): void
    {
        $this->assertFalse(Validator::exists(''));
        $this->assertFalse(Validator::exists(null));
        $this->assertFalse(Validator::exists([]));
    }

    public function test_in_checks_membership(): void
    {
        $this->assertTrue(Validator::in('admin', ['admin', 'user']));
        $this->assertFalse(Validator::in('guest', ['admin', 'user']));
    }

    public function test_string_checks_trimmed_strings(): void
    {
        $this->assertTrue(Validator::string('hello'));
        $this->assertTrue(Validator::string('  spaced  '));
        $this->assertFalse(Validator::string(''));
        $this->assertFalse(Validator::string('   '));
    }

    public function test_numeric_checks_numeric_values(): void
    {
        $this->assertTrue(Validator::numeric(10));
        $this->assertTrue(Validator::numeric('10.5'));
        $this->assertFalse(Validator::numeric('abc'));
    }

    public function test_email_validates_email_addresses(): void
    {
        $this->assertTrue(Validator::email('user@example.com'));
        $this->assertFalse(Validator::email('not-an-email'));
    }

    public function test_min_validates_numbers_strings_and_arrays(): void
    {
        $this->assertTrue(Validator::min(5, 3));
        $this->assertTrue(Validator::min('hello', 3));
        $this->assertTrue(Validator::min(['a', 'b', 'c'], 2));
        $this->assertFalse(Validator::min('hi', 5));
    }

    public function test_max_validates_numbers_strings_and_arrays(): void
    {
        $this->assertTrue(Validator::max(3, 5));
        $this->assertTrue(Validator::max('hi', 5));
        $this->assertTrue(Validator::max(['a'], 2));
        $this->assertFalse(Validator::max('hello', 3));
    }
}
