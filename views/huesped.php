<?php
include './layout/layout.php';
  include './components/SideBar.php';
  

?>
<div class="dashboard m-[130px] flex flex-col gap-10">
  <!-- <h2>Clientes</h2> -->
  <h2 class="text-accent text-2xl uppercase">Menú de huespedes</h2>
<!-- Form de Clientes -->
<div class="flex flex-col gap-10">
    <!-- Button -->
    <div>
    <button class="bg-primary text-white px-10" id="btn-abrir-modal">Nuevo huesped</button>
    </div>
    <!-- Table -->
     <div class="flex items-center gap-10">
     <div>
    <h2 class="text-xl">Lista de huespedes</h2>
     </div>
    <table class="w-full">
        <thead>
            <tr class="bg-primary text-white">
                <th>#</th>
                <th>Identificación</th>
                <th>Tipo de identificacion</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="text-center" id="cuerpoHuesped">
        </tbody>
    </table>
     </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Modal -->

<dialog class="bg-slate-50 rounded px-10 py-5 border shadow-custom2" id="modal">
  <form id="frm_huesped" enctype="multipart/form-data">
    <h3 class="text-center py-5 text-2xl">Registro del Huesped</h3>
   <div class="flex flex-col gap-10"> 
    <div>
    <label for="id_huesped">Identificación:</label>
      <input class="border rounded text-accent" type="text" name="id_huesped" id="id_huesped" required>
    </div>
    <div>
      <label for="tipo_identificacion">Tipo de Documento:</label>
      <select name="tipo_identificacion" id="tipo_identificacion" class="border rounded text-accent" required>
        <option value="cedula">Cédula</option>
          <option value="pasaporte">Pasaporte</option>
      </select>
    </div>
   <div>
      <label for="nombre">Nombre:</label>
      <input class="border rounded text-accent" type="text" name="nombre" id="nombre" required>
   </div>
   <div>
      <label for="apellido">Apellido:</label>
      <input class="border rounded text-accent" type="text" name="apellido" id="apellido" required>
   </div>
   <div class="flex flex-col">
    <label for="email">Correo:</label>
    <input class="border rounded text-accent" type="email" name="email" id="email" required>
   </div>
    <div>
      <label for="telefono">Teléfono:</label>
      <input class="border rounded text-accent" type="text" name="telefono" id="telefono" required>
    </div>
   <div class="modal-footer flex">
   <button type="submit" class="btn btn-secondary px-10">Guardar</button>
    <button type="button" class="btn btn-secondary" id="btn-cerrar-modal">Cancelar</button>
  </div>
   </div>
  </form>
</dialog>

<?php require_once('./components/Scripts.php') ?>
<script src="huesped.js"></script>