<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use App\Utils\Csv;

class CsvRule implements Rule
{
    private $rules = [];
    private $colNames = [];
    private $error_messages = [];

    /**
     * Create a new rule instance.
     *
     * @param  array  $rules
     * @return void
     */
    public function __construct($rules)
    {
        $this->rules = $rules;
        $this->colNames = array_keys($this->rules);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $result = false;
        $request = request();

        if($request->hasFile($attribute)) {

            $errors = [];

            // Get data
            $csv = new Csv($request->file($attribute)->get());
            $csv_data = $csv->getData();

            foreach($csv_data as $row_index => $row_data) {

                $validator = \Validator::make(
                    $row_data,
                    $this->rules
                );

                if($validator->fails()) {

                    $line_errors = $validator->errors()->toArray();
                    foreach($line_errors as $error_index => $line_error) {
                        // Add line information on error message
                        $errors[] = "Line ".($row_index+2).": ".$line_error[0];
                    }
                }
            }

            $this->error_messages = $errors;

            if(empty($errors)) {
                $result = true;
            }

        }
        return $result;
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function message()
    {
        return $this->error_messages;
    }
}
