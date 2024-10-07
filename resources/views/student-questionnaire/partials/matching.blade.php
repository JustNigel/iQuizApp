<div class="flex mb-6 p-4 border rounded bg-white shadow">
    <div class="w-1/2 flex justify-center items-center"> {{-- Image container --}}
        <div class="w-3/4 p-6 border border-gray-200 rounded-lg shadow-sm bg-white">
            <img src="//unsplash.it/id/237/300/150" alt="Description" class="w-full h-64 rounded-lg shadow-md border border-gray-300">
        </div>
    </div>

    <div class="w-1/2 matching-item-container grid grid-cols-2 gap-4 p-4 bg-gray-100 rounded">
        <!-- Left side with title (Column A) -->
        <div class="matching-left-side space-y-2"> 
            <h3 class="text-center text-lg font-semibold text-gray-700">Column A</h3>
            <div class="matching-item-left bg-gray-200 p-2 rounded text-center font-bold text-base flex items-center justify-center h-16">
                A
            </div>
            <div class="matching-item-left bg-gray-200 p-2 rounded text-center font-bold text-base flex items-center justify-center h-16">
                B
            </div>
            <div class="matching-item-left bg-gray-200 p-2 rounded text-center font-bold text-base flex items-center justify-center h-16">
                C
            </div>
            <div class="matching-item-left bg-gray-200 p-2 rounded text-center font-bold text-base flex items-center justify-center h-16">
                D
            </div>
        </div>

        <!-- Right side with title (Column B) -->
        <div class="matching-right-side space-y-2">
            <h3 class="text-center text-lg font-semibold text-gray-700">Column B</h3>
            <div class="drag-drop-item matching-item-right bg-white p-2 rounded border shadow text-center text-gray-700 flex items-center cursor-grab h-16" draggable="true">
                <div class="drag-handle bg-blue-500 text-white p-1 rounded-l flex-shrink-0 cursor-grab">
                    <i class="fas fa-grip-vertical text-sm"></i>
                </div>
                <div class="w-full p-1 bg-white text-sm">
                    Description for A
                </div>
            </div>
            <div class="drag-drop-item matching-item-right bg-white p-2 rounded border shadow text-center text-gray-700 flex items-center cursor-grab h-16" draggable="true">
                <div class="drag-handle bg-blue-500 text-white p-1 rounded-l flex-shrink-0 cursor-grab">
                    <i class="fas fa-grip-vertical text-sm"></i>
                </div>
                <div class="w-full p-1 bg-white text-sm">
                    Description for B
                </div>
            </div>
            <div class="drag-drop-item matching-item-right bg-white p-2 rounded border shadow text-center text-gray-700 flex items-center cursor-grab h-16" draggable="true">
                <div class="drag-handle bg-blue-500 text-white p-1 rounded-l flex-shrink-0 cursor-grab">
                    <i class="fas fa-grip-vertical text-sm"></i>
                </div>
                <div class="w-full p-1 bg-white text-sm">
                    Description for C
                </div>
            </div>
            <div class="drag-drop-item matching-item-right bg-white p-2 rounded border shadow text-center text-gray-700 flex items-center cursor-grab h-16" draggable="true">
                <div class="drag-handle bg-blue-500 text-white p-1 rounded-l flex-shrink-0 cursor-grab">
                    <i class="fas fa-grip-vertical text-sm"></i>
                </div>
                <div class="w-full p-1 bg-white text-sm">
                    Description for D
                </div>
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

</div>


    