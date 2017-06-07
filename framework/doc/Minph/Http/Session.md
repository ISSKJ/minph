# @class Minph\Http\Session


## @method construct

[SESSION_EXPIRATION] in .env is configured.(default=60*60)
[SERVER_SESSION_EXPIRATION] in .env is configured.(default=60*60)

## @method getExpiration
* @return int expiration in second

## @method get
* @param string `$key`
* @return session value

## @method has
* @param string `$key`
* @return boolean If session has the key, true. Otherwise, false.

## @method set
* @param string `$key`
* @param `$value`

## @method destroy

Destroy the session.




>Generated by [tc.make_doc_class](https://github.com/ISSKJ/toolc-dist/)