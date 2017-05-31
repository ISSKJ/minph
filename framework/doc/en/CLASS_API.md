# Class API

## Minph\App
```
/**
    Initialize Input class(user input), Header class(user header), Tracy\Debugger, Dotenv\Dotenv.
    Use on entry point of app.
    $appDirectory should contain ".env", "storage/log" directory because of these initialization.
    As use of test, it may be test directory.
    @param $appDirectory = __DIR__
*/
App::init($appDirectory);

/**
    Set template engine object implements Template interface.
    @param $template = App::make('view', 'TemplateSmarty')
*/
App::setTemplate($template);

/**
    Run application handling routing.
    @param $uri = '/user' or 'http://localhost/user'
*/
App::run($uri);

/**
    Instantiate app classes.
    @param $directory = 'service'
    @param $className = 'UserService'
    @return object
*/
App::make($directory, $className);
```

## Minph\Http\Input
```
/**
    Get user input. ($_GET, $_POST variables.)
    If required is true and its key doesn't consist, InputException occurs.
    @param $key = 'id'
    @param $required = true
    @return value
*/
Input::get($key, $required = false);
```

## Minph\Http\Header
```
/**
    Get user header.
    If required is true and its key doesn't consist, InputException occurs.
    @param $key = 'id'
    @param $required = true
    @return value
*/
Header::get($key, $required = false);
```

## Minph\Http\Route
```
/**
    Call controller method according to mapping information (route_map.php).
    @param $uri = '/user'
*/
Route::run($uri);
```

## Minph\Repository\DB
```
/**
    Instantiate PDO from parameters.
    @param $dsn = 'mysql:host=localhost;dbname=minphdb'
    @param $username = 'root'
    @param $password = ''
    @return instance of DB class.
*/
DB::__construct(string $dsn, string $username, string $password);

/**
    Query SQL statement and fetch rows.
    @param $sql = 'SELECT * FROM users WHERE id = :id'
    @param $params = [ 'id' => 1 ]
    @return array fetched rows.
*/
DB::query(string $sql, array $params = null);

/**
    Query SQL statement and fetch one row.
    @param $sql = 'SELECT * FROM users WHERE id = :id'
    @param $params = [ 'id' => 1 ];
    @return one fetched row.
*/
DB::queryOne(string $sql, array $params = null);

/**
    Execute SQL statement and return the number of affected rows.
    @param $sql = 'INSERT into users (id, name) VALUES (:id, :name)'
    @param $params = [ 'id' => 1, 'name' => 'Sample' ]
    @return the number of affected rows.
*/
DB::execute(string $sql, array $params = null);

/**
    Transactional SQL statement.

    Example:
        try {
            $db->beginTransaction();

            $db->execute(....);
            $db->execute(....);

            $db->commit();
        } catch (PDOException $e) {
            $db->rollback();
        }
*/
DB::beginTransaction();
DB::commit();
DB::rollback();

/**
    Insert data into table.
    @param $table = 'users';
    @param $input = [ 'id' => 1, 'name' => 'minph' ]
    @return the number of affected rows.
*/
DB::insert(string $table, array $input);

/**
    Delete data from table where the id exists.
    @param $table = 'user'
    @param $idColumn = 'id'
    @param $id = 1
    @return the number of affected rows.
*/
DB::delete(string $table, string $idColumn, $id);
```

## Minph\Repository\DBUtil
```
/**
    Check input value containing special characters.
    This is for SQL injection.

    @param $input = 'id, name, password'
    @param $permission = ',.*'
    @return true if it is valid, otherwise, false.
*/
DBUtil::validInput(string $input, string permission);
```

## Minph\Repository\Pool
```
/**
    Pool class is used for holding instance of object.
    Assume if you need single DB instance, just set on Pool class. 

	Example:
    Pool::set('db_master', $db);
    Pool::get('db_master');
*/
Pool::clear();
Pool::set(string $alias, $obj);
Pool::get(string $alias);
Pool::exists(string $alias);
```

## Minph\View\Template;
If you need template class which you prefer of external library, should implement it.
```
class TemplateSmarty implements Template
{
	private $template;

    public function __construct()
    {
        // create template engine.
    }
    public function view($file, $model)
    {
        // render template by each template engine.
    }
}
```

