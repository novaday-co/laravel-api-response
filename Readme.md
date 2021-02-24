# Laravel API Response 

This Package helps developers to easily make response for API . Add extra data to **collection** response . Short magic method that use your translate files to set messages .

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
Api::success('',['key'=>'value'])->response();
```

### External data in `data`
```php
Api::success('',User::all())->withData(Customer::first())->response();
```

### External data next to `data`
```php
Api::success('',User::all())->with(['key'=>'value'])->response();
```

### Short magic method for set messages
```php
Api::updated()->response();
```