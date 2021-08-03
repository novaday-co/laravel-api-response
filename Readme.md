
<img src="https://raw.githubusercontent.com/faridfr/faridfr/master/200px-laravel-api-response.png" height="120" alt="Laravel API Response package" />
    
# Laravel API Response

This Package helps developers to easily make response for API . Add extra data to **collection** response . Short magic method that use your translate files to set messages .

----

## How to install :
```
composer require novaday-co/laravel-api-response
```


## How to use :

### Success response
```php
Api::success("Successful Action")->response();
```

### Success response
```php
Api::success("Successful Action")->response();
```

### Failure response
```php
Api::failure("Failed")->response();
```

### Custom response
```php
Api::customResponse(201,'Created Successfully',['key'=>'value'])->response();
```

### With `data`
```php
Api::success('Ok',['key'=>'value'])->response();
```

### External data in `data`
```php
Api::success('Ok',[ User::all() ])->withData([ Customer::first() ])->response();
```

### External data next to `data`
```php
Api::success('Ok',[ User::all() ])->with([ 'Customers' => Customer::all() ])->response();
```

### Short magic method for set messages
```php
Api::updated()->response();
```
