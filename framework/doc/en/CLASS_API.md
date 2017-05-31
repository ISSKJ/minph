# Class API

## Minph\App
```
/**
    Initialize Input class(user input), Header class(user header), Tracy\Debugger, Dotenv\Dotenv.
    Use on entry point of app.
    $appDirectory should contain ".env", "storage/log" directory because of these initialization.
    As use of test, it may be test directory.
*/
App::init($appDirectory);

/**
    Set template engine object implements Template interface.
*/
App::setTemplate($template);

/**
    Run application handling routing.
*/
App::run($uri);

/**
    Instantiate app classes.
*/
App::make($directory, $className);
```

## Minph\Http\Input
```
/**
    Get user input. ($_GET, $_POST variables.)
    If required is true and its key doesn't consist, InputException occurs.
*/
Input::get($key, $required = false);
```

## Minph\Http\Header
```
/**
    Get user header.
    If required is true and its key doesn't consist, InputException occurs.
*/
Header::get($key, $required = false);
```

## Minph\Http\Route
```
/**
    Call controller method according to mapping information (route_map.php).
*/
Route::run($uri);
```

## Minph\Repository\DB


