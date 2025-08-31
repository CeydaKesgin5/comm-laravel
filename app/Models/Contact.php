<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
    ];

    /**
     * Validation rules for the contact form
     * 
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ];

    /**
     * Validate the contact data
     * 
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public static function validate(array $data)
    {
        $validator = Validator::make($data, self::$rules);
        
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
