<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class InvalidRequestException extends Exception
{
    use ApiResponse;

    private $data;

    public function __construct($data = null, string $message = "")
    {
        parent::__construct($message, 0);
        $this->data = $data;
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->unProcessable($this->data);
        }

        return view('pages.error', ['msg' => $this->message]);
    }
}
