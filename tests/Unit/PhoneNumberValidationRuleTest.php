<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Rules\PhoneNumber;

final class PhoneNumberValidationRuleTest extends TestCase
{
    // https://worldpopulationreview.com/country-rankings/phone-number-length-by-country
    private array $validPhoneNumbers = [
        'minimum digits' => '+1 1 1 1',
        'standard US' => '+1 234 567 8901',
        'maximum digits' => '+850 1234 5678 9012 34',
        'single group' => '+1 1234',
        'two groups' => '+1 1234 5678',
        'three groups' => '+1 1234 5678 9012',
        'four groups' => '+1 1234 5678 9012 3456',
        'spaces allowed' => '+44 20 1234 5678',
    ];

    private array $notValidPhoneNumbers = [
        'missing plus sign' => '1 234 567 8901',
        'too short' => '+1 1 1',
        'too long' => '+850 1234 5678 9012 3456',
        'invalid format' => '+1-234-567-8901',
        'non-numeric characters' => '+1 234A 567 8901',
        'leading zero country code' => '+012 3456 7890',
        'empty string' => '',
        'only plus sign' => '+',
        'whitespace only' => '    ',
        'multiple plus signs' => '++1 234 567 8901',
    ];

    public function testValidSuccess(): void
    {
        $validationRule = new PhoneNumber();

        foreach ($this->validPhoneNumbers as $message => $number) {
            $fail = false;
            $failMessage = '';
            $validationRule->validate('phonenumber', $number, function (string $message) use (&$fail, &$failMessage) {
                $fail = true;
                $failMessage = $message;
            });

            $this->assertFalse($fail, $message);
            $this->assertEmpty($failMessage, $message);
        }
    }

    public function testValidFail(): void
    {
        $validationRule = new PhoneNumber();

        foreach ($this->notValidPhoneNumbers as $message => $number) {
            $fail = false;
            $failMessage = '';
            $validationRule->validate('phonenumber', $number, function (string $message) use (&$fail, &$failMessage) {
                $fail = true;
                $failMessage = $message;
            });

            $this->assertTrue($fail, $message);
            $this->assertNotEmpty($failMessage, $message);
        }
    }
}
