<?php
/**
 * Sort handler for Table View Component
 * Sorts data based on column and direction
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
$column = isset($_GET['column']) ? $_GET['column'] : '';
$direction = isset($_GET['direction']) && $_GET['direction'] === 'desc' ? 'desc' : 'asc';
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

try 
{
  // Parse data file
  $data = parseDataFile($source);
  
  // Filter data if filter is provided
  if( ! empty($filter) )
    $data = filterData($data, $filter);
  
  // Sort data
  $sortedData = sortData($data, $column, $direction);
  
  // Return sorted data as JSON
  header('Content-Type: application/json');
  echo json_encode(['data' => $sortedData]);
}
catch( Exception $e ) 
{
  header('HTTP/1.1 500 Internal Server Error');
  echo json_encode(['error' => $e->getMessage()]);
}
