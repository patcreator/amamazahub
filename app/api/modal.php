

<script>
(function() {
  // Ensure container exists
  if (!document.getElementById('globalModalContainer')) {
    const container = document.createElement('div');
    container.id = 'globalModalContainer';
    document.body.appendChild(container);
  }

  // Global modal function
  window.global_modal = function(title = '', body = '', options = {}) {
    const defaults = {
      size: 'md', // sm | md | lg | xl | fullscreen
      align: 'center-center',
      scrollable: false,
      backdrop: true,
      id: 'globalModal'
    };
    const settings = {...defaults, ...options};

    // Remove existing modal if same id
    const existing = document.getElementById(settings.id);
    if (existing) existing.remove();

    // Determine size class
    let sizeClass = '';
    switch (settings.size) {
      case 'sm': sizeClass = 'modal-sm'; break;
      case 'lg': sizeClass = 'modal-lg'; break;
      case 'xl': sizeClass = 'modal-xl'; break;
      case 'fullscreen': sizeClass = 'modal-fullscreen'; break;
    }

    const scrollableClass = settings.scrollable ? 'modal-dialog-scrollable' : '';

    const alignMap = {
      'top-left': 'modal-dialog modal-dialog-top modal-dialog-left',
      'top-center': 'modal-dialog modal-dialog-top modal-dialog-centered',
      'top-right': 'modal-dialog modal-dialog-top modal-dialog-right',
      'center-left': 'modal-dialog modal-dialog-centered modal-dialog-left',
      'center-center': 'modal-dialog modal-dialog-centered',
      'center-right': 'modal-dialog modal-dialog-centered modal-dialog-right',
      'bottom-left': 'modal-dialog modal-dialog-bottom modal-dialog-left',
      'bottom-center': 'modal-dialog modal-dialog-bottom modal-dialog-centered',
      'bottom-right': 'modal-dialog modal-dialog-bottom modal-dialog-right'
    };
    const alignClass = alignMap[settings.align] || 'modal-dialog modal-dialog-centered';

    // Build modal HTML
    const modalHTML = `
      <div class="modal fade" id="${settings.id}" tabindex="-1" ${settings.backdrop ? '' : 'data-bs-backdrop="false"'} aria-hidden="true">
        <div class="${alignClass} ${sizeClass} ${scrollableClass}">
          <div class="modal-content py-5 rounded-5 shadow-lg">
            <div class="modal-header px-5">
              <h5 class="modal-title fs-6">${title}</h5>
              <button type="button" class="btn-close position-absolute top-0 end-0 mt-4 rounded-5 bg-light p-3 me-4" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5">
              ${body}
            </div>
          </div>
        </div>
      </div>
    `;

    // Append to container
    document.getElementById('globalModalContainer').innerHTML = modalHTML;

    // Show modal
    const modalEl = document.getElementById(settings.id);
    const modal = new bootstrap.Modal(modalEl, { backdrop: settings.backdrop });
    modal.show();
  };

  // Auto-bind to elements with data-modal
  $(document).on('click', '[data-modal]', function(e) {
    e.preventDefault();
    const $el = $(this);

    const title = $el.attr('data-title') || '';
    const content = $el.attr('data-content') || '';

    // Parse options JSON-like string safely
    let options = {};
    const optStr = $el.attr('data-modal');
    if (optStr) {
      try {
        // Convert single quotes to double quotes if user used them
        const fixed = optStr.replace(/'/g, '"');
        options = JSON.parse(fixed);
      } catch (err) {
        console.warn('Invalid data-modal options:', optStr);
      }
    }

    global_modal(title, content, options);
  });
})();
function modal(title = null, content = null, options = null) {
  global_modal(title,content, options);
}
</script>

<style>
/* Alignment helpers */
.modal-dialog-top    { margin-top: 1rem; }
.modal-dialog-bottom { margin-top: auto; margin-bottom: 1rem; }
.modal-dialog-left   { margin-right: auto; }
.modal-dialog-right  { margin-left: auto; }
</style>
