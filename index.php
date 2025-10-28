<?php
$theme = isset($_GET['theme']) && $_GET['theme'] === 'black' ? 'dark' : 'light';
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="<?= $theme ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BS Demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="table-view/styles.css?v=<?= time() ?>">
  <!-- Bootstrap Compatibility Layer -->
  <link rel="stylesheet" href="table-view/bootstrap-compat.css?v=<?= time() ?>">
  <link rel="stylesheet" href="styles/styles_bs.css?v=<?= time() ?>">
  <?php if ($theme === 'dark'): ?>
    <link rel="stylesheet" href="styles/styles_bs_dark.css?v=<?= time() ?>">
  <?php endif; ?>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Table View</a>
      <div class="navbar-nav ms-auto">
        <button class="btn btn-outline-light btn-sm" id="theme-toggle" onclick="toggleTheme()">
          <i class="bi bi-moon-fill" id="theme-icon"></i>
        </button>
      </div>
    </div>
  </nav>

  <div class="container-fluid main-content">
    <div class="row h-100">
      <div class="col-md-8 col-lg-9 table-section">
        <div class="card h-100">
          <div class="card-header">
            <div class="row">
              <div class="col-md-12">
                <div class="input-group">
                  <input type="text" id="filter-input" class="form-control" placeholder="Filter data...">
                  <button id="filter-button" class="btn btn-outline-secondary">Filter</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body p-0 d-flex flex-column">
            <div id="table-view" class="table-container flex-grow-1"></div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4 col-lg-3 ps-0">
        <div id="detail-view" class="detail-container h-100">
          <div class="detail-header">
            <h5 class="m-0">Record Details</h5>
            <button class="detail-close btn-close"></button>
          </div>
          <div class="detail-content" style="overflow-y: auto; max-height: calc(100vh - 150px);"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Modal for Record Details -->
  <div class="modal fade" id="recordDetailModal" tabindex="-1" aria-labelledby="recordDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="recordDetailModalLabel">Record Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-detail-content">
          <!-- Record details will be populated here -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="table-view/detail.js?v=<?= time() ?>"></script>
  <script src="table-view/table.js?v=<?= time() ?>"></script>
  <script src="controller.js?v=<?= time() ?>"></script>
  
  <script>
    // Bootstrap's built-in theme toggle functionality
    function toggleTheme() {
      const htmlElement = document.documentElement;
      const themeIcon = document.getElementById('theme-icon');
      const currentTheme = htmlElement.getAttribute('data-bs-theme');
      
      if (currentTheme === 'dark') {
        htmlElement.setAttribute('data-bs-theme', 'light');
        themeIcon.className = 'bi bi-moon-fill';
        // Update URL without page reload
        const url = new URL(window.location);
        url.searchParams.delete('theme');
        window.history.replaceState({}, '', url);
      } else {
        htmlElement.setAttribute('data-bs-theme', 'dark');
        themeIcon.className = 'bi bi-sun-fill';
        // Update URL without page reload
        const url = new URL(window.location);
        url.searchParams.set('theme', 'black');
        window.history.replaceState({}, '', url);
      }
    }
    
    // Set initial icon based on current theme
    document.addEventListener('DOMContentLoaded', function() {
      const htmlElement = document.documentElement;
      const themeIcon = document.getElementById('theme-icon');
      const currentTheme = htmlElement.getAttribute('data-bs-theme');
      
      if (currentTheme === 'dark') {
        themeIcon.className = 'bi bi-sun-fill';
      } else {
        themeIcon.className = 'bi bi-moon-fill';
      }
    });
  </script>
</body>
</html>
