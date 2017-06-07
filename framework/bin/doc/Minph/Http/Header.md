## @function getallheaders
This is used when getallheaders function doesn't exist. (Nginx, etc.)

# @class Minph\Http\Header
It contains header information and HTTP method.

## @method construct
Instantiate Header object.

## @method get
* @param `$key` (string)
* @param `$required` (boolean)
* @throws `Minph\Exception\InputException` If `$required` is true and a header value doesn't exist, it occurs.
* @return header value


## @method getMethod
* @return `string` HTTP method. 

>Generated by [tc.make_doc_class](https://github.com/ISSKJ/toolc-dist/)