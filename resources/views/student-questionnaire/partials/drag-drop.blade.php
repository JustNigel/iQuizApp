<div class="mb-6 p-4 border rounded bg-white">
    <!-- Draggable Text Item 1 -->
    <div class="drag-drop-item mb-2 p-2 border rounded flex items-center bg-gray-100 cursor-grab" draggable="true">
        <div class="drag-handle bg-blue-500 text-white p-2 rounded-l flex-shrink-0 cursor-grab">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="w-full p-2 border rounded bg-white">
            Option 1
        </div>
    </div>

    <!-- Draggable Text Item 2 -->
    <div class="drag-drop-item mb-2 p-2 border rounded flex items-center bg-gray-100 cursor-grab" draggable="true">
        <div class="drag-handle bg-blue-500 text-white p-2 rounded-l flex-shrink-0 cursor-grab">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="w-full p-2 border rounded bg-white">
            Option 2
        </div>
    </div>

    <!-- Draggable Text Item 3 -->
    <div class="drag-drop-item mb-2 p-2 border rounded flex items-center bg-gray-100 cursor-grab" draggable="true">
        <div class="drag-handle bg-blue-500 text-white p-2 rounded-l flex-shrink-0 cursor-grab">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="w-full p-2 border rounded bg-white">
            Option 3
        </div>
    </div>

    <!-- Draggable Text Item 4 -->
    <div class="drag-drop-item mb-2 p-2 border rounded flex items-center bg-gray-100 cursor-grab" draggable="true">
        <div class="drag-handle bg-blue-500 text-white p-2 rounded-l flex-shrink-0 cursor-grab">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="w-full p-2 border rounded bg-white">
            Option 4
        </div>
    </div>

    
</div>

<script>
    const dragItems = document.querySelectorAll('.drag-drop-item');
    let draggedItem = null;
    let placeholder = document.createElement('div');
    placeholder.className = 'mb-2 p-2 border rounded flex items-center bg-blue-100 transition-all';
    placeholder.style.height = '50px';  // Ensures the placeholder is clearly visible

    dragItems.forEach(item => {
        // Drag start event
        item.addEventListener('dragstart', (e) => {
            draggedItem = item;
            setTimeout(() => {
                item.style.opacity = "0.5"; // Lower opacity for visual feedback
            }, 0);
        });

        // Drag end event
        item.addEventListener('dragend', () => {
            setTimeout(() => {
                draggedItem.style.opacity = "1"; // Restore opacity
                draggedItem = null;
                placeholder.remove();
            }, 0);
        });

        // Drag over event to handle placeholder
        item.addEventListener('dragover', (e) => {
            e.preventDefault(); // Allow dropping by preventing default behavior

            const rect = item.getBoundingClientRect();
            const offsetY = e.clientY - rect.top; // Mouse Y position relative to item

            if (offsetY < rect.height / 2) {
                // Insert placeholder above the current item
                item.parentNode.insertBefore(placeholder, item);
            } else {
                // Insert placeholder below the current item
                item.parentNode.insertBefore(placeholder, item.nextSibling);
            }
        });

        // Drop event to place the dragged item
        item.addEventListener('drop', (e) => {
            e.preventDefault();
            if (placeholder) {
                placeholder.replaceWith(draggedItem);
            }
        });
    });

    // Handle dragging over and dropping on the placeholder itself
    placeholder.addEventListener('dragover', (e) => {
        e.preventDefault();  // Ensure it's a valid drop target
    });

    placeholder.addEventListener('drop', (e) => {
        e.preventDefault();
        if (draggedItem) {
            placeholder.replaceWith(draggedItem);  // Swap the placeholder with the dragged item
        }
    });

    // Handle drop events outside the items (for top/bottom edge cases)
    document.querySelector('.mb-6').addEventListener('dragover', (e) => {
        e.preventDefault();
    });

    document.querySelector('.mb-6').addEventListener('drop', (e) => {
        e.preventDefault();
        const container = document.querySelector('.mb-6');

        // Append at the end if no specific position found
        if (!placeholder.isConnected) {
            container.appendChild(draggedItem);
        }
    });
</script>

<style>
    /* Smooth animation when dragging */
    .drag-drop-item {
        transition: transform 0.2s ease, opacity 0.2s ease;
    }

    /* Placeholder styling */
    .drag-drop-item + .drag-drop-item {
        margin-top: 10px;
    }

    /* Style for when item is dragging over others */
    .drag-drop-item.dragging {
        opacity: 0.5;
    }
</style>
