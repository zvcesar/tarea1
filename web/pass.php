<?php
use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;

if (pathinfo(__FILE__, PATHINFO_FILENAME) == 'admin-pass-reset') {
  die('Please change your file name to a random string to continue');
}

// Boot Drupal.
$autoloader = require __DIR__ . '/autoload.php';

$request = Request::createFromGlobals();
$kernel = DrupalKernel::createFromRequest($request, $autoloader, 'prod', FALSE);
$kernel->boot();

// Get password hasher service.
$password_hasher = $kernel->getContainer()->get('password');

// Hash password.

 $newhash =  $password_hasher->hash($_GET['12345']);



// Update user password.
$updatepass = Drupal::database()->update('users_field_data')
  ->fields(array(
    'pass' => $newhash,
//  'name' => 'admin',
//	'mail' => 'yourmail@example.com'
  ))
  ->condition('uid', '1', '=')
  ->execute();

// Clean user 1 cache.
Drupal::cache('entity')->delete('values:user:1');

print "Done. Please delete this file as soon as possible"; 