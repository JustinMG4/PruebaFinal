// Codigo para abrir modal de nuevo pago y editar pago

const btnAbrirModalPago = document.querySelector('#btn-abrir-modal-pago');
const btnCerrarModalPago = document.querySelector('#btn-cerrar-modal-pago');
const modalPago = document.querySelector('#modal_pago');

btnAbrirModalPago.addEventListener('click', () => {
    modalPago.showModal();
}
);

btnCerrarModalPago.addEventListener('click', () => {
    modalPago.close();
}
);

//Fin de codigo para abrir modal de nuevo pago y editar pago

//Backend de pago
