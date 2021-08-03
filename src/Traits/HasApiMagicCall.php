<?php

namespace NovadayCo\LaravelApiResponse\Traits;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
trait HasApiMagicCall{

	public function __call($method,$arguments) {
        return $this->caller($method,$arguments);
    }

    public static function __callStatic($method, $arguments){
        $object = new self;
        return $object->caller($method,$arguments);
    }

    private function caller($method,$arguments){
        $methodNameParts = explode('_',Str::snake($method));

        // check positive or negative
        if(count($methodNameParts) > 1)
        {
            if(isset($methodNameParts[0]) && $methodNameParts[0] == 'not')
                return  Lang::has('api.'. Str::snake($method)) ? self::failure(Lang::get('api.'. Str::snake($method)), $arguments[0] ?? null): self::failure(' ('.$method.') Translation Not Found'); // todo return exception
            else
                return Lang::has('api.'. Str::snake($method)) ? self::success(Lang::get('api.'. Str::snake($method)), $arguments[0] ?? null) : self::failure(' ('.$method.') Translation Not Found');  // todo return exception
        }
        else if(isset($methodNameParts[0]) && $methodNameParts[0] != 'not')
            return  Lang::has('api.'. Str::snake($method)) ? self::success(Lang::get('api.'. Str::snake($method)), $arguments[0] ?? null): self::failure(' ('.$method.') Translation Not Found'); // todo return exception
        else
            return self::failure();  // todo return exception
    }

}
