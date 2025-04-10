document.addEventListener('DOMContentLoaded', function() {
  // Initialize detail view
  const detailView = new DetailView({
    container: 'detail-view'
  });
  
  // Get columns from URL parameter
  function getColumnsFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    const colsParam = urlParams.get('cols');
    
    if( colsParam )
      return colsParam.split('|');  // split by pipe character and return as array
    
    return null; // Return null to use default behavior (first 5 columns)
  }
  
  // Initialize table view
  const tableView = new TableView({
    container:      'table-view',
    recordsPerPage: 100,
    columns:        getColumnsFromUrl(),      // Use columns from URL or default
    style:          'default'
  });
  
  // Connect table view with detail view
  tableView.setDetailView(detailView);
  
  // Get data source from URL parameter
  function getDataSourceFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('source');
  }
  
  // Function to update header text with file name
  function updateHeaderWithFileName(filePath) {
    if( !filePath ) return;
    
    // Extract file name without path and extension
    const fileName = filePath.split('/').pop().split('.')[0];
    
    // Capitalize first letter
    const capitalizedFileName = fileName.charAt(0).toUpperCase() + fileName.slice(1);
    
    // Update header text
    const headerElement = document.querySelector('.navbar-brand') || document.querySelector('.header-content > div');
    if( headerElement ) {
      headerElement.textContent = capitalizedFileName;
    }
  }
  
  // Load data based on URL parameter
  const dataSource = getDataSourceFromUrl();
  if( dataSource ) {
    tableView.loadData(dataSource);
    updateHeaderWithFileName(dataSource);
  } else {
    // Display error message when no source parameter is provided
    const tableContainer = document.getElementById('table-view');
    tableContainer.innerHTML = '<div class="error-message">Error: No data source specified. Please add a source parameter to the URL.</div>';
    
    // Hide filter and load more elements as they're not needed
    document.getElementById('filter-button').parentElement.style.display = 'none';
    document.getElementById('load-more-button').style.display = 'none';
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
    // if( window.innerWidth <= 576 )  // TASK: original for non BS was, changed to rm one controller
    if( window.innerWidth <= 767.98 )  // mobile view - detail view as overlay
      document.querySelector('.detail-container').classList.add('mobile-view');
    else  // desktop view - detail view at the side
      document.querySelector('.detail-container').classList.remove('mobile-view');
  });
  
  // Initial check for responsive layout
  // if( window.innerWidth <= 576 )
  if( window.innerWidth <= 767.98 )
    document.querySelector('.detail-container').classList.add('mobile-view');
});
