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
    // Check if we're on mobile
    const isMobile = window.innerWidth <= 767.98;
    
    if (isMobile) {
      // Check if we have a modal (Bootstrap version) or use overlay (custom styles version)
      const modal = document.getElementById('recordDetailModal');
      if (modal) {
        // Show details in modal on mobile (Bootstrap version)
        this.showDetailsInModal(record);
      } else {
        // Show details in overlay on mobile (custom styles version)
        this.showDetailsInOverlay(record);
      }
    } else {
      // Show details in sidebar on desktop
      this.showDetailsInSidebar(record);
    }
  }
  
  /**
   * Show details in the sidebar (desktop)
   * @param {Object} record - Record to show details for
   */
  showDetailsInSidebar(record) {
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
  }
  
  /**
   * Show details in overlay (mobile - custom styles version)
   * @param {Object} record - Record to show details for
   */
  showDetailsInOverlay(record) {
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
    
    // Show the overlay if mobile-view class is present
    if( this.container.classList.contains('mobile-view') ) {
      this.container.classList.add('active');
    }
  }
  
  /**
   * Show details in modal (mobile - Bootstrap version)
   * @param {Object} record - Record to show details for
   */
  showDetailsInModal(record) {
    const modalContent = document.getElementById('modal-detail-content');
    if (!modalContent) return;
    
    // Clear the modal content
    modalContent.innerHTML = '';
    
    // Create detail items for each property in the record
    for( const key in record ) {
      const detailItem = document.createElement('div');
      detailItem.className = 'detail-item mb-3';
      
      const label = document.createElement('div');
      label.className = 'detail-label fw-bold text-muted small';
      label.textContent = key;
      
      const value = document.createElement('div');
      value.className = 'detail-value';
      value.textContent = record[key] || '';
      
      detailItem.appendChild(label);
      detailItem.appendChild(value);
      
      modalContent.appendChild(detailItem);
    }
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('recordDetailModal'));
    modal.show();
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
