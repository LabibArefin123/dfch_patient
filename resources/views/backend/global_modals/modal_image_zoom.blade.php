  <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-labelledby="imageZoomModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content"
              style="
                background:#f8f8f8; 
                backdrop-filter: blur(16px); 
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.15); 
                border-radius: 20px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                overflow: hidden;
            ">

              <!-- Removed modal-header and put the button directly on the image -->
              <div class="modal-body p-3 d-flex flex-column align-items-center justify-content-center">
                  <!-- Relative Wrapper for image and close button overlay -->
                  <div class="position-relative d-inline-block shadow-lg rounded overflow-hidden"
                      style="max-width: 100%;">

                      <!-- Zoomed Image -->
                      <img src="" id="modalZoomImage" class="img-fluid rounded" alt="Zoomed Image"
                          style="
                            max-height: 75vh; 
                            display: block;
                            object-fit: contain; 
                            width: 100%;
                            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                        ">

                      <!-- Premium Bottom-Right Close Button Overlay -->
                      <button type="button"
                          class="btn position-absolute bottom-0 end-0 m-3 px-3 py-2 d-flex align-items-center gap-2 rounded-pill zoom-modal-close-btn"
                          data-bs-dismiss="modal" aria-label="Close"
                          style="
                                background: rgba(15, 23, 42, 0.75); 
                                backdrop-filter: blur(8px);
                                -webkit-backdrop-filter: blur(8px);
                                border: 1px solid rgba(255, 255, 255, 0.2); 
                                color: #f8fafc;
                                font-size: 0.85rem;
                                font-weight: 500;
                                transition: all 0.2s ease-in-out;
                                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
                                z-index: 10;
                            ">
                          <!-- Custom SVG Close Icon -->
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                              viewBox="0 0 16 16" style="vertical-align: middle;">
                              <path
                                  d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                          </svg>
                          <span>Close</span>
                      </button>
                  </div>
              </div>
          </div>
      </div>
  </div>
