/**
 * TableView Class
 * Handles displaying and interacting with tabular data
 */
class TableView {
  /**
   * Constructor for TableView
   * @param {Object} options - Configuration options
   * @param {string} options.container - ID of the container element
   * @param {number} options.recordsPerPage - Number of records to show initially (default: 100)
   * @param {Array|number|null} options.columns - Columns to show (array of names, number of first columns, or null for default)
   * @param {string} options.style - Styling to use ('default' or 'bs')
   */
  constructor(options) {
    // Set default options
    this.options = Object.assign({
      container: 'table-view',
      recordsPerPage: 100,
      columns: null,
      style: 'default'
    }, options);
    
    // Initialize properties
    this.container = document.getElementById(this.options.container);
    this.data = [];
    this.filteredData = [];
    this.displayedData = [];
    this.columns = [];
    this.currentPage = 1;
    this.currentSort = { column: null, direction: 'asc' };
    this.currentFilter = '';
    this.dataSource = '';
    this.dataType = '';
    this.detailView = null;
    
    // Create table container
    this.tableContainer = document.createElement('div');
    this.tableContainer.className = 'table-view-container';
    this.container.appendChild(this.tableContainer);
  }
  
  /**
   * Set the detail view component
   * @param {DetailView} detailView - DetailView instance for showing record details
   */
  setDetailView(detailView) {
    this.detailView = detailView;
  }
  
  /**
   * Load data from a source URL
   * @param {string} url - URL to load data from
   */
  loadData(url) {
    this.dataSource = url;
    
    // Determine data type from URL
    const extension = url.split('.').pop().toLowerCase();
    this.dataType = extension;
    
    // Show loading state
    this.showLoading();
    
    // Fetch data via AJAX
    fetch(`ajax.php?action=getData&source=${encodeURIComponent(url)}`)
      .then(response => {
        if( ! response.ok ) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(response => {
        if( response.error ) {
          this.showError(response.error);
          return;
        }
        
        this.data = response.data;
        this.filteredData = [...this.data];
        
        // Determine columns
        this.determineColumns();
        
        // Render the table
        this.render();
      })
      .catch(error => {
        this.showError(`Failed to load data: ${error.message}`);
      });
  }
  
  /**
   * Determine which columns to display
   */
  determineColumns() {
    if( this.data.length === 0 ) {
      this.columns = [];
      return;
    }
    
    // Get all available columns from first record
    const allColumns = Object.keys(this.data[0]);
    
    // Determine which columns to show based on options
    if( Array.isArray(this.options.columns) ) {
      // Use specified column names
      this.columns = this.options.columns.filter(col => allColumns.includes(col));
    } else if( typeof this.options.columns === 'number' ) {
      // Use specified number of first columns
      this.columns = allColumns.slice(0, this.options.columns);
    } else {
      // Default: use first 5 columns or all if less than 5
      this.columns = allColumns.slice(0, Math.min(5, allColumns.length));
    }
  }
  
  /**
   * Render the table with current data
   */
  render() {
    // Clear the container
    this.tableContainer.innerHTML = '';
    
    // Calculate which records to display
    const startIndex = 0;
    const endIndex = this.options.recordsPerPage * this.currentPage;
    this.displayedData = this.filteredData.slice(startIndex, endIndex);
    
    // Create header row
    const headerRow = document.createElement('div');
    headerRow.className = 'table-row table-header';
    
    this.columns.forEach(column => {
      const headerCell = document.createElement('div');
      headerCell.className = 'table-cell sortable';
      headerCell.textContent = column;
      headerCell.dataset.column = column;
      
      // Add sort indicators if this is the current sort column
      if( this.currentSort.column === column ) {
        headerCell.classList.add(this.currentSort.direction === 'asc' ? 'sorted-asc' : 'sorted-desc');
      }
      
      // Add click event for sorting
      headerCell.addEventListener('click', () => this.sortBy(column));
      
      headerRow.appendChild(headerCell);
    });
    
    this.tableContainer.appendChild(headerRow);
    
    // Create data rows
    this.displayedData.forEach((record, index) => {
      const row = document.createElement('div');
      row.className = 'table-row';
      row.dataset.index = index;
      
      // Add click event for showing details
      row.addEventListener('click', () => {
        // Remove selected class from all rows
        document.querySelectorAll('.table-row').forEach(r => r.classList.remove('selected'));
        // Add selected class to clicked row
        row.classList.add('selected');
        // Show details for this record
        if( this.detailView ) {
          this.detailView.showDetails(record);
        }
      });
      
      // Create cells for each column
      this.columns.forEach(column => {
        const cell = document.createElement('div');
        cell.className = 'table-cell';
        cell.dataset.label = column;
        cell.textContent = record[column] || '';
        row.appendChild(cell);
      });
      
      this.tableContainer.appendChild(row);
    });
    
    // Add "Load More" button if there are more records to load
    if( this.displayedData.length < this.filteredData.length ) {
      const loadMoreRow = document.createElement('div');
      loadMoreRow.className = 'load-more-container';
      
      const loadMoreButton = document.createElement('button');
      loadMoreButton.id = 'load-more-button';
      loadMoreButton.className = 'btn btn-light w-100 py-2';
      loadMoreButton.textContent = 'Load More';
      loadMoreButton.addEventListener('click', () => this.loadMore());
      
      loadMoreRow.appendChild(loadMoreButton);
      this.tableContainer.appendChild(loadMoreRow);
    }
    
    // Make the table responsive
    this.makeResponsive();
  }
  
  /**
   * Make the table responsive by adding foldable columns
   */
  makeResponsive() {
    // Get viewport width
    const viewportWidth = window.innerWidth;
    
    // On small screens, we don't need to do anything as CSS will handle it
    if( viewportWidth <= 576 ) {
      return;
    }
    
    // For medium screens, make some columns foldable
    if( viewportWidth > 576 && viewportWidth < 992 ) {
      // If we have more than 3 columns, make the rest foldable
      if( this.columns.length > 3 ) {
        const foldableColumns = this.columns.slice(3);
        
        // Add foldable class to cells in these columns
        document.querySelectorAll('.table-row').forEach(row => {
          const cells = row.querySelectorAll('.table-cell');
          
          foldableColumns.forEach((column, index) => {
            const cellIndex = this.columns.indexOf(column);
            if( cellIndex >= 0 && cells[cellIndex] ) {
              const cell = cells[cellIndex];
              
              // For header row, add expand/collapse button
              if( row.classList.contains('table-header') ) {
                cell.classList.add('foldable-cell');
                
                const expandButton = document.createElement('button');
                expandButton.className = 'expand-button';
                expandButton.textContent = '+';
                expandButton.addEventListener('click', (e) => {
                  e.stopPropagation(); // Prevent sorting when clicking the button
                  this.toggleFoldableColumn(cellIndex);
                });
                
                cell.appendChild(expandButton);
              }
              
              // Initially hide foldable cells
              cell.style.display = 'none';
            }
          });
        });
      }
    }
  }
  
  /**
   * Toggle visibility of a foldable column
   * @param {number} columnIndex - Index of the column to toggle
   */
  toggleFoldableColumn(columnIndex) {
    const headerCells = document.querySelectorAll('.table-row.table-header .table-cell');
    const headerCell = headerCells[columnIndex];
    const expandButton = headerCell.querySelector('.expand-button');
    const isExpanded = expandButton.textContent === '-';
    
    // Update button text
    expandButton.textContent = isExpanded ? '+' : '-';
    
    // Toggle visibility of cells in this column
    document.querySelectorAll('.table-row').forEach(row => {
      const cells = row.querySelectorAll('.table-cell');
      if( cells[columnIndex] ) {
        cells[columnIndex].style.display = isExpanded ? 'none' : 'block';
      }
    });
  }
  
  /**
   * Sort data by a column
   * @param {string} column - Column to sort by
   */
  sortBy(column) {
    // Determine sort direction
    let direction = 'asc';
    if( this.currentSort.column === column ) {
      // Toggle direction if already sorting by this column
      direction = this.currentSort.direction === 'asc' ? 'desc' : 'asc';
    }
    
    // Update current sort
    this.currentSort = { column, direction };
    
    // Show loading state
    this.showLoading();
    
    // Sort via AJAX to consider all data
    fetch(`ajax.php?action=sortData&source=${encodeURIComponent(this.dataSource)}&column=${encodeURIComponent(column)}&direction=${direction}&filter=${encodeURIComponent(this.currentFilter)}`)
      .then(response => {
        if( ! response.ok ) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(response => {
        if( response.error ) {
          this.showError(response.error);
          return;
        }
        
        this.filteredData = response.data;
        this.currentPage = 1;
        this.render();
      })
      .catch(error => {
        this.showError(`Failed to sort data: ${error.message}`);
      });
  }
  
  /**
   * Filter data by text
   * @param {string} text - Text to filter by
   */
  filter(text) {
    this.currentFilter = text;
    
    // Show loading state
    this.showLoading();
    
    // Filter via AJAX to consider all data
    fetch(`ajax.php?action=filterData&source=${encodeURIComponent(this.dataSource)}&filter=${encodeURIComponent(text)}`)
      .then(response => {
        if( ! response.ok ) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(response => {
        if( response.error ) {
          this.showError(response.error);
          return;
        }
        
        this.filteredData = response.data;
        this.currentPage = 1;
        
        // Apply current sort if any
        if( this.currentSort.column ) {
          this.sortBy(this.currentSort.column);
        } else {
          this.render();
        }
      })
      .catch(error => {
        this.showError(`Failed to filter data: ${error.message}`);
      });
  }
  
  /**
   * Load more records
   */
  loadMore() {
    this.currentPage++;
    this.render();
  }
  
  /**
   * Show loading state
   */
  showLoading() {
    this.tableContainer.innerHTML = '<div class="loading">Loading data...</div>';
  }
  
  /**
   * Show error message
   * @param {string} message - Error message to display
   */
  showError(message) {
    const errorElement = document.createElement('div');
    errorElement.className = 'error-message';
    errorElement.textContent = message;
    
    this.tableContainer.innerHTML = '';
    this.tableContainer.appendChild(errorElement);
  }
}
