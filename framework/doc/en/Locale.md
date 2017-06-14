# Locale

## Add locale map configuration.
`app/locales.php`
```
return [
    '/en' => '/en/messages.php', // default
    '/ja' => '/ja/messages.php'
];

```

## Add locale mapping file.
`app/locale/en/messages.php`
```
return [
    'hello' => 'Hello'
];
```

## Register to template engine.
`app/controller/SampleController.php`
```
$locale = Locale::loadMap('messages.php');

$model = [
    'hello' => $locale->gettext('hello'),
];
View::view('index.tpl', $model);
```
