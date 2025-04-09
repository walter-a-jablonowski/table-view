<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BS Demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="table-view/styles.css?v=<?= time() ?>">
  <!-- Bootstrap Compatibility Layer -->
  <link rel="stylesheet" href="table-view/bootstrap-compat.css?v=<?= time() ?>">
  <link rel="stylesheet" href="styles/styles_bs.css?v=<?= time() ?>">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Table View</a>
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
            <div class="card-footer p-0">
              <button id="load-more-button" class="btn btn-light w-100 py-2 rounded-0">Load More</button>
            </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="table-view/detail.js?v=<?= time() ?>"></script>
  <script src="table-view/table.js?v=<?= time() ?>"></script>
  <script src="controller.js?v=<?= time() ?>"></script>
</body>
</html>
