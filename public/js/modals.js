
export function closeModal() {
    const modals = document.querySelectorAll('[id^="modal"]');
    modals.forEach(modal => {
        if(!modal.classList.contains('hidden')) {
            modal.classList.add('opacity-0');
            modal.querySelector('.transform').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    });
}

function openModal(modal) {
    if(!modal) return;
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.querySelector('.transform').classList.remove('scale-95');
    }, 10);
}


document.addEventListener("DOMContentLoaded", function() {

    const btnOpenAddModal = document.getElementById('btnOpenAddModal');
    if (btnOpenAddModal) {
        btnOpenAddModal.addEventListener('click', () => {
            openModal(document.getElementById('modalAddUser'));
        });
    }

    document.querySelectorAll('.btnEditUser').forEach(button => {
        button.addEventListener('click', (e) => {
            const row = e.target.closest('tr');
            if (!row) return;
            
            const id = row.querySelector('.target-id')?.innerText.trim() || '';
            const name = row.querySelector('.target-name')?.innerText.trim() || '';
            const email = row.querySelector('.target-email')?.innerText.trim() || '';
            const role = row.querySelector('.target-role')?.getAttribute('data-role') || '';
            const status = row.querySelector('.target-status')?.getAttribute('data-status') || '';
            
            if(document.getElementById('edit_user_id')) document.getElementById('edit_user_id').value = id;
            if(document.getElementById('edit_name')) document.getElementById('edit_name').value = name;
            if(document.getElementById('edit_email')) document.getElementById('edit_email').value = email;
            if(document.getElementById('edit_role')) document.getElementById('edit_role').value = role;
            if(document.getElementById('edit_status')) document.getElementById('edit_status').value = status;
            
            openModal(document.getElementById('modalEditUser'));
        });
    });

    document.querySelectorAll('.btnDeleteUser').forEach(button => {
        button.addEventListener('click', (e) => {
            const btn = e.target.closest('.btnDeleteUser');
            const id = btn.getAttribute('data-id');
            const name = btn.getAttribute('data-name');
            
            if(document.getElementById('delete_user_id')) document.getElementById('delete_user_id').value = id;
            if(document.getElementById('delete_user_name')) document.getElementById('delete_user_name').innerText = name;
            
            openModal(document.getElementById('modalDeleteUser'));
        });
    });

    document.querySelectorAll('.btnCloseModal').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    document.querySelectorAll('[id^="modal"]').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if(e.target === modal) closeModal();
        });
    });
});