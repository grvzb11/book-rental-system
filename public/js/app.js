(() => {
    const body = document.body;
    const openButtons = document.querySelectorAll('[data-sidebar-open]');
    const closeButtons = document.querySelectorAll('[data-sidebar-close]');

    const openSidebar = () => body.classList.add('sidebar-open');
    const closeSidebar = () => body.classList.remove('sidebar-open');

    openButtons.forEach((button) => button.addEventListener('click', openSidebar));
    closeButtons.forEach((button) => button.addEventListener('click', closeSidebar));

    document.querySelectorAll('[data-alert-close]').forEach((button) => {
        button.addEventListener('click', () => button.closest('[data-alert]')?.remove());
    });

    document.querySelectorAll('[data-cover-uploader]').forEach((uploader) => {
        const input = uploader.querySelector('[data-cover-input]');
        const image = uploader.querySelector('[data-cover-image]');
        const placeholder = uploader.querySelector('[data-cover-placeholder]');
        const clear = uploader.querySelector('[data-cover-clear]');
        const remove = uploader.querySelector('[data-remove-cover]');
        const originalSrc = image?.getAttribute('src') || '';
        let objectUrl = null;

        const showImage = (src) => {
            if (!image || !placeholder) return;
            image.src = src;
            image.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };

        const showPlaceholder = () => {
            if (!image || !placeholder) return;
            image.removeAttribute('src');
            image.classList.add('hidden');
            placeholder.classList.remove('hidden');
        };

        input?.addEventListener('change', () => {
            const file = input.files?.[0];
            if (!file) return;
            if (objectUrl) URL.revokeObjectURL(objectUrl);
            objectUrl = URL.createObjectURL(file);
            showImage(objectUrl);
            if (remove) remove.checked = false;
        });

        clear?.addEventListener('click', () => {
            if (input) input.value = '';
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }
            showPlaceholder();
            if (remove && originalSrc) remove.checked = true;
        });

        remove?.addEventListener('change', () => {
            if (remove.checked) {
                if (input) input.value = '';
                showPlaceholder();
            } else if (originalSrc && !input?.files?.length) {
                showImage(originalSrc);
            }
        });
    });

    document.querySelectorAll('[data-character-input]').forEach((input) => {
        const count = input.closest('.field')?.querySelector('[data-character-count]');
        if (!count) return;
        const update = () => { count.textContent = String(input.value.length); };
        input.addEventListener('input', update);
        update();
    });

    const bookSelect = document.querySelector('[data-book-select]');
    const bookPreview = document.querySelector('[data-selected-book-preview]');
    if (bookSelect && bookPreview) {
        const cover = bookPreview.querySelector('[data-selected-book-cover]');
        const title = bookPreview.querySelector('[data-selected-book-title]');
        const meta = bookPreview.querySelector('[data-selected-book-meta]');
        const price = bookPreview.querySelector('[data-selected-book-price]');

        const updateBookPreview = () => {
            const option = bookSelect.selectedOptions?.[0];
            if (!option?.value) {
                bookPreview.hidden = true;
                return;
            }

            bookPreview.hidden = false;
            title.textContent = option.dataset.title || option.textContent || 'Selected book';
            meta.textContent = [option.dataset.author, option.dataset.year].filter(Boolean).join(' · ');
            price.textContent = option.dataset.price || '';

            if (cover) {
                cover.replaceChildren();
                if (option.dataset.cover) {
                    const img = document.createElement('img');
                    img.src = option.dataset.cover;
                    img.alt = '';
                    cover.appendChild(img);
                } else {
                    const label = document.createElement('span');
                    label.textContent = 'BOOK';
                    cover.appendChild(label);
                }
            }
        };

        bookSelect.addEventListener('change', updateBookPreview);
        updateBookPreview();
    }

    const dialog = document.getElementById('confirm-dialog');
    if (dialog && typeof dialog.showModal === 'function') {
        const title = document.getElementById('confirm-title');
        const message = document.getElementById('confirm-message');
        const accept = dialog.querySelector('[data-confirm-accept]');
        const cancel = dialog.querySelector('[data-confirm-cancel]');
        let pendingForm = null;

        document.querySelectorAll('form[data-confirm]').forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (form.dataset.confirmed === 'true') return;
                event.preventDefault();
                pendingForm = form;
                title.textContent = form.dataset.confirmTitle || 'Confirm action';
                message.textContent = form.dataset.confirm || 'Are you sure you want to continue?';
                dialog.showModal();
            });
        });

        cancel.addEventListener('click', () => {
            pendingForm = null;
            dialog.close();
        });

        accept.addEventListener('click', () => {
            if (!pendingForm) return dialog.close();
            pendingForm.dataset.confirmed = 'true';
            const form = pendingForm;
            pendingForm = null;
            dialog.close();
            form.requestSubmit();
        });

        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) {
                pendingForm = null;
                dialog.close();
            }
        });
    }
})();
