<?php

namespace FarazinCo\LaravelApiResponse;

use FarazinCo\LaravelApiResponse\Traits\HasApiMagicCall;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use JsonSerializable;

class Api{

    use HasApiMagicCall;
    public static $data=null,$message=null,$errors=null,$code=null,$instance=null,$extra=null;

    /**
     * Return a new JSON response from the application.
     *
     * @param  string|array  $data
     * @param  int  $status
     * @param  array  $headers
     * @param  int  $options
     * @return \Illuminate\Http\JsonResponse
     */

    public function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
        if ($data instanceof Arrayable && ! $data instanceof JsonSerializable) {
            $data = $data->toArray();
        }
        return new JsonResponse($data, $status, $headers, $options);
    }

    /**
     * response
     * make a custom response
     *
     * @param  mixed $code
     * @param  mixed $message
     * @param  mixed $data
     * @param  mixed $errors
     * @return JsonResponse
     */
    public static function customResponse(int $code,?string $message = null ,$data = null,?object $errors = null){

        if (self::$instance === null)
            self::$instance = new self;

        self::$code = $code;
        self::$message = $message;
        self::$data = $data;
        self::$errors = $errors;

        return self::$instance;
    }

    /**
     * success
     * return success response to client
     *
     * @param  mixed $data
     * @param  mixed $message
     * @return JsonResponse
     */
    public static function success(?string $message=null, $data = null){

        if (self::$instance === null)
            self::$instance = new self;

        self::$code = 200;
        self::$message = $message;
        self::$data = $data;
        self::$errors = null;

        return self::$instance;
    }

    /**
     * failure
     * return failure response to client
     *
     * @param  mixed $message
     * @param  mixed $data
     * @param  mixed $errors
     * @return JsonResponse
     */
    public static function failure(?string $message=null,$data = null,?object $errors = null){

        if (self::$instance === null)
            self::$instance = new self;

        self::$code = 422;
        self::$message = $message;
        self::$data = $data;
        self::$errors = $errors;

        return self::$instance;
    }

    public function withData($extra){

        if (self::$instance === null)
            self::$instance = new self;

        self::$data = collect(self::$data)->merge($extra)->toArray();

        return self::$instance;

    }

    public function with($extra)
    {

        if (self::$instance === null)
            self::$instance = new self;

        self::$extra = $extra;

        return self::$instance;

    }

    /**
     * makeResponse
     * make & return final response
     *
     * @param  mixed $data
     * @param  mixed $message
     * @param  mixed $errors
     * @param  mixed $code
     * @return JsonResponse
     */
    public function response(): JsonResponse
    {

        $jsonResponse = [];

        if (is_object(self::$data) && isset(self::$data->response()->getData()->data)) {
            $extra = collect();
            $extra = !empty(self::$message) ? collect(['message' => self::$message]) : $extra;
            $extra = !empty(self::$errors) ? collect(['errors' => self::$errors])->merge($extra) : $extra;
            self::$data = collect([])->merge(self::$data->response()->getData())->merge($extra);

            if (!empty(self::$extra))
                self::$data = self::$data->merge(collect(self::$extra));
            return new JsonResponse(self::$data, self::$code);
        }

        if(!empty(self::$data)) $jsonResponse['data'] = self::$data ?? null;
        if(!empty(self::$message)) $jsonResponse['message'] = self::$message ?? null;
        if(!empty(self::$errors)) $jsonResponse['errors'] = self::$errors ?? null;

        if (!empty(self::$extra))
            $jsonResponse = array_merge($jsonResponse, self::$extra);

        return new JsonResponse($jsonResponse, self::$code);
    }

}

?>
