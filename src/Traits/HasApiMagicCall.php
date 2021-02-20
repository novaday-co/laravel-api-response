<?php

namespace FarazinCo\LaravelApiResponse\Traits;

use Illuminate\Support\Facades\Lang;

trait HasApiMagicCall{

	public function __call($method,$arguments) {
        return $this->caller($method,$arguments);
    }

    public static function __callStatic($method, $arguments){
        $object = new self;
        return $object->caller($method,$arguments);
    }

    private function caller($method,$arguments){
        $methodNameParts = explode('_',snake_case($method));

        // check positive or negative
        if(count($methodNameParts) > 1)
        {
            if(isset($methodNameParts[0]) && $methodNameParts[0] == 'not')
                return  Lang::has('api.'. snake_case($method)) ? self::failure(__('api.'. snake_case($method)), $arguments[0] ?? null): self::failure(' ('.$method.') Translation Not Found'); // todo return exception
            else
                return Lang::has('api.'. snake_case($method)) ? self::success(__('api.'. snake_case($method)), $arguments[0] ?? null) : self::failure(' ('.$method.') Translation Not Found');  // todo return exception
        }
        else if(isset($methodNameParts[0]) && $methodNameParts[0] != 'not')
            return  Lang::has('api.'. snake_case($method)) ? self::success(__('api.'. snake_case($method)), $arguments[0] ?? null): self::failure(' ('.$method.') Translation Not Found'); // todo return exception
        else
            return self::failure();  // todo return exception
    }

}
