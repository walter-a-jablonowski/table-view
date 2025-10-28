<?php
$theme = isset($_GET['theme']) && $_GET['theme'] === 'black' ? 'black' : 'light';
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?= $theme ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Table View Component</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="styles/styles.css?v=<?= time() ?>">
  <?php if ($theme === 'black'): ?>
    <link rel="stylesheet" href="styles/styles_dark.css?v=<?= time() ?>">
  <?php endif; ?>
  <link rel="stylesheet" href="table-view/styles.css?v=<?= time() ?>">
</head>
<body>
  <header>
    <div class="header-content">
      <div>Table View</div>
      <button id="theme-toggle" class="theme-toggle" title="Toggle theme">
        <i class="bi <?= $theme === 'black' ? 'bi-sun' : 'bi-moon' ?>"></i>
      </button>
    </div>
  </header>
  
  <div class="container">
    <div class="table-section">
      <div class="filter-container">
        <input type="text" id="filter-input" placeholder="Filter data...">
        <button id="filter-button">Filter</button>
      </div>
      
      <div id="table-view" class="table-container"></div>
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
  
  <script>
    function toggleTheme() {
      const currentTheme = document.documentElement.getAttribute('data-theme');
      const newTheme = currentTheme === 'black' ? 'light' : 'black';
      
      // Update the URL without reloading the page
      const url = new URL(window.location);
      if (newTheme === 'black') {
        url.searchParams.set('theme', 'black');
      } else {
        url.searchParams.delete('theme');
      }
      window.history.pushState({}, '', url);
      
      // Reload the page to apply the new theme
      window.location.reload();
    }
    
    document.addEventListener('DOMContentLoaded', function() {
      const themeToggle = document.getElementById('theme-toggle');
      if (themeToggle) {
        themeToggle.addEventListener('click', toggleTheme);
      }
    });
  </script>
</body>
</html>
