<?php
include './layout/layout.php';
  include './components/SideBar.php';
  

?>
<div class="dashboard m-[130px] flex flex-col gap-10">
  <!-- <h2>Clientes</h2> -->
  <h2 class="text-accent text-2xl uppercase">Menú de Clientes</h2>
<!-- Form de Clientes -->
<div class="flex flex-col gap-10">
    <!-- Button -->
    <div>
    <button class="bg-primary text-white px-10" id="btn-abrir-modal">Nuevo Cliente</button>
    </div>
    <!-- Table -->
     <div class="flex items-center gap-10">
     <div>
    <h2 class="text-xl">Lista de Clientes</h2>
     </div>
    <table class="w-full">
        <thead>
            <tr class="bg-primary text-white">
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="text-center" id="cuerpoClientes">
        </tbody>
    </table>
     </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Modal -->

<dialog class="bg-slate-50 rounded px-10 py-5 border shadow-custom2" id="modal">
  <form id="frm_cliente" enctype="multipart/form-data">
    <h3 class="text-center py-5 text-2xl">Registro o Modificación de Cliente</h3>
   <div class="flex flex-col gap-10"> 
    <input type="hidden" name="id_cliente" id="id_cliente">
   <div>
    <label for="nombre">Nombre del Cliente:</label>
    <input class="border rounded text-accent" type="text" name="nombre" id="nombre" required>
   </div>
   <div>
    <label for="apellido">Apellido del Cliente:</label>
    <input class="border rounded text-accent" type="text" name="apellido" id="apellido" required>
   </div>
   <div class="flex flex-col">
    <label for="correo">Correo del Cliente:</label>
    <input class="border rounded text-accent" type="text" name="correo" id="correo" required>
   </div>
   <div class="modal-footer flex">
   <button type="submit" class="btn btn-secondary px-10">Guardar</button>
    <button type="button" class="btn btn-secondary" id="btn-cerrar-modal">Cancelar</button>
  </div>
   </div>
  </form>
</dialog>

<?php require_once('./components/Scripts.php') ?>
<script src="cliente.js"></script>