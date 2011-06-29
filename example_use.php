<?php
// Base API Class
require 'APIBaseClass.php';

require 'fedSpendingApi.php';

$new = new fedSpendingApi();

echo $new->contracts(array('state'=>'AL','recipient_name'=>'Smith'));

// Debug information
die(print_r($new).print_r(get_object_vars($new)).print_r(get_class_methods(get_class($new))));
