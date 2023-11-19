
**example.php:**

````php
return [
    'first_section' => [
        'one' => '1',
        'test' => 'sample',
        'version' => ['7.0','7.1','7.2','7.3'],
    ],
];
````

````php
$path = "example.php";
$items = require $path;

$conf = new Config($items);

$path = "example.php";
$conf = new Config::fromPath($path);



````

