<?php
/**
 * AJAX Handler for Table View Component
 * Routes AJAX requests to appropriate handlers
 */

// Prevent direct access
if( ! isset($_GET['action']) ) {
  header('HTTP/1.1 400 Bad Request');
  echo json_encode(['error' => 'No action specified']);
  exit;
}

// Route to appropriate handler based on action
$action = $_GET['action'];

switch( $action ) {
  case 'getData':
    require_once 'ajax/data.php';
    break;
    
  case 'filterData':
    require_once 'ajax/filter.php';
    break;
    
  case 'sortData':
    require_once 'ajax/sort.php';
    break;
    
  default:
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Invalid action']);
    exit;
}
