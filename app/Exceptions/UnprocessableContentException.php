<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use Throwable;

class UnprocessableContentException extends Exception
{

    protected MessageBag $messageBag;

    public function __construct(MessageBag $messageBag, $message = "", $code = 422, Throwable $previous = null)
    {
        $this->messageBag = $messageBag;
        parent::__construct($message, $code, $previous);
    }


    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->message,
            'context' => 'data_validation',
            'errors' => $this->mapObjectKeys($this->messageBag->getMessages()),
            'status_code' => $this->getCode(),
        ], $this->getCode());
    }


    /**
     * @param array $messages
     * @return array
     */
    protected function mapObjectKeys(array $messages): array
    {
        foreach ($messages as $key => $value) {
            if (str_contains($key, '.')) {
                $parts = explode('.', $key);
                $object = $parts[0];
                $property = $parts[1];
                $messages[$object][$property] = $value;
                unset($messages[$key]);
            }
        }
        return $messages;
    }
}
