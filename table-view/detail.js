/**
 * DetailView Class
 * Handles displaying detailed information for a selected record
 */
class DetailView {
  /**
   * Constructor for DetailView
   * @param {Object} options - Configuration options
   * @param {string} options.container - ID of the container element
   */
  constructor(options) {
    // Set default options
    this.options = Object.assign({
      container: 'detail-view'
    }, options);
    
    // Initialize properties
    this.container = document.getElementById(this.options.container);
    this.contentContainer = this.container.querySelector('.detail-content');
    
    // If no content container found, create one
    if( ! this.contentContainer ) {
      this.contentContainer = document.createElement('div');
      this.contentContainer.className = 'detail-content';
      this.container.appendChild(this.contentContainer);
    }
    
    // Initialize with no record selected message
    this.showNoRecordSelected();
  }
  
  /**
   * Show details for a record
   * @param {Object} record - Record to show details for
   */
  showDetails(record) {
    // Clear the container
    this.contentContainer.innerHTML = '';
    
    // Create detail items for each property in the record
    for( const key in record ) {
      const detailItem = document.createElement('div');
      detailItem.className = 'detail-item';
      
      const label = document.createElement('span');
      label.className = 'detail-label';
      label.textContent = key;
      
      const value = document.createElement('span');
      value.className = 'detail-value';
      value.textContent = record[key] || '';
      
      detailItem.appendChild(label);
      detailItem.appendChild(value);
      
      this.contentContainer.appendChild(detailItem);
    }
    
    // Show the container on mobile
    if( window.innerWidth <= 576 ) {
      this.container.classList.add('active');
    }
  }
  
  /**
   * Show a message when no record is selected
   */
  showNoRecordSelected() {
    this.contentContainer.innerHTML = '<div class="no-record-selected">Select a record to view details</div>';
  }
  
  /**
   * Hide the detail view (for mobile)
   */
  hide() {
    if( this.container.classList.contains('mobile-view') ) {
      this.container.classList.remove('active');
    }
  }
}
