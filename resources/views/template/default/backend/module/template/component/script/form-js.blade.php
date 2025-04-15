{{-- resources/views/template/default/backend/module/template/component/script/form-js.blade.php --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Element Selectors ---
        const availableImagesContainer = document.getElementById('available-images');
        const selectedImagesList = document.getElementById('selected-images-list');
        const imageOrderInput = document.getElementById('content_images_order_input');
        const imageSearch = document.getElementById('image-search');

        const availableTextsContainer = document.getElementById('available-texts'); // <-- Text selector
        const selectedTextsList = document.getElementById('selected-texts-list'); // <-- Text selector
        const textOrderInput = document.getElementById('content_texts_order_input'); // <-- Text selector
        const textSearch = document.getElementById('text-search'); // <-- Text selector

        // --- Helper Function: Update Order Input ---
        function updateOrderInput(listElement, inputElement, itemSelector) {
            if (!listElement || !inputElement) return; // Guard clause
            const items = listElement.querySelectorAll(itemSelector);
            const orderData = [];
            items.forEach((item, index) => {
                if (item.dataset.id) {
                    orderData.push({
                        id: item.dataset.id,
                        order: index
                    });
                }
            });
            inputElement.value = JSON.stringify(orderData);
        }

        // --- Helper Function: Initialize Sortable ---
        function initializeSortable(listElement, inputElement, itemSelector, handleSelector = '.handle') {
             if (!listElement || !inputElement) return null; // Guard clause
            return new Sortable(listElement, {
                group: listElement.id, // Group name prevents dropping between different lists
                animation: 150,
                handle: handleSelector,
                ghostClass: 'blue-background-class', // Optional: class for styling the dragged item's ghost
                onUpdate: function (evt) {
                    updateOrderInput(listElement, inputElement, itemSelector);
                }
            });
        }

        // --- Helper Function: Add Item ---
        function addItem(e, targetButtonClass, availableContainer, selectedList, inputElement, selectedItemClass, itemSelector, createItemHtmlCallback) {
            if (!e.target.classList.contains(targetButtonClass)) return;

            const itemDiv = e.target.closest(itemSelector);
            if (!itemDiv) return;

            const itemId = itemDiv.dataset.id;

            // Check for duplicates in the selected list
            if (!selectedList.querySelector(`.${selectedItemClass}[data-id="${itemId}"]`)) {
                const newItem = document.createElement('div');
                // Set class for selected item (e.g., 'list-group-item selected-image-item')
                newItem.className = `list-group-item ${selectedItemClass}`; // Use list-group-item for selected
                newItem.dataset.id = itemId;
                newItem.innerHTML = createItemHtmlCallback(itemDiv); // Generate inner HTML using callback
                selectedList.appendChild(newItem);
                updateOrderInput(selectedList, inputElement, `.${selectedItemClass}`);
            }
            itemDiv.style.display = 'none'; // Hide from available list
        }

        // --- Helper Function: Remove Item ---
        function removeItem(e, targetButtonClass, selectedList, inputElement, selectedItemClass, availableContainer, availableItemSelector) {
             if (!e.target.classList.contains(targetButtonClass)) return;

            const itemToRemove = e.target.closest(`.${selectedItemClass}`);
            if (!itemToRemove) return;

            const itemId = itemToRemove.dataset.id;
            itemToRemove.remove();
            updateOrderInput(selectedList, inputElement, `.${selectedItemClass}`);

            // Show item again in the available list
            const availableItem = availableContainer.querySelector(`${availableItemSelector}[data-id="${itemId}"]`);
            if (availableItem) {
                availableItem.style.display = 'block'; // Use 'block' as available items are simple divs now
            }
        }

         // --- Helper Function: Search/Filter ---
         function filterItems(searchInput, availableContainer, itemSelector) {
             if (!searchInput || !availableContainer) return;
             const filter = searchInput.value.toLowerCase();
             const availableItems = availableContainer.querySelectorAll(itemSelector);
             availableItems.forEach(item => {
                 const name = item.textContent.toLowerCase();
                 // Only filter items not already hidden (i.e., not selected)
                 if (item.style.display !== 'none') {
                     if (name.includes(filter)) {
                         item.style.display = 'block'; // Use 'block'
                     } else {
                         item.style.display = 'none';
                     }
                 }
             });
         }

         // --- Helper Function: Hide Selected on Load ---
         function hideSelectedOnLoad(selectedList, selectedItemSelector, availableContainer, availableItemSelector) {
             if (!selectedList || !availableContainer) return;
             const initialSelectedItems = selectedList.querySelectorAll(selectedItemSelector);
             initialSelectedItems.forEach(selectedItem => {
                 const itemId = selectedItem.dataset.id;
                 const availableItem = availableContainer.querySelector(`${availableItemSelector}[data-id="${itemId}"]`);
                 if (availableItem) {
                     availableItem.style.display = 'none';
                 }
             });
         }


        // --- Initialize for Images ---
        if (selectedImagesList && availableImagesContainer && imageOrderInput && imageSearch) {
            const imageSortable = initializeSortable(selectedImagesList, imageOrderInput, '.selected-image-item');

            // Event Listeners for Images
            availableImagesContainer.addEventListener('click', (e) => addItem(e, 'add-image-btn', availableImagesContainer, selectedImagesList, imageOrderInput, 'selected-image-item', '.image-item', (itemDiv) => {
                // Callback to create HTML for selected image item
                const imageName = itemDiv.textContent.replace('+', '').trim();
                // Match the structure in the blade file
                return `${imageName} <button type="button" class="btn btn-sm btn-danger float-end remove-image-btn">-</button> <span class="handle" style="cursor: move; margin-left: 10px;">&#x2630;</span>`;
            }));
            selectedImagesList.addEventListener('click', (e) => removeItem(e, 'remove-image-btn', selectedImagesList, imageOrderInput, 'selected-image-item', availableImagesContainer, '.image-item'));
            imageSearch.addEventListener('keyup', () => filterItems(imageSearch, availableImagesContainer, '.image-item'));
            hideSelectedOnLoad(selectedImagesList, '.selected-image-item', availableImagesContainer, '.image-item');
        } else {
            console.warn("Image elements not found for initialization.");
        }

        // --- Initialize for Texts ---
        if (selectedTextsList && availableTextsContainer && textOrderInput && textSearch) {
            const textSortable = initializeSortable(selectedTextsList, textOrderInput, '.selected-text-item'); // Use text selectors

            // Event Listeners for Texts
            availableTextsContainer.addEventListener('click', (e) => addItem(e, 'add-text-btn', availableTextsContainer, selectedTextsList, textOrderInput, 'selected-text-item', '.text-item', (itemDiv) => {
                // Callback to create HTML for selected text item
                // Extract preview HTML, excluding the add button
                const textPreviewHtml = itemDiv.innerHTML.replace(/<button.*?add-text-btn.*?<\/button>/i, '').trim();
                // Match the structure in the blade file (same as image)
                return `${textPreviewHtml} <button type="button" class="btn btn-sm btn-danger float-end remove-text-btn">-</button> <span class="handle" style="cursor: move; margin-left: 10px;">&#x2630;</span>`;
            }));
            selectedTextsList.addEventListener('click', (e) => removeItem(e, 'remove-text-btn', selectedTextsList, textOrderInput, 'selected-text-item', availableTextsContainer, '.text-item')); // Use text selectors
            textSearch.addEventListener('keyup', () => filterItems(textSearch, availableTextsContainer, '.text-item')); // Use text selectors
            hideSelectedOnLoad(selectedTextsList, '.selected-text-item', availableTextsContainer, '.text-item'); // Use text selectors
        } else {
             console.warn("Text elements not found for initialization.");
        }


        // Call updateOrderInput on load if it's an edit page
        if (document.querySelector('input[name="_method"][value="PUT"]')) {
            if (selectedImagesList && imageOrderInput) updateOrderInput(selectedImagesList, imageOrderInput, '.selected-image-item');
            if (selectedTextsList && textOrderInput) updateOrderInput(selectedTextsList, textOrderInput, '.selected-text-item');
        }
    });
</script>
