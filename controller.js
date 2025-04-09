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
  
  // Get data source from URL parameter
  function getDataSourceFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('source');
  }
  
  // Load data based on URL parameter
  const dataSource = getDataSourceFromUrl();
  if( dataSource ) {
    tableView.loadData(dataSource);
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
