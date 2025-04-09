<?php

use Symfony\Component\Yaml\Yaml;

/**
 * Parse data from various file formats
 * @param string $filePath Path to the data file
 * @return array Parsed data as an array of records
 */
function parseDataFile( $filePath )
{
  if( ! file_exists($filePath) )
    throw new Exception("File missing: $filePath");
  
  $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
  
  switch( $extension ) {
    case 'csv':
      return parseCsvFile($filePath);
      
    case 'tsv':
      return parseTsvFile($filePath);
      
    case 'json':
      return parseJsonFile($filePath);
      
    case 'yml':
    case 'yaml':
      return parseYamlFile($filePath);
      
    default:
      throw new Exception("Unsupported file format: $extension");
  }
}

/**
 * Parse CSV file
 * @param string $filePath Path to the CSV file
 * @return array Parsed data as an array of records
 */
function parseCsvFile( $filePath )
{
  $data    = [];
  $headers = [];
  
  if( ( $handle = fopen($filePath, "r") ) !== false )
  {
    // Read headers
    if( ( $row = fgetcsv($handle) ) !== false ) {
      $headers = $row;
    }
    
    // Read data rows
    while( ( $row = fgetcsv($handle) ) !== false )
    {
      if( count($row) == count($headers) ) {
        $record = [];
        foreach( $headers as $index => $header ) {
          $record[$header] = $row[$index];
        }
        $data[] = $record;
      }
    }
    
    fclose($handle);
  }
  
  return $data;
}

/**
 * Parse TSV file (with at least 2 spaces as separator)
 * @param string $filePath Path to the TSV file
 * @return array Parsed data as an array of records
 */
function parseTsvFile( $filePath )
{
  $data    = [];
  $headers = [];
  
  if( ( $handle = fopen($filePath, "r") ) !== false )
  {
    // Read headers
    if( ( $line = fgets($handle) ) !== false ) {
      // Split by 2 or more spaces
      $headers = preg_split('/\s{2,}/', trim($line));
      
      // Trim each header to remove any extra spaces
      $headers = array_map('trim', $headers);
    }
    
    // Read data rows
    while( ( $line = fgets($handle) ) !== false ) {
      // Split by 2 or more spaces
      $row = preg_split('/\s{2,}/', trim($line));
      
      // Trim each value to remove any extra spaces
      $row = array_map('trim', $row);
      
      if( count($row) == count($headers) ) {
        $record = [];
        foreach( $headers as $index => $header ) {
          $record[$header] = $row[$index];
        }
        $data[] = $record;
      }
    }
    
    fclose($handle);
  }
  
  return $data;
}

/**
 * Parse JSON file
 * @param string $filePath Path to the JSON file
 * @return array Parsed data as an array of records
 */
function parseJsonFile( $filePath )
{
  $content = file_get_contents($filePath);
  $data    = json_decode($content, true);
  
  if( json_last_error() !== JSON_ERROR_NONE )
    throw new Exception("Invalid JSON file: " . json_last_error_msg());
  
  // Handle string keys for records by adding an id field
  
  $result = [];
  
  // check if data is an associative array (string keys)
  if( array_keys($data) !== range(0, count($data) - 1))
  {
    foreach( $data as $key => $value ) {
      if( is_array($value) ) {
        $value['id'] = $key;
        $result[] = $value;
      }
    }
  }
  else
    $result = $data;
  
  return $result;
}

/**
 * Parse YAML file
 * @param string $filePath Path to the YAML file
 * @return array Parsed data as an array of records
 */
function parseYamlFile( $filePath )
{
  $data = Yaml::parseFile($filePath);
  
  // Handle string keys for records by adding an id field

  $result = [];
  
  // check if data is an associative array (string keys)
  if( array_keys($data) !== range(0, count($data) - 1) )
  {
    foreach( $data as $key => $value ) {
      if( is_array($value) ) {
        $value['id'] = $key;
        $result[] = $value;
      }
    }
  }
  else
    $result = $data;
  
  return $result;
}

/**
 * Filter data by text
 * @param array $data Data to filter
 * @param string $filterText Text to filter by
 * @return array Filtered data
 */
function filterData( $data, $filterText )
{
  if( empty($filterText) ) {
    return $data;
  }
  
  $filterText = strtolower($filterText);
  
  return array_filter($data, function( $record ) use ( $filterText ) {
    foreach( $record as $value ) {
      if( is_string($value) && strpos(strtolower($value), $filterText) !== false ) {
        return true;
      }
    }
    return false;
  });
}

/**
 * Sort data by column
 * @param array $data Data to sort
 * @param string $column Column to sort by
 * @param string $direction Sort direction ('asc' or 'desc')
 * @return array Sorted data
 */
function sortData( $data, $column, $direction = 'asc')
{
  if( empty($column) || empty($data))
    return $data;
  
  // Create a copy of the data to avoid modifying the original
  $sortedData = $data;
  
  // Sort the data
  usort($sortedData, function( $a, $b ) use ( $column, $direction ) {
    // Get values to compare
    $valueA = isset($a[$column]) ? $a[$column] : '';
    $valueB = isset($b[$column]) ? $b[$column] : '';
    
    // Handle numeric values
    if( is_numeric($valueA) && is_numeric($valueB) ) {
      $valueA = (float)$valueA;
      $valueB = (float)$valueB;
    }
    
    // Compare values
    if( $valueA == $valueB ) {
      return 0;
    }
    
    // Determine sort order
    $result = ( $valueA < $valueB ) ? -1 : 1;
    
    // Reverse for descending order
    if( $direction === 'desc' ) {
      $result = -$result;
    }
    
    return $result;
  });
  
  return $sortedData;
}
