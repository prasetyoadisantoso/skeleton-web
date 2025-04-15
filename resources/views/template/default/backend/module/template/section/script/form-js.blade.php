<script>
    $(document).ready(function() {
        // --- Selectors ---
        const availableComponentsContainer = $('#available-components');
        const selectedComponentsList = $('#selected-components-list');
        const componentsOrderInput = $('#components_order_input');
        const componentSearch = $('#component-search');

        // --- Initial Order ---
        let initialOrder = [];
        try {
            initialOrder = JSON.parse(componentsOrderInput.val() || '[]');
        } catch (e) {
            console.error("Error parsing initial component order JSON:", e);
            initialOrder = [];
        }

        // --- SortableJS Initialization ---
        const sortable = new Sortable(selectedComponentsList[0], { // Target the DOM element
            animation: 150,
            handle: '.handle', // Class for drag handle
            ghostClass: 'sortable-ghost', // Class for placeholder
            chosenClass: 'sortable-chosen', // Class for dragged item
            dragClass: 'sortable-drag', // Class for dragged item
            onUpdate: function(evt) {
                updateOrderInput(); // Update hidden input on reorder
            }
        });

        // --- Function to Update Hidden Input ---
        function updateOrderInput() {
            const orderedItems = [];
            selectedComponentsList.find('.selected-component-item').each(function(index) {
                orderedItems.push({
                    id: $(this).data('id'),
                    order: index
                });
            });
            componentsOrderInput.val(JSON.stringify(orderedItems));
            // console.log("Updated Order:", componentsOrderInput.val()); // For debugging
        }

        // --- Function to Add Item to Selected List ---
        function addItem(componentId, componentName) {
            // Check if item already exists in selected list
            if (selectedComponentsList.find('.selected-component-item[data-id="' + componentId + '"]').length > 0) {
                return; // Don't add duplicates
            }

            // Create the selected item HTML
            const newItemHtml = `
                <div class="list-group-item selected-component-item" data-id="${componentId}">
                    ${componentName}
                    <button type="button" class="btn btn-sm btn-danger float-end remove-component-btn">-</button>
                    <span class="handle" style="cursor: move; margin-left: 10px;">&#x2630;</span>
                </div>
            `;

            // Append to selected list
            selectedComponentsList.append(newItemHtml);

            // Hide the item in the available list
            availableComponentsContainer.find('.component-item[data-id="' + componentId + '"]').hide();

            // Update the hidden input
            updateOrderInput();
        }

        // --- Function to Remove Item from Selected List ---
        function removeItem(componentId) {
            // Remove item from selected list
            selectedComponentsList.find('.selected-component-item[data-id="' + componentId + '"]').remove();

            // Show the item in the available list
            availableComponentsContainer.find('.component-item[data-id="' + componentId + '"]').show();

            // Update the hidden input
            updateOrderInput();
        }

        // --- Event Listener for Adding Components ---
        availableComponentsContainer.on('click', '.add-component-btn', function() {
            const item = $(this).closest('.component-item');
            const componentId = item.data('id');
            const componentName = item.clone().children().remove().end().text().trim(); // Get text only
            addItem(componentId, componentName);
        });

        // --- Event Listener for Removing Components ---
        selectedComponentsList.on('click', '.remove-component-btn', function() {
            const item = $(this).closest('.selected-component-item');
            const componentId = item.data('id');
            removeItem(componentId);
        });

        // --- Event Listener for Searching Available Components ---
        componentSearch.on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            availableComponentsContainer.find('.component-item').each(function() {
                const componentName = $(this).clone().children().remove().end().text().trim().toLowerCase();
                if (componentName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // --- Load Initial Selected Components (Based on Blade Render) ---
        // The Blade view already renders the initial selected items.
        // We just need to ensure the corresponding items in the available list are hidden.
        selectedComponentsList.find('.selected-component-item').each(function() {
             const componentId = $(this).data('id');
             availableComponentsContainer.find('.component-item[data-id="' + componentId + '"]').hide();
        });

        // --- Initial update of hidden input (in case Blade render differs slightly) ---
        // updateOrderInput(); // Call once on load to ensure consistency

    });
</script>
