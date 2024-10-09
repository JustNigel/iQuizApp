document.addEventListener('DOMContentLoaded', function() {
    const variantSelect = document.getElementById('variant-select');
    const answersContainer = document.getElementById('answers-container');
    const addAnswerBtn = document.getElementById('add-answer-btn');
    const addFileBtn = document.getElementById('add-file-btn');
    const fileInputsContainer = document.getElementById('file-inputs-container');
    const matchingKeyContainer = document.getElementById('matching-key-container');
    const matchingKeyList = document.getElementById('matching-key-list');
    const saveMatchingKeyBtn = document.getElementById('save-matching-key');
    const reloadMatchingKeyBtn = document.getElementById('reload-matching-key');
    const form = document.getElementById('questionForm');
    const submitButton = document.getElementById('submit-button-id');
    

    function updateAnswersContainer() {
        const selectedVariant = variantSelect.value;
        answersContainer.innerHTML = '';

        matchingKeyContainer.classList.add('hidden');

        if (selectedVariant === 'matching') {
            addMatchingItem();
            addAnswerBtn.classList.add('hidden');
        } else {
            addAnswerBtn.classList.remove('hidden');
            if (selectedVariant === 'drag-drop') {
                addDragDropItem();
            } else if (selectedVariant === 'multiple-choice') {
                addMultipleChoiceItem();
            } else if (selectedVariant === 'checkboxes') {
                addCheckboxItem();
            } else if (selectedVariant === 'text') {
                addTextItem();
            } else if (selectedVariant === 'paragraph') {
                addParagraphItem();
            }
        }

        if (selectedVariant === 'drag-drop') {
            Sortable.create(answersContainer, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
            });
        }
    }

    function addFileInput() {
        const fileInputContainer = document.createElement('div');
        fileInputContainer.className = 'file-input-container mb-2 flex items-center';
    
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.name = 'files[]'; // Set the name to 'files[]' to create an array
        fileInput.className = 'file-input p-2 border rounded w-full';
    
        const deleteFileBtn = document.createElement('button');
        deleteFileBtn.className = 'delete-file-btn text-red-500 hover:text-red-700 ml-2';
        deleteFileBtn.innerHTML = '&times;';
        deleteFileBtn.addEventListener('click', function() {
            fileInputContainer.remove();
        });
    
        fileInputContainer.appendChild(fileInput);
        fileInputContainer.appendChild(deleteFileBtn);
        fileInputsContainer.appendChild(fileInputContainer);
    }
    

    function reloadMatchingKeys() {
        createMatchingKey();
    }

    function createDeleteButton(container) {
        const deleteButton = document.createElement('button');
        deleteButton.className = 'delete-button text-red-500 hover:text-red-700';
        deleteButton.innerHTML = '&times;';
        deleteButton.addEventListener('click', function() {
            container.remove();
            if (variantSelect.value === 'matching') {
                createMatchingKey();
            }
        });
        return deleteButton;
    }

    function addMatchingItem() {
        const matchingItemContainer = document.createElement('div');
        matchingItemContainer.className = 'matching-item-container mb-2 p-2 border rounded grid grid-cols-2 gap-4';
    
        const leftSide = document.createElement('div');
        leftSide.className = 'matching-left-side';
    
        const rightSide = document.createElement('div');
        rightSide.className = 'matching-right-side';
    
        const addButtonContainer = document.createElement('div');
        addButtonContainer.className = 'flex justify-between items-center mb-2';
    
        const addLeftButton = document.createElement('button');
        addLeftButton.className = 'bg-blue-500 text-white p-2 rounded mr-2';
        addLeftButton.textContent = '+ Add Left Item';
        addLeftButton.addEventListener('click', function(event) {
            event.preventDefault();  
            addLeftItem(leftSide);
        });
    
        const addRightButton = document.createElement('button');
        addRightButton.className = 'bg-yellow-500 text-white p-2 rounded';
        addRightButton.textContent = '+ Add Right Item';
        addRightButton.addEventListener('click', function(event) {
            event.preventDefault(); 
            addRightItem(rightSide);
        });
    
        addButtonContainer.appendChild(addLeftButton);
        addButtonContainer.appendChild(addRightButton);
        answersContainer.appendChild(addButtonContainer);
    
        matchingItemContainer.appendChild(leftSide);
        matchingItemContainer.appendChild(rightSide);
    
        answersContainer.appendChild(matchingItemContainer);
    
        addLeftItem(leftSide);
        addRightItem(rightSide);
    
        matchingKeyContainer.classList.remove('hidden');
        createMatchingKey();
    }
    

    function addLeftItem(leftSide) {
        const newMatchingItemLeft = document.createElement('div');
        newMatchingItemLeft.className = 'matching-item-left mb-2 p-2 border rounded flex items-center';
        newMatchingItemLeft.innerHTML = `<input type="text" name="descriptions[]" placeholder="Description" class="w-full border-0 rounded">`;  // Placeholder updated to accept description
        newMatchingItemLeft.appendChild(createDeleteButton(newMatchingItemLeft));
    
        leftSide.appendChild(newMatchingItemLeft);
        createMatchingKey();
    }
    
    function addRightItem(rightSide) {
        const newMatchingItemRight = document.createElement('div');
        newMatchingItemRight.className = 'matching-item-right mb-2 p-2 border rounded flex items-center';
        newMatchingItemRight.innerHTML = ` <input type="text" name="options[]" placeholder="Option" class="w-full border-0 rounded">`;  // Placeholder updated to accept option
        newMatchingItemRight.appendChild(createDeleteButton(newMatchingItemRight));
    
        rightSide.appendChild(newMatchingItemRight);
        createMatchingKey();
    }
    
    function createMatchingKey() {
        matchingKeyList.innerHTML = '';
    
        const leftItems = Array.from(document.querySelectorAll('.matching-left-side input'));
        const rightItems = Array.from(document.querySelectorAll('.matching-right-side input'));
    
        leftItems.forEach((leftItem, index) => {
            const keyItem = document.createElement('div');
            keyItem.className = 'matching-key-item mb-2 p-2 border rounded flex items-center justify-between';
    
            const leftInput = document.createElement('input');
            leftInput.type = 'text';
            leftInput.value = leftItem.value;
            leftInput.className = 'w-1/2 border-0 rounded bg-gray-200';
            leftInput.disabled = true;
    
            const rightSelect = document.createElement('select');
            rightSelect.className = 'w-1/2 border rounded';
    
            function updateDropdown() {
                rightSelect.innerHTML = rightItems.map(item => `<option value="${item.value}">${item.value || 'No Option'}</option>`).join('');
            }
    
            updateDropdown();
    
            rightSelect.addEventListener('focus', updateDropdown);
    
            keyItem.appendChild(leftInput);
            keyItem.appendChild(rightSelect);
    
            matchingKeyList.appendChild(keyItem);
        });
    }
    

    function addDragDropItem() {
        const newDragDropItem = document.createElement('div');
        newDragDropItem.className = 'drag-drop-item mb-2 p-2 border rounded flex items-center';
        newDragDropItem.innerHTML = `
            <div class="drag-handle bg-blue-500 text-white p-2 rounded-l flex-shrink-0 cursor-grab ">
                <i class="fas fa-grip-vertical"></i>
            </div>
            <input type="text" name="options[]" placeholder="New Option" class="w-full border rounded">
        `;
        newDragDropItem.appendChild(createDeleteButton(newDragDropItem));
        answersContainer.appendChild(newDragDropItem);
    }

    function addMultipleChoiceItem() {
        const answersContainer = document.getElementById('answers-container');
        const index = answersContainer.children.length;

        const newMultipleChoiceItem = document.createElement('div');
        newMultipleChoiceItem.className = 'multiple-choice-item mb-2 p-2 border rounded flex items-center';
        newMultipleChoiceItem.innerHTML = `
            <input type="radio" name="answer_key" value="${index}" class="mr-2">
            <input type="text" name="options[]" placeholder="New Option" class="w-full border-0 rounded">
        `;
        newMultipleChoiceItem.appendChild(createDeleteButton(newMultipleChoiceItem));
        answersContainer.appendChild(newMultipleChoiceItem);
    }

    function addCheckboxItem() {
        const answersContainer = document.getElementById('answers-container');
        const index = answersContainer.children.length;
    
        const newCheckboxItem = document.createElement('div');
        newCheckboxItem.className = 'checkbox-item mb-2 p-2 border rounded flex items-center';
        newCheckboxItem.innerHTML = `
            <input type="checkbox" name="answer_key[]" value="${index}" class="mr-2">
            <input type="text" name="options[]" placeholder="New Option" class="w-full border-0 rounded">
        `; 
        newCheckboxItem.appendChild(createDeleteButton(newCheckboxItem));
        answersContainer.appendChild(newCheckboxItem);
    }
    
    

    function addTextItem() {
        const newTextItem = document.createElement('div');
        newTextItem.className = 'text-item mb-2 p-2 border rounded flex items-center';
        newTextItem.innerHTML = `
            <input type="text" placeholder="Short Text Answer" class="w-full border rounded">
        `;
        newTextItem.appendChild(createDeleteButton(newTextItem));
        answersContainer.appendChild(newTextItem);
    }

    function addParagraphItem() {
        const newParagraphItem = document.createElement('div');
        newParagraphItem.className = 'paragraph-item mb-2 p-2 border rounded flex items-center';
        newParagraphItem.innerHTML = `
            <textarea placeholder="Long Text Answer" class="w-full border rounded"></textarea>
        `;
        newParagraphItem.appendChild(createDeleteButton(newParagraphItem));
        answersContainer.appendChild(newParagraphItem);
    }

    variantSelect.addEventListener('change', updateAnswersContainer);
    addAnswerBtn.addEventListener('click', function() {
        const selectedVariant = variantSelect.value;
        if (selectedVariant === 'drag-drop') {
            addDragDropItem();
        } else if (selectedVariant === 'multiple-choice') {
            addMultipleChoiceItem();
        } else if (selectedVariant === 'checkboxes') {
            addCheckboxItem();
        } else if (selectedVariant === 'text') {
            addTextItem();
        } else if (selectedVariant === 'paragraph') {
            addParagraphItem();
        }
    });

    addFileBtn.addEventListener('click', addFileInput);

    saveMatchingKeyBtn.addEventListener('click', function() {
        // Save matching keys logic here
    });

    reloadMatchingKeyBtn.addEventListener('click', function() {
        createMatchingKey();
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            reloadMatchingKeys();
        }
    });


    document.getElementById('variant-select').addEventListener('change', function() {
        const selectedVariant = this.value;
        document.getElementById('question-type-hidden').value = selectedVariant;
    });

    document.getElementById('question-type-hidden').value = document.getElementById('variant-select').value;

    
    document.getElementById('points-input').addEventListener('input', function () {
        document.getElementById('points-hidden').value = this.value;
    });

    

    submitButton.addEventListener('click', function(event) {
        event.preventDefault();
        form.submit(); 
    });

    updateAnswersContainer();
});