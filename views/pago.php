<?php
  include './layout/layout.php';
  include './components/SideBar.php';
?>

<div class="dashboard m-[130px] flex flex-col gap-10">
  <!-- <h2>Clientes</h2> -->
  <h2 class="text-accent text-2xl uppercase">Menú de Pagos</h2>
<!-- Form de Clientes -->
<div class="flex flex-col gap-10">
    <!-- Button -->
    <div>
    <button class="bg-primary text-white px-10" id="btn-abrir-modal-pago">Nuevo Pago</button>
    </div>
    <!-- Table -->
     <div class="flex items-center gap-10">
     <div>
    <h2 class="text-xl">Lista de Pagos</h2>
     </div>
    <table class="w-full collapse">
        <thead>
            <tr class="bg-primary text-white font-thin">
                <th>#</th>
                <th>ID Pago</th>
                <th>ID Pedido</th>
                <th>ID Metodo de Pago</th>
                <th>Monto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpoPago">
          
        </tbody>
    </table>
     </div>
</div>
</div>

<dialog class="bg-slate-50 rounded px-10 py-5 border shadow-custom2" id="modal_pago">
  <form id="frm_pago">
    <input type="text" class="hidden" id="id_pago"> 
    <h3 class="text-center py-5 text-2xl">Registro o Modificación de Pagos</h3>
   <div class="flex flex-col gap-10">
   <div>
    <label for="pedido">Pedido:</label>
    <input class="border rounded text-accent" type="text" name="pedido" id="pedido" required>
   </div>
    <div>
    <label for="metodo_pago">Metodo de Pago:</label>
    <input class="border rounded text-accent" type="text" name="metodo_pago" id="metodo_pago" required>
   </div>
   <div>
    <label for="monto">Monto:</label>
    <input class="border rounded text-accent" type="text" name="monto" id="monto" required>
   </div>
   <div class="modal-footer flex">
   <button type="submit" class="btn btn-secondary px-10">Guardar</button>
    <button type="button" class="btn btn-secondary" id="btn-cerrar-modal-pago">Cancelar</button>
  </div>
   </div>
  </form>
</dialog>

<script src="pago.js"></script>
 
 