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
