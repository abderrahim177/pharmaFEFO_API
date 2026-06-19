async function loadFEFOQueue() {
    const url = 'http://localhost/PHARMAFEFO_API/src/controller/web/MedicalContrroller.php';
    const tableBody = document.getElementById('fefoTableBody');
    if (!tableBody) return;

    try {
        const response = await fetch(url);
        const res = await response.json();
        if (res.status !== 'success') return;   
        if (res.data.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="p-4 text-center text-slate-400 italic">
                        Aucun produit trouvé dans la file FEFO.
                    </td>
                </tr>`;
            return;
        }

        tableBody.innerHTML = res.data.map(item => {
            const today = new Date();
            const expireDate = new Date(item.expiration_date);
            const diffTime = expireDate - today;
            const daysLeft = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            let statusText = "", badgeClass = "", dateClass = "";

            if (daysLeft <= 30) {
                statusText = "Priorité 1 (Urgent)";
                badgeClass = "bg-rose-50 text-rose-700 border border-rose-100";
                dateClass = "text-rose-600 font-medium";
            } else if (daysLeft <= 90) {
                statusText = "Priorité 2";
                badgeClass = "bg-amber-50 text-amber-700 border border-amber-100";
                dateClass = "text-amber-600 font-medium";
            } else {
                statusText = "En Attente";
                badgeClass = "bg-emerald-50 text-emerald-700 border border-emerald-100";
                dateClass = "text-emerald-600 font-medium";
            }

            return `
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="p-2 font-medium text-slate-800">${item.product_name}</td>
                    <td class="p-2 text-slate-500 font-mono">${item.lot_number}</td>
                    <td class="p-2">
                        <span class="bg-slate-100 text-slate-700 px-1.5 py-0.5 rounded-sm font-medium text-[10px]">
                            ${item.Emplacement || 'Non spécifié'}
                        </span>
                    </td>
                    <td class="p-2 ${dateClass}">
                        ${expireDate.toLocaleDateString('fr-FR')}
                    </td>
                    <td class="p-2 text-right">
                        <span class="${badgeClass} px-2 py-0.5 rounded-sm font-medium text-[9px] uppercase tracking-wider inline-block">
                            ${statusText}
                        </span>
                    </td>
                </tr>
            `;
        }).join('');

        if (document.getElementById('countEntries')) {
            document.getElementById('countEntries').innerText = `${res.data.length} Lot(s)`;
        }

    } catch (error) {
        console.error('Erreur lors du chargement:', error);
    }
}
const formAddBatch = document.getElementById('formAddBatch');
if (formAddBatch) {
    formAddBatch.addEventListener('submit', function(e) {
        e.preventDefault(); 
        const dluInput = document.getElementById('dlu_input').value;
        const errorSpan = document.getElementById('date_error');
        const todayStr = new Date().toISOString().split('T')[0];     
        const selectedDate = new Date(dluInput);
        const currentDate = new Date(todayStr);
        if (!dluInput || selectedDate < currentDate) {
            errorSpan.classList.remove('hidden'); 
            return;
        }
        errorSpan.classList.add('hidden'); 
        const url = 'http://localhost/PHARMAFEFO_API/src/controller/web/MedicalContrroller.php';
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
                this.reset(); 
                loadFEFOQueue(); 
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: res.message,
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Erreur...', text: res.message });
            }
        })
        .catch(error => console.error('Erreur:', error));
    });
}
document.addEventListener('DOMContentLoaded', function() {   
    loadFEFOQueue(); 
    
    const dluInput = document.getElementById('dlu_input');
    if (dluInput) {
        dluInput.min = new Date().toISOString().split('T')[0];
    }
});
document.addEventListener('DOMContentLoaded', () => {
    loadFEFOQueue();
});