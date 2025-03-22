<?php
/**
 * Data handler for Table View Component
 * Loads data from various file formats
 */

// Include helper functions
require_once __DIR__ . '/helpers.php';

// Check if source parameter is provided
if( ! isset($_GET['source']) ) 
{
  header('HTTP/1.1 400 Bad Request');
  echo json_encode(['error' => 'No data source specified']);
  exit;
}

$source = $_GET['source'];

try 
{
  // Parse data file
  $data = parseDataFile($source);
  
  // Return data as JSON
  header('Content-Type: application/json');
  echo json_encode(['data' => $data]);
}
catch( Exception $e ) 
{
  header('HTTP/1.1 500 Internal Server Error');
  echo json_encode(['error' => $e->getMessage()]);
}
