@extends('template.default.backend.page.index')

@section('layout-form')

<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-layer-group me-3"></i>{{ $breadcrumb['title'] ?? 'Layouts' }}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.main') }}" class="text-decoration-none text-dark">
                {{ $breadcrumb['home'] ?? 'Home' }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('layout.index') }}" class="text-decoration-none text-dark">
                {{ $breadcrumb['title'] ?? 'Layouts' }}
            </a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            @if ($type == 'create')
            {{ $breadcrumb['create'] ?? 'Create' }}
            @else
            {{ $breadcrumb['edit'] ?? 'Edit' }}
            @endif
        </li>
    </ol>
</nav>

<div class="container py-3">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0 text-center">
                @if ($type == 'create')
                {{ $form['create_title'] ?? 'Create Layout' }}
                @else
                {{ $form['edit_title'] ?? 'Edit Layout' }}
                @endif
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ $type == 'create' ? route('layout.store') : route('layout.update', $layoutData->id) }}"
                method="POST" id="layout-form">
                @csrf
                @if ($type == 'edit')
                @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ $form['name'] ?? 'Name:' }} <span
                                class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $layoutData->name ?? '') }}"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="{{ $form['name_placeholder'] ?? 'Insert layout name...' }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">{{ $form['type'] ?? 'Type:' }} <span
                                class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="full-width" {{ old('type', $layoutData->type ?? '') == 'full-width' ?
                                'selected' : '' }}>Full Width</option>
                            <option value="sidebar" {{ old('type', $layoutData->type ?? '') == 'sidebar' ? 'selected' :
                                '' }}>Sidebar</option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="row">
                    {{-- MAIN SECTIONS --}}
                    <div class="col-md-6">
                        <label class="form-label">{{ $form['section_main'] ?? 'Main Sections:' }}</label>
                        <ul id="main-sections-list" class="list-group sortable-list">
                            {{-- Loop 1: Selected & Sorted Sections --}}
                            @foreach ($mainSectionsCollection as $selectedSection)
                            <li class="list-group-item" data-section-id="{{ $selectedSection->id }}"> {{-- Tambahkan
                                data-section-id --}}
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="checkbox"
                                            value="{{ $selectedSection->id }}"
                                            id="section_main_{{ $selectedSection->id }}" checked {{-- Pasti checked
                                            karena ada di collection ini --}}>
                                        <label class="form-check-label" for="section_main_{{ $selectedSection->id }}">{{
                                            $selectedSection->name }}</label>
                                    </div>
                                    <input type="hidden" class="section-order-input" {{-- Ambil order dari pivot atau
                                        map --}}
                                        value="{{ $selectedSection->pivot->order ?? ($mainSectionOrders[$selectedSection->id] ?? 0) }}">
                                    <i class="fas fa-sort"></i>
                                </div>
                            </li>
                            @endforeach

                            {{-- Loop 2: Unselected Sections --}}
                            @foreach ($sections as $section)
                            @unless ($selectedMainIds->contains($section->id)) {{-- Hanya jika belum dirender di loop 1
                            --}}
                            <li class="list-group-item" data-section-id="{{ $section->id }}"> {{-- Tambahkan
                                data-section-id --}}
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="checkbox" value="{{ $section->id }}"
                                            id="section_main_{{ $section->id }}" {{-- Tidak checked --}}>
                                        <label class="form-check-label" for="section_main_{{ $section->id }}">{{
                                            $section->name }}</label>
                                    </div>
                                    <input type="hidden" class="section-order-input" value="0"> {{-- Order default 0
                                    untuk yang belum dipilih --}}
                                    <i class="fas fa-sort"></i>
                                </div>
                            </li>
                            @endunless
                            @endforeach
                        </ul>
                        @if($sections->isEmpty())
                        <p class="text-muted">{{ __('layouts.messages.no_sections_available') ?? ''}}</p>
                        @endif
                    </div>

                    {{-- SIDEBAR SECTIONS --}}
                    <div class="col-md-6" id="sidebar-sections">
                        <label class="form-label">{{ $form['section_sidebar'] ?? 'Sidebar Sections:' }}</label>
                        <ul id="sidebar-sections-list" class="list-group sortable-list">
                            {{-- Loop 1: Selected & Sorted Sections --}}
                            @foreach ($sidebarSectionsCollection as $selectedSection)
                            <li class="list-group-item" data-section-id="{{ $selectedSection->id }}"> {{-- Tambahkan
                                data-section-id --}}
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="checkbox"
                                            value="{{ $selectedSection->id }}"
                                            id="section_sidebar_{{ $selectedSection->id }}" checked {{-- Pasti checked
                                            --}}>
                                        <label class="form-check-label"
                                            for="section_sidebar_{{ $selectedSection->id }}">{{ $selectedSection->name
                                            }}</label>
                                    </div>
                                    <input type="hidden" class="section-order-input" {{-- Ambil order dari pivot atau
                                        map --}}
                                        value="{{ $selectedSection->pivot->order ?? ($sidebarSectionOrders[$selectedSection->id] ?? 0) }}">
                                    <i class="fas fa-sort"></i>
                                </div>
                            </li>
                            @endforeach

                            {{-- Loop 2: Unselected Sections --}}
                            @foreach ($sections as $section)
                            @unless ($selectedSidebarIds->contains($section->id)) {{-- Hanya jika belum dirender di loop
                            1 --}}
                            <li class="list-group-item" data-section-id="{{ $section->id }}"> {{-- Tambahkan
                                data-section-id --}}
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="checkbox" value="{{ $section->id }}"
                                            id="section_sidebar_{{ $section->id }}" {{-- Tidak checked --}}>
                                        <label class="form-check-label" for="section_sidebar_{{ $section->id }}">{{
                                            $section->name }}</label>
                                    </div>
                                    <input type="hidden" class="section-order-input" value="0"> {{-- Order default 0
                                    --}}
                                    <i class="fas fa-sort"></i>
                                </div>
                            </li>
                            @endunless
                            @endforeach
                        </ul>
                        @if($sections->isEmpty())
                        <p class="text-muted">{{ __('layouts.messages.no_sections_available') ?? '' }}</p>
                        @endif
                    </div>
                </div>



                <div class="col-12 mt-5">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('layout.index') }}" class="btn btn-danger w-100 w-md-25">
                            {{ $button['cancel'] ?? 'Cancel' }} <i class="fas fa-times ms-2"></i>
                        </a>
                        <button type="submit" class="btn btn-success w-100 w-md-25">
                            @if ($type == 'create')
                            {{ $button['create'] ?? 'Create' }} <i class="fas fa-save ms-2"></i>
                            @else
                            {{ $button['update'] ?? 'Update' }} <i class="fas fa-save ms-2"></i>
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .sortable-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .sortable-list li {
        cursor: grab;
        margin-bottom: 0.5rem;
        border: 1px solid #ccc;
        padding: 0.5rem;
    }

    .sortable-list li:hover {
        background-color: #f5f5f5;
    }

    .sortable-list .d-flex {
        align-items: center;
    }
</style>
@endsection

@push('layout-form-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainSectionsList = document.getElementById('main-sections-list');
        const sidebarSectionsList = document.getElementById('sidebar-sections-list');
        const sidebarSectionsContainer = document.getElementById('sidebar-sections');
        const layoutTypeSelect = document.getElementById('type');

         /**
         * Updates the order value and enables/disables inputs based on checkbox state.
         * Also sets the correct name attributes for submission.
         * @param {HTMLElement} list The UL element containing the list items.
         * @param {string} sectionType 'sections_main' or 'sections_sidebar'.
         */
         function updateSectionOrders(list, sectionType) {
            if (!list) return; // Exit if list doesn't exist

            const items = list.querySelectorAll('li.list-group-item'); // Target only list items
            items.forEach((item, index) => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                const orderInput = item.querySelector('input.section-order-input');
                const sectionId = checkbox ? checkbox.value : null;

                if (checkbox && orderInput && sectionId) {
                    if (checkbox.checked) {
                        // --- If CHECKED ---
                        // 1. Ensure checkbox is ENABLED and set its name for submission
                        checkbox.disabled = false; // Pastikan bisa dicentang/tidak dicentang
                        checkbox.name = `${sectionType}[${sectionId}][id]`;

                        // 2. Enable order input, set its name, and update its value (order)
                        orderInput.disabled = false;
                        orderInput.name = `${sectionType}[${sectionId}][order]`;
                        orderInput.value = index; // Update order based on current position

                    } else {
                        // --- If NOT CHECKED ---
                        // 1. Ensure checkbox is ENABLED (so it can be checked again)
                        //    but clear its name so the ID isn't accidentally sent.
                        checkbox.disabled = false; // <-- PERUBAHAN KUNCI: JANGAN disable checkbox
                        checkbox.name = ''; // Hapus nama agar ID tidak terkirim

                        // 2. Disable ONLY the order input (so it's not sent without an ID)
                        orderInput.disabled = true; // <-- Ini yang penting untuk dinonaktifkan
                        orderInput.name = '';
                        // orderInput.value = ''; // Optional: Clear value
                    }
                } else {
                    // Hanya log jika elemen benar-benar tidak ditemukan, bukan karena sectionId null
                    if (!checkbox) console.warn('Could not find checkbox for item:', item);
                    if (!orderInput) console.warn('Could not find order input for item:', item);
                }
            });
        }


        /**
         * Adds 'change' event listeners to checkboxes within a list.
         * @param {HTMLElement} listElement The UL element.
         * @param {string} sectionType 'sections_main' or 'sections_sidebar'.
         */
        function addCheckboxListeners(listElement, sectionType) {
            if (!listElement) return;
            listElement.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    // When a checkbox changes, re-run updateSectionOrders for its list
                    // This ensures the corresponding order input is enabled/disabled correctly.
                    updateSectionOrders(listElement, sectionType);
                });
            });
        }


        /**
         * Toggles the visibility and disabled state of the sidebar section based on layout type.
         */
        function toggleSidebarState() {
            const layoutType = layoutTypeSelect.value;
            const isFullWidth = layoutType === 'full-width';

            if (!sidebarSectionsContainer) return; // Exit if sidebar container doesn't exist

            if (isFullWidth) {
                sidebarSectionsContainer.style.display = 'none';
                // Disable ALL inputs within the sidebar container
                sidebarSectionsContainer.querySelectorAll('input').forEach(input => {
                    input.disabled = true;
                    // Ensure checkboxes are unchecked when disabled this way
                    if (input.type === 'checkbox') {
                        input.checked = false;
                    }
                });
            } else {
                sidebarSectionsContainer.style.display = 'block';
                // Re-enable inputs BUT let updateSectionOrders handle individual state
                sidebarSectionsContainer.querySelectorAll('input').forEach(input => {
                    // Temporarily enable all, then let updateSectionOrders refine based on checks
                     input.disabled = false;
                });
                // IMPORTANT: Re-run updateSectionOrders for sidebar when it becomes visible
                // to correctly enable/disable based on checkbox state *after* global enable.
                updateSectionOrders(sidebarSectionsList, 'sections_sidebar');
            }
        }

        // --- Initialization ---

        // 1. Initialize SortableJS for Main Sections
        if (mainSectionsList) {
            new Sortable(mainSectionsList, {
                animation: 150,
                handle: ".fa-sort", // Make sure your handle icon has this class
                ghostClass: 'sortable-ghost',
                draggable: ".list-group-item",
                onEnd: function(evt) {
                    // Update order after sorting
                    updateSectionOrders(mainSectionsList, 'sections_main');
                }
            });
            // Add listeners for checkbox changes in main list
            addCheckboxListeners(mainSectionsList, 'sections_main');
            // Run initial update for main list on load
            updateSectionOrders(mainSectionsList, 'sections_main');
        }


        // 2. Initialize SortableJS for Sidebar Sections (if it exists)
        if (sidebarSectionsList) {
            new Sortable(sidebarSectionsList, {
                animation: 150,
                handle: ".fa-sort", // Make sure your handle icon has this class
                ghostClass: 'sortable-ghost',
                draggable: ".list-group-item",
                onEnd: function(evt) {
                    // Update order after sorting
                    updateSectionOrders(sidebarSectionsList, 'sections_sidebar');
                }
            });
            // Add listeners for checkbox changes in sidebar list
            addCheckboxListeners(sidebarSectionsList, 'sections_sidebar');
            // Run initial update for sidebar list on load (will be refined by toggleSidebarState if needed)
            updateSectionOrders(sidebarSectionsList, 'sections_sidebar');
        }

        // 3. Add event listener to layout type select
        if (layoutTypeSelect) {
            layoutTypeSelect.addEventListener('change', toggleSidebarState);
        }

        // 4. Initial state check for sidebar visibility/disabled state on page load
        toggleSidebarState();

    });
</script>
@endpush
