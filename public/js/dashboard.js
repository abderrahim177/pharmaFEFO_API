document.getElementById('formAddUser').addEventListener('submit', function(e) {
    e.preventDefault(); 

    const url = 'http://localhost/PHARMAFEFO_API/src/controller/web/UserController.php';

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data) 
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP: ' + response.status);
        }
        return response.json();
    })
    .then(res => {
        if (res.status === 'success') {
            sessionStorage.setItem('flash_success', res.message);
            
            this.reset();
            if(document.querySelector('.btnCloseModal')) {
                document.querySelector('.btnCloseModal').click();
            }
            window.location.href = '../../templates/admin/table_users.php?data_succ'; 
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erreur...',
                text: res.message,
                confirmButtonColor: '#0d9488'
            });
        }
    })
    .catch(error => {
        console.error('Erreur f l-envoi:', error);
        Swal.fire({
            icon: 'error',
            title: 'Connexion échouée',
            text: 'Une erreur est survenue lors de la connexion au serveur.',
            confirmButtonColor: '#0d9488'
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const successMsg = sessionStorage.getItem('flash_success');
    
    if (successMsg) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
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