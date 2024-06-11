import './bootstrap';
import '~resources/scss/app.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
]);

const allBtns = document.querySelectorAll('.js-delete');
console.log(allBtns)

allBtns.forEach((btn) => {
    btn.addEventListener('click', function(event){
        event.preventDefault();

        const id = btn.dataset.id
        const name = btn.dataset.name

        const definitiveDeleteModal = document.getElementById('defDelModal')
        const defDelModal = new bootstrap.Modal(definitiveDeleteModal);

        document.querySelector('#defDelModal p').innerHTML = `Stai per eliminare il progetto ${name}`
        defDelModal.show()

        const delForm = document.getElementById('delForm');
        console.log(delForm)
        delForm.setAttribute('action', `http://127.0.0.1:8000/admin/projects/${id}`)
    })
})
