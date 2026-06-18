async function loadUsers() {
    const url = 'http://localhost/PHARMAFEFO_API/src/controller/web/UserController.php';
    const tableBody = document.getElementById('usersTableBody');
    if (!tableBody) return;
    
    try {
        const response = await fetch(url);
        const res = await response.json();
        
        if (res.status !== 'success') return;
        
        if (res.data.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="py-8 text-center text-slate-400 italic bg-slate-50/10">
                        <i class="fa-solid fa-users-slash text-slate-300 block text-lg mb-1.5"></i>
                        Aucun utilisateur trouvé.
                    </td>
                </tr>`;
            return;
        }
        
        const roleClasses = {
            'Administrateur': 'bg-teal-50 text-teal-700 border-teal-100/40',
            'Pharmacien': 'bg-emerald-50 text-emerald-700 border-emerald-100/40',
            'Preparateur': 'bg-amber-50 text-amber-700 border-amber-100/40',
            'Préparateur': 'bg-amber-50 text-amber-700 border-amber-100/40'
        };
        
        tableBody.innerHTML = res.data.map(user => {
            const isActif = user.status === 'Actif';
            const badgeClass = roleClasses[user.role] || 'bg-slate-50 text-slate-700 border-slate-100';
            const statusClass = isActif ? 'bg-emerald-50 text-emerald-700 border-emerald-100/20' : 'bg-slate-50 text-slate-500 border-slate-200';
            const dotClass = isActif ? 'bg-emerald-500' : 'bg-slate-400';
            
            return `
                <tr class="hover:bg-slate-50/40 transition">
                    <td class="py-3 px-4 text-center font-mono text-[11px] text-slate-400">#${user.id}</td>
                    <td class="py-3 px-4 font-medium text-slate-800">${user.name}</td>
                    <td class="py-3 px-4 text-slate-500 font-normal">${user.email}</td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold border ${badgeClass}">
                            ${user.role}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-slate-400 text-[11px]">${user.created_at || '---'}</td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold border ${statusClass}">
                            <span class="w-1 h-1 rounded-full ${dotClass}"></span> ${user.status}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <button title="Modifier" class="btnEditUser p-1 text-slate-400 hover:text-teal-600 hover:bg-slate-50 rounded transition cursor-pointer" data-id="${user.id}">
                                <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                            </button>
                            <button title="Supprimer" class="btnDeleteUser p-1 text-slate-400 hover:text-rose-600 hover:bg-slate-50 rounded transition cursor-pointer" data-id="${user.id}" data-name="${user.name}">
                                <i class="fa-solid fa-trash-can text-[11px]"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join(''); 

    } catch (error) {
        console.error('Erreur lors du chargement:', error);
    }
}

// كود الـ Submit للفورم
document.getElementById('formAddUser').addEventListener('submit', function(e) {
    e.preventDefault(); 
    const url = 'http://localhost/PHARMAFEFO_API/src/controller/web/UserController.php';
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify(data) 
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success') {
            sessionStorage.setItem('flash_success', res.message);
            this.reset();
            if(document.querySelector('.btnCloseModal')) {
                document.querySelector('.btnCloseModal').click();
            }
            window.location.href = '../../templates/admin/table_users.php?data_succ'; 
        } else {
            Swal.fire({ icon: 'error', title: 'Erreur...', text: res.message });
        }
    })
    .catch(error => console.error('Erreur:', error));
});

// تشغيل الـ Toast وجلب الداتا تلقائياً عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    
    loadUsers(); // <--- هادي هي لي كانت ناقصاك باش تعيط للدالة ف البلاصة!

    const successMsg = sessionStorage.getItem('flash_success');
    if (successMsg) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        Toast.fire({
            icon: 'success',
            title: successMsg,
            background: '#f0fdf4',
            iconColor: '#16a34a'
        });
        sessionStorage.removeItem('flash_success'); 
    }
});