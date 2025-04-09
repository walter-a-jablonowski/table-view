<?php
/**
 * Default Data Source handler for Table View Component
 * Returns the first available data source
 */

// Set header to JSON
header('Content-Type: application/json');

// Get the first available data file
$dataFiles = [];
foreach( scandir(__DIR__ . '/../data') as $file ) {
  if( $file != '.' && $file != '..' && in_array( pathinfo($file, PATHINFO_EXTENSION), ['csv', 'tsv', 'json', 'yml']) ) {
    $dataFiles[] = 'data/' . $file;
    break; // Just need the first one
  }
}

// Return the first data source or empty if none found
if( count($dataFiles) > 0 ) {
  echo json_encode(['source' => $dataFiles[0]]);
} else {
  echo json_encode(['source' => '']);
}
