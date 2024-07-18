<?php
  include './layout/layout.php';
  include './components/SideBar.php';
?>

<div class="dashboard m-[130px] flex flex-col gap-10">
  <!-- <h2>Clientes</h2> -->
  <h2 class="text-accent text-2xl uppercase">Menú de habitaciones</h2>
<!-- Form de Clientes -->
<div class="flex flex-col gap-10">
    <!-- Button -->
    <div>
    <button class="bg-primary text-white px-10" id="btn-abrir-modal-h">Nueva habitación</button>
    </div>
    <!-- Table -->
     <div class="flex items-center gap-10">
     <div>
    <h2 class="text-xl">Lista de Habitaciones</h2>
     </div>
    <table class="w-full">
        <thead>
            <tr class="bg-primary text-white font-thin">
                <th>Numero de Habitación</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpoHabitacion">
          
        </tbody>
    </table>
     </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Modal -->

<dialog class="bg-slate-50 rounded px-10 py-5 border shadow-custom2" id="modal_hab">
  <form id="frm_habitacion">
    <h3 class="text-center py-5 text-2xl">Registro de Habitaciones</h3>
   <div class="flex flex-col gap-10">
   <input type="hidden" name="id_habitacion" id="id_habitacion">
    <div>
    <label for="numero">Numero de Habitacion:</label>
    <input class="border rounded text-accent" type="text" name="numero" id="numero" required>
   </div>
   <div>
    <label for="precio">Tipo:</label>
    <select name="tipo" id="tipo" class="border rounded text-accent" required>
    </select>
   </div>
    <div>
      <label for="precio">Precio:</label>
      <input class="border rounded text-accent" type="text" name="precio" id="precio" required>
    </div>
   <div class="modal-footer flex">
   <button type="submit" class="btn btn-secondary px-10">Guardar</button>
    <button type="button" class="btn btn-secondary" id="btn-cerrar-modal-h">Cancelar</button>
  </div>
   </div>
  </form>
</dialog>

<?php require_once('./components/Scripts.php') ?>
<script src="habitacion.js"></script>
 