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
    Table View Component
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
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize detail view
      const detailView = new DetailView({
        container: 'detail-view'
      });
      
      // Initialize table view
      const tableView = new TableView({
        container: 'table-view',
        recordsPerPage: 100,
        columns: null,  // Will use first 5 columns by default
        style: 'default'
      });
      
      // Connect table view with detail view
      tableView.setDetailView(detailView);
      
      // Handle data source selection
      document.getElementById('load-data-btn').addEventListener('click', function() {
        const dataSource = document.getElementById('data-source').value;
        tableView.loadData(dataSource);
      });
      
      // Load initial data if data sources are available
      if( document.getElementById('data-source').options.length > 0 ) {
        tableView.loadData(document.getElementById('data-source').value);
      }
      
      // Setup filter button
      document.getElementById('filter-button').addEventListener('click', function() {
        const filterText = document.getElementById('filter-input').value;
        tableView.filter(filterText);
      });
      
      // Setup filter on enter key
      document.getElementById('filter-input').addEventListener('keyup', function(event) {
        if( event.key === 'Enter' ) {
          const filterText = this.value;
          tableView.filter(filterText);
        }
      });
      
      // Setup load more button
      document.getElementById('load-more-button').addEventListener('click', function() {
        tableView.loadMore();
      });
      
      // Setup detail view close button
      document.querySelector('.detail-close').addEventListener('click', function() {
        detailView.hide();
      });
      
      // Handle responsive behavior
      window.addEventListener('resize', function() {
        if( window.innerWidth <= 576 ) {
          // Mobile view - detail view as overlay
          document.querySelector('.detail-container').classList.add('mobile-view');
        } else {
          // Desktop view - detail view at the side
          document.querySelector('.detail-container').classList.remove('mobile-view');
        }
      });
      
      // Initial check for responsive layout
      if( window.innerWidth <= 576 ) {
        document.querySelector('.detail-container').classList.add('mobile-view');
      }
    });
  </script>
</body>
</html>
