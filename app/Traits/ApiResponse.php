<?php

namespace App\Traits;


use Symfony\Component\HttpFoundation\Response as FoundationResponse;

trait ApiResponse
{
    /**
     * @var int
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {

        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param $data
     * @param array $header
     *
     * @return mixed
     */
    private function respond($data, $header = [])
    {
        return response()->json($data, $this->getStatusCode(), $header);
    }

    /**
     * @param array $data
     * @param null $code
     *
     * @return mixed
     */
    private function status(array $data, $code = null)
    {

        if ($code) {
            $this->setStatusCode($code);
        }

        return $this->respond($data);
    }

    /**
     * @param string $message
     * @param array $data
     *
     * @return mixed
     */
    private function message($message, $data = [])
    {
        return $this->status(['message' => $message, 'data' => $data]);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function internalError($message = "Internal Error!")
    {
        return $this->setStatusCode(FoundationResponse::HTTP_INTERNAL_SERVER_ERROR)
            ->message($message);
    }

    /**
     * @param array $data
     * @param string $message
     *
     * @return mixed
     */
    public function created($data = [], $message = "created")
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)
            ->message($message, $data);
    }

    /**
     * @param $data
     * @param string $message
     *
     * @return mixed
     */
    public function success($data, $message = 'success')
    {
        return $this->setStatusCode(FoundationResponse::HTTP_UNAUTHORIZED)
            ->message($message, $data);
    }

    /**
     * @param array $data
     * @param string $message
     *
     * @return mixed
     */
    public function error($data = [], $message = 'error')
    {
        return $this->setStatusCode(FoundationResponse::HTTP_UNAUTHORIZED)
            ->message($message, $data);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function unAuth($message = 'Unauthorized')
    {
        return $this->setStatusCode(FoundationResponse::HTTP_UNAUTHORIZED)
            ->message($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function forbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(FoundationResponse::HTTP_FORBIDDEN)
            ->message($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function notFond($message = 'Not Fond!')
    {
        return $this->setStatusCode(Foundationresponse::HTTP_NOT_FOUND)
            ->message($message);
    }

    /**
     * @param array $data
     * @param string $message
     *
     * @return mixed
     */
    public function unProcessable($data = [], $message = 'Unprocessable Entity')
    {
        return $this->setStatusCode(Foundationresponse::HTTP_UNPROCESSABLE_ENTITY)
            ->message($message, $data);
    }
}
