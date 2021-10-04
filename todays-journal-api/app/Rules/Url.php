<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Url implements Rule
{
    /** @var string $message */
    protected $message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(){ }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($this->hasUnderscores($value))
        {
            $this->message = __('validation.no_underscore');
            return false;
        }
        
        if($this->startsWithDash($value))
        {
            $this->message = __('validation.no_starting_dashes');
            return false;
        }

        if($this->endsWithDash($value))
        {
            $this->message = __('validation.no_ending_dashes');
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    protected function hasUnderscores($value)
    {
        return preg_match('/_/', $value);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    protected function startsWithDash($value)
    {
        return preg_match('/^-/', $value);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    protected function endsWithDash($value)
    {
        return preg_match('/-$/', $value);
    }
}
