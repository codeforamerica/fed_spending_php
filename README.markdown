Overview
========

PHP Library for Federal Spending API

http://www.fedspending.org/apidoc.php

Usage
=====

<pre>
<?php

// Base API Class

require 'APIBaseClass.php';

require 'fedSpendingApi.php';

$new = new fedSpendingApi();

echo $new->contracts(array('state'=>'AL','recipient_name'=>'Smith'));

echo $new->assistance(array('recipient_name'=>'Smith', 'fiscal_year'=>2006));

echo $new->recover(array('recipient_st'=>'IA'));
// Debug information
die(print_r($new).print_r(get_object_vars($new)).print_r(get_class_methods(get_class($new))));

</pre>