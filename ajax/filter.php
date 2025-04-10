<?php
/**
 * Filters data based on text input
 */

require_once 'lib/helpers.php';

// Check if source parameter is provided
if( ! isset($_GET['source']) ) 
{
  header('HTTP/1.1 400 Bad Request');
  echo json_encode(['error' => 'No data source specified']);
  exit;
}

$source = $_GET['source'];
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

try 
{
  // Parse data file
  $data = parseDataFile($source);
  
  // Filter data
  $filteredData = filterData($data, $filter);
  
  // Return filtered data as JSON
  header('Content-Type: application/json');
  echo json_encode(['data' => array_values($filteredData)]);
}
catch( Exception $e ) 
{
  header('HTTP/1.1 500 Internal Server Error');
  echo json_encode(['error' => $e->getMessage()]);
}
