<?php
// Table View Component - Main Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Table View Component</title>
  <link rel="stylesheet" href="styles.css?v=<?= time() ?>">
  <link rel="stylesheet" href="table-view/styles.css?v=<?= time() ?>">
</head>
<body>
  <header>
    <div class="header-content">
      <div class="title">Table View Component</div>
      <div class="nav-links">
        <a href="index_bs.php" class="bs-demo-link">Bootstrap Demo</a>
      </div>
    </div>
  </header>
  
  <div class="container">
    <div class="table-section">
      <div class="data-source-selector">
        <label for="data-source">Select Data Source:</label>
        <select id="data-source">
          <?php
          $dataFiles = scandir('data');
          foreach( $dataFiles as $file ) :
            if( $file != '.' && $file != '..' && in_array(pathinfo($file, PATHINFO_EXTENSION), ['csv', 'tsv', 'json', 'yml']) ) :
          ?>
              <option value="data/<?= $file ?>"><?= ucfirst(pathinfo($file, PATHINFO_EXTENSION)) ?> Example: <?= $file ?></option>
          <?php
            endif;
          endforeach;
          ?>
        </select>
        <button id="load-data-btn">Load Data</button>
      </div>
      
      <div class="filter-container">
        <input type="text" id="filter-input" placeholder="Filter data...">
        <button id="filter-button">Filter</button>
      </div>
      
      <div id="table-view" class="table-container"></div>
      <button id="load-more-button">Load More</button>
    </div>
    
    <div id="detail-view" class="detail-container">
      <div class="detail-header">
        <h2>Record Details</h2>
        <button class="detail-close">&times;</button>
      </div>
      <div class="detail-content"></div>
    </div>
  </div>

  <script src="table-view/detail.js?v=<?= time() ?>"></script>
  <script src="table-view/table.js?v=<?= time() ?>"></script>
  <script src="controller.js?v=<?= time() ?>"></script>
</body>
</html>
