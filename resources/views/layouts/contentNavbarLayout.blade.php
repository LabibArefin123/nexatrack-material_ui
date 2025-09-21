@extends('layouts/commonMaster')

@php
    /* Display elements */
    $contentNavbar = true;
    $containerNav = $containerNav ?? 'container-xxl';
    $isNavbar = $isNavbar ?? true;
    $isMenu = $isMenu ?? true;
    $isFlex = $isFlex ?? false;
    $isFooter = $isFooter ?? true;

    /* HTML Classes */
    $navbarDetached = 'navbar-detached';

    /* Content classes */
    $container = $container ?? 'container-xxl';
@endphp

@section('layoutContent')
    <!-- Toast Image Editor -->
    <link rel="stylesheet" href="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <div class="layout-wrapper layout-content-navbar {{ $isMenu ? '' : 'layout-without-menu' }}">
        <div class="layout-container">
            <!-- start of modal animation -->
            <div class="modal fade" id="backConfirmModal" tabindex="-1" role="dialog" aria-labelledby="backConfirmLabel"
                aria-hidden="true">
                <style>
                    .animate-bounce {
                        animation: bounce 1s infinite;
                    }

                    @keyframes bounce {

                        0%,
                        100% {
                            transform: translateY(0);
                        }

                        50% {
                            transform: translateY(-10px);
                        }
                    }
                </style>
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content text-center p-4">
                        <!-- Animated Circle Icon -->
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="animate-bounce" width="50" height="50"
                                fill="#FFC107" viewBox="0 0 16 16">
                                <path
                                    d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0-12a.905.905 0 0 1 .9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 3.995A.905.905 0 0 1 8 3zm.002 6a1 1 0 1 1-2.002 0 1 1 0 0 1 2.002 0z" />
                            </svg>
                        </div>

                        <!-- Modal Message -->
                        <div class="modal-body mb-3">
                            Please fill up the required fields before leaving the page. Do you want to leave?
                        </div>

                        <!-- Footer Buttons -->
                        <div class="modal-footer d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Stay</button>
                            <a href="#" class="btn btn-danger leave-page">Leave</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of modal animation -->

            @if ($isMenu)
                @include('layouts/sections/menu/verticalMenu')
            @endif

            <!-- Layout page -->
            <div class="layout-page">
                <!-- BEGIN: Navbar-->
                @if ($isNavbar)
                    @include('layouts/sections/navbar/navbar')
                @endif
                <!-- END: Navbar-->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    @if ($isFlex)
                        <div class="{{ $container }} d-flex align-items-stretch flex-grow-1 p-0">
                        @else
                            <div class="{{ $container }} flex-grow-1 container-p-y">
                    @endif

                    @yield('content')

                </div>
                <!-- / Content -->

                <!-- Footer -->
                @if ($isFooter)
                    @include('layouts/sections/footer/footer')
                @endif
                <!-- / Footer -->
                <div class="content-backdrop fade"></div>
            </div>
            <!--/ Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    @if ($isMenu)
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    @endif
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- SweetAlert v11 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        // Example usage
        function showSuccess(message = 'Operation successful!') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message,
                timer: 2500,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }

        function showError(message = 'Something went wrong!') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                timer: 2500,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }

        function showWarning(message = 'Be careful!') {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: message,
                timer: 2500,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }

        function showInfo(message = 'Here is some info') {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: message,
                timer: 2500,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }

        // Example: Trigger on session flash messages
        @if (session('success'))
            showSuccess("{{ session('success') }}");
        @endif

        @if (session('error'))
            showError("{{ session('error') }}");
        @endif
    </script>
    <!-- Start of  Customer Yajra & Other Functions-->

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ================= START:  =================
            const baseUrl = @json(route('customers.index'));
            const filterBtn = document.getElementById('toggleFilter');
            const filterBox = document.getElementById('inlineFilterBox');
            const input = document.getElementById('search-input');
            const suggestions = document.getElementById('search-suggestions');
            const filterFieldSelect = document.getElementById('filter_field');
            const filterValueSelect = document.getElementById('filter_value');
            const form = document.getElementById('filterForm');
            let debounceTimer;

            const urlParams = new URLSearchParams(window.location.search);
            const preField = urlParams.get('filter_field');
            const preValue = urlParams.get('filter_value');
            if (preField && filterFieldSelect) filterFieldSelect.value = preField;

            // Modal for full text
            $('body').append(`
        <div class="modal fade" id="textModal" tabindex="-1" aria-labelledby="textModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="textModalLabel">Full Text</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="textModalBody"></div>
                </div>
            </div>
        </div>`);

            // Yajra DataTable
            const table = $('#customers-table').DataTable({
                searching: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: baseUrl,
                    data: d => {
                        d.q = input.value || '';
                        d.filter_field = filterFieldSelect.value || '';
                        d.filter_value = filterValueSelect.value || '';
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                },
                order: [
                    [13, 'desc']
                ],
                columns: [{
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: d => `<input type="checkbox" class="row-checkbox" value="${d}">`
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                    },
                    {
                        data: 'software'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'company_name'
                    },
                    {
                        data: 'address',
                        render: renderShortText(3)
                    },
                    {
                        data: 'area'
                    },
                    {
                        data: 'city'
                    },
                    {
                        data: 'country'
                    },
                    {
                        data: 'post_code'
                    },
                    {
                        data: 'note',
                        render: renderShortText(2)
                    },
                    {
                        data: 'source'
                    },
                    {
                        data: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                createdRow: (row, data) => {
                    $(row).find('td').each(function(index) {
                        if (![0, 7, 14].includes(index)) {
                            $(this).css('cursor', 'pointer').on('click', e => {
                                e.preventDefault();
                                const redirect = () => window.location.href =
                                    `/customers/${data.id}`;
                                if ($(row).hasClass('table-danger')) {
                                    $.ajax({
                                        url: `/customers/${data.id}/mark-read`,
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]')
                                                .attr('content')
                                        },
                                        success: () => {
                                            $(row).removeClass(
                                                'table-danger');
                                            redirect();
                                        },
                                        error: () => redirect()
                                    });
                                } else {
                                    redirect();
                                }
                            });
                        }
                    });
                }
            });

            function renderShortText(wordLimit) {
                return function(data) {
                    if (!data) return '';
                    const words = data.split(/\s+/);
                    if (words.length > wordLimit) {
                        const shortText = words.slice(0, wordLimit).join(' ') + '...';
                        return `${shortText} <a href="#" class="show-more-text" data-full="${encodeURIComponent(data)}">Show More</a>`;
                    }
                    return data;
                }
            }

            // Select all / uncheck logic
            $('#select-all').on('click', function() {
                $('.row-checkbox').prop('checked', $(this).prop('checked'));
            });
            $('#customers-table').on('change', '.row-checkbox', function() {
                if (!$(this).prop('checked')) $('#select-all').prop('checked', false);
            });

            // Delete selected rows with SweetAlert
            $('#delete-selected').on('click', function() {
                const ids = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
                if (ids.length === 0) return Swal.fire({
                    icon: 'warning',
                    title: 'No selection',
                    text: 'Please select at least one row!'
                });

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Selected customers will be deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('customers.deleteSelected') }}',
                            method: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                ids: ids
                            },
                            success: function(res) {
                                Swal.fire('Deleted!', res.message ||
                                    'Customers deleted successfully.', 'success');
                                table.ajax.reload();
                                $('#select-all').prop('checked', false);
                            },
                            error: function() {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        });
                    }
                });
            });

            // Show More modal
            $(document).on('click', '.show-more-text', e => {
                e.preventDefault();
                const fullText = decodeURIComponent($(e.currentTarget).data('full'));
                $('#textModalBody').text(fullText);
                $('#textModal').modal('show');
            });

            // Toggle filter box
            filterBtn?.addEventListener('click', () => filterBox.classList.toggle('d-none'));

            // Load filter values dynamically
            const loadFilterValues = (selectedField, callback = null) => {
                filterValueSelect.innerHTML = `<option value="">-- Loading --</option>`;
                if (!selectedField) {
                    filterValueSelect.innerHTML = `<option value="">-- Select --</option>`;
                    if (callback) callback();
                    return;
                }
                fetch(`${baseUrl}?ajax=1&filter_field=${encodeURIComponent(selectedField)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    })
                    .then(res => res.ok ? res.json() : Promise.reject())
                    .then(values => {
                        let options = `<option value="">-- Select --</option>`;
                        values.forEach(val => {
                            options +=
                                `<option value="${val}" ${val===preValue?'selected':''}>${val}</option>`;
                        });
                        filterValueSelect.innerHTML = options;
                        if (callback) callback();
                    })
                    .catch(() => {
                        filterValueSelect.innerHTML = `<option value="">Error loading</option>`;
                        if (callback) callback();
                    });
            };

            filterFieldSelect?.addEventListener('change', () => {
                loadFilterValues(filterFieldSelect.value, () => table.ajax.reload());
            });
            filterValueSelect?.addEventListener('change', () => {
                const url = new URL(window.location);
                url.searchParams.set('filter_field', filterFieldSelect.value);
                url.searchParams.set('filter_value', filterValueSelect.value);
                window.history.pushState({}, '', url);
                table.ajax.reload();
            });

            form?.addEventListener('submit', e => {
                e.preventDefault();
                const url = new URL(window.location);
                url.searchParams.set('filter_field', filterFieldSelect.value);
                url.searchParams.set('filter_value', filterValueSelect.value);
                window.history.pushState({}, '', url);
                table.ajax.reload();
            });

            // Live search suggestions
            const setAriaExpanded = state => input?.setAttribute('aria-expanded', state ? 'true' : 'false');
            input?.addEventListener('input', () => {
                clearTimeout(debounceTimer);
                const query = input.value.trim();
                if (!query) {
                    suggestions.innerHTML = '';
                    suggestions.style.display = 'none';
                    setAriaExpanded(false);
                    table.ajax.reload();
                    return;
                }
                debounceTimer = setTimeout(() => {
                    fetch(`${baseUrl}?ajax=1&q=${encodeURIComponent(query)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        })
                        .then(res => res.ok ? res.json() : Promise.reject())
                        .then(data => {
                            let html = '';
                            if (!data || Object.keys(data).length === 0) {
                                html =
                                    `<li class="list-group-item text-muted">No results found</li>`;
                                suggestions.innerHTML = html;
                                suggestions.style.display = 'block';
                                setAriaExpanded(true);
                                return;
                            }
                            for (const [label, values] of Object.entries(data)) {
                                html +=
                                    `<li class="list-group-item bg-light fw-bold text-primary">${label}</li>`;
                                values.forEach(val => {
                                    html +=
                                        `<li class="list-group-item list-group-item-action suggestion-item" data-value="${val}" role="option" tabindex="0">${val}</li>`;
                                });
                            }
                            suggestions.innerHTML = html;
                            suggestions.style.display = 'block';
                            setAriaExpanded(true);
                        })
                        .catch(() => {
                            suggestions.innerHTML =
                                `<li class="list-group-item text-danger">Error loading suggestions</li>`;
                            suggestions.style.display = 'block';
                            setAriaExpanded(true);
                        });
                }, 300);
            });

            suggestions?.addEventListener('click', e => {
                const item = e.target.closest('.suggestion-item');
                if (item) {
                    input.value = item.dataset.value;
                    suggestions.style.display = 'none';
                    setAriaExpanded(false);
                    table.ajax.reload();
                }
            });

            document.addEventListener('click', e => {
                if (!input?.contains(e.target) && !suggestions?.contains(e.target)) {
                    suggestions.style.display = 'none';
                    setAriaExpanded(false);
                }
            });

            if (preField) loadFilterValues(preField, () => table.ajax.reload());
            // ================= END: Customer Yajra & Other Functions =================

        });
    </script>

    <!-- end of  Customer Yajra & Other Functions-->

    {{-- start of validation --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let isDirty = false;
            let lastBackHref = null;

            // Track changes on all forms
            document.querySelectorAll("form").forEach(form => {
                form.querySelectorAll("input, textarea, select").forEach(input => {
                    input.addEventListener("change", () => {
                        isDirty = true;
                    });
                });

                // Reset dirty flag on submit
                form.addEventListener("submit", () => {
                    isDirty = false;
                });
            });

            // Handle all back buttons
            document.querySelectorAll(".back-btn").forEach(btn => {
                btn.addEventListener("click", function(e) {
                    const href = btn.getAttribute("href");
                    if (isDirty) {
                        e.preventDefault();
                        lastBackHref = href; // save the target URL
                        $('#backConfirmModal').modal('show');
                    } else {
                        window.location.href = href;
                    }
                });
            });

            // Leave page from modal
            const leaveBtn = document.querySelector("#backConfirmModal .leave-page");
            leaveBtn.addEventListener("click", function() {
                if (lastBackHref) {
                    isDirty = false;
                    window.location.href = lastBackHref; // go to correct index page dynamically
                }
            });

            // Warn user if leaving by browser navigation
            window.addEventListener("beforeunload", function(e) {
                if (isDirty) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
        });
    </script>
    {{-- end of validation --}}

    {{-- start of password eye --}}
    <script>
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', function() {
                const target = document.querySelector(this.dataset.target);
                const icon = this.querySelector('i');
                if (target.type === 'password') {
                    target.type = 'text';
                    icon.classList.replace('bi-eye', 'bi-eye-slash');
                } else {
                    target.type = 'password';
                    icon.classList.replace('bi-eye-slash', 'bi-eye');
                }
            });
        });
    </script>
    {{-- end of password eye --}}

    <!-- start of image editor -->
    <script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui-color-picker/latest/tui-color-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.min.js"></script>
    <!--end of image editor -->

    <!-- start of image function for toast editor code -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('iconInput');
            const preview = document.getElementById('imagePreview');
            const iconDataInput = document.getElementById('iconData');

            // Create modal container for the editor (you can style this with CSS)
            let editorModal = document.createElement('div');
            editorModal.id = 'editorModal';
            editorModal.style.position = 'fixed';
            editorModal.style.top = '0';
            editorModal.style.left = '0';
            editorModal.style.width = '100vw';
            editorModal.style.height = '100vh';
            editorModal.style.backgroundColor = 'rgba(0,0,0,0.7)';
            editorModal.style.display = 'none';
            editorModal.style.justifyContent = 'center';
            editorModal.style.alignItems = 'center';
            editorModal.style.zIndex = '9999';

            // Inner container for editor and buttons
            editorModal.innerHTML = `
                    <div style="width: 80vw; height: 80vh; background: white; position: relative; display: flex; flex-direction: column;">
                    <div id="tuiImageEditorContainer" style="flex-grow: 1;"></div>
                    <div style="padding: 10px; text-align: right;">
                        <button id="cancelEditBtn" class="btn btn-secondary">Cancel</button>
                        <button id="applyEditBtn" class="btn btn-primary">Apply</button>
                    </div>
                    </div>
                    `;

            document.body.appendChild(editorModal);

            let imageEditor = null;

            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;

                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    // Show modal
                    editorModal.style.display = 'flex';

                    // Initialize editor or reset if already exists
                    if (imageEditor) {
                        imageEditor.destroy();
                        imageEditor = null;
                    }

                    imageEditor = new tui.ImageEditor(document.getElementById(
                        'tuiImageEditorContainer'), {
                        includeUI: {
                            loadImage: {
                                path: e.target.result,
                                name: file.name,
                            },
                            theme: {}, // default theme
                            menu: [
                                'crop', 'resize', 'flip', 'rotate',
                                'draw', 'shape', 'icon', 'text', 'mask', 'filter'
                            ],
                            initMenu: 'crop',
                            menuBarPosition: 'bottom',
                        },
                        cssMaxWidth: 700,
                        cssMaxHeight: 500,
                        selectionStyle: {
                            cornerSize: 20,
                            rotatingPointOffset: 70,
                        },
                    });

                    // Remove the default "Download" button from UI
                    setTimeout(() => {
                        const downloadBtn = document.querySelector(
                            '.tui-image-editor-download-btn');
                        if (downloadBtn) {
                            downloadBtn.style.display = 'none';
                        }
                    }, 500);

                };
                reader.readAsDataURL(file);
            });

            // Cancel button closes modal, clears input, no change
            document.getElementById('cancelEditBtn').addEventListener('click', () => {
                editorModal.style.display = 'none';
                if (imageEditor) {
                    imageEditor.destroy();
                    imageEditor = null;
                }
                input.value = '';
            });

            // Apply button gets edited image and updates preview + hidden input
            document.getElementById('applyEditBtn').addEventListener('click', () => {
                if (!imageEditor) return;

                // Get dataURL (base64) of edited image
                const dataURL = imageEditor.toDataURL();

                // Set hidden input value and preview src
                iconDataInput.value = dataURL;
                preview.src = dataURL;

                // Close modal and destroy editor instance
                editorModal.style.display = 'none';
                imageEditor.destroy();
                imageEditor = null;
            });
        });
    </script>
    <!-- end of image function for toast editor code -->

    <!-- start of image preview section -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('iconInput');
            const preview = document.getElementById('imagePreview');
            const iconDataInput = document.getElementById('iconData');
            const MAX_WIDTH = 800;
            const MAX_HEIGHT = 800;

            // Resize image and remove background (white) before preview and submit
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;

                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        // Create canvas to resize and remove background
                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;

                        // Calculate new dimensions preserving aspect ratio
                        if (width > height) {
                            if (width > MAX_WIDTH) {
                                height *= MAX_WIDTH / width;
                                width = MAX_WIDTH;
                            }
                        } else {
                            if (height > MAX_HEIGHT) {
                                width *= MAX_HEIGHT / height;
                                height = MAX_HEIGHT;
                            }
                        }

                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');

                        // Draw white background (or transparent)
                        ctx.clearRect(0, 0, width, height);
                        // Optional: Remove white background by setting pixels with white color to transparent
                        ctx.drawImage(img, 0, 0, width, height);

                        // You can add image background removal here if you want (complex)
                        // For now we just resize

                        // Update preview image src
                        preview.src = canvas.toDataURL(file.type);

                        // Convert to Blob and then to Base64 to put in hidden input
                        canvas.toBlob(function(blob) {
                            const reader2 = new FileReader();
                            reader2.onloadend = function() {
                                iconDataInput.value = reader2
                                    .result; // base64 string to send in form
                            };
                            reader2.readAsDataURL(blob);
                        }, file.type, 0.9);
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });

            // Smart description formatting (paste and blur)
            const textarea = document.getElementById('description');

            function smartFormat(text) {
                text = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n');
                let lines = text.split('\n');
                lines = lines.map(line => line.trim());

                let cleanedLines = [];
                let emptyCount = 0;
                for (let line of lines) {
                    if (line === '') {
                        emptyCount++;
                        if (emptyCount <= 1) cleanedLines.push(line);
                    } else {
                        emptyCount = 0;
                        cleanedLines.push(line);
                    }
                }

                cleanedLines = cleanedLines.map(line => {
                    if (/^[-*•]\s+/.test(line)) {
                        line = line.replace(/^([-*•])\s+/, '• ');
                        line = line[0] + line.slice(1).replace(/^\w/, c => c.toUpperCase());
                    } else if (/^\d+\.\s+/.test(line)) {
                        line = line.replace(/^(\d+\.\s+)(\w)/, (m, p1, p2) => p1 + p2.toUpperCase());
                    } else {
                        line = line.replace(/^\w/, c => c.toUpperCase());
                    }
                    line = line
                        .replace(/(^|[\s(\[{<])'/g, "$1‘")
                        .replace(/'/g, "’")
                        .replace(/(^|[\s(\[{<])"/g, "$1“")
                        .replace(/"/g, "”");
                    return line;
                });

                return cleanedLines.join('\n');
            }

            textarea.addEventListener('paste', function(e) {
                e.preventDefault();
                let pasteText = (e.clipboardData || window.clipboardData).getData('text');
                let formattedText = smartFormat(pasteText);
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const textBefore = textarea.value.substring(0, start);
                const textAfter = textarea.value.substring(end);
                textarea.value = textBefore + formattedText + textAfter;
                const cursorPos = start + formattedText.length;
                textarea.selectionStart = textarea.selectionEnd = cursorPos;
            });

            textarea.addEventListener('blur', function() {
                textarea.value = smartFormat(textarea.value);
            });
        });
    </script>
    <!-- end of of image preview section -->

    <!-- start of language conversion (optional) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const langSelect = document.querySelector('#language');
            if (langSelect) {
                langSelect.addEventListener('change', function() {
                    const selectedLang = this.value;

                    fetch("{{ route('settings.language.update') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                language: selectedLang
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // Reload page to apply new language
                                window.location.reload();
                            }
                        })
                        .catch(err => console.error(err));
                });
            }
        });
    </script>
    <!-- end of language conversion (optional) -->

    <!-- start of url hide via roles -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (auth()->check())
                const userRole = "{{ auth()->user()->getRoleNames()->first() ?? '' }}";
                const currentPath = window.location.pathname;

                if (userRole !== 'superadmin') {
                    if (currentPath !== '/' && currentPath !== '') {
                        // Content thakbe, kintu URL bar replace hobe `/`
                        window.history.replaceState({
                                originalPath: currentPath
                            }, // store original path in state
                            '',
                            '/'
                        );
                    }
                }
            @endif
        });
    </script>
    <!-- end of url hide via roles -->
@endsection
