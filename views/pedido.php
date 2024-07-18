<?php
  include './layout/layout.php';
  include './components/SideBar.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="dashboard m-[130px] flex flex-col gap-10">
  <!-- <h2>Clientes</h2> -->
  <h2 class="text-accent text-2xl uppercase">Menú del Pedido</h2>
<!-- Form de Clientes -->
<div class="flex flex-col gap-10">
    <!-- Button -->
    <div>
    <button class="bg-primary text-white px-10" id="btn-abrir-modal-pedido">Nuevo Pedido</button>
    </div>
    <!-- Table -->
     <div class="flex items-center gap-10">
     <div>
    <h2 class="text-xl">Lista de Pedidos</h2>
     </div>
    <table class="w-full">
        <thead>
            <tr class="bg-primary text-white font-thin">
                <th>#</th>
                <th>ID Pedido</th>
                <th>Cliente</th>
                <th>Direccion</th>
                <th>Fecha de Pedido</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpoPedido">
          
        </tbody>
    </table>
     </div>
</div>
</div>


<dialog class="bg-slate-50 rounded px-10 py-5 border shadow-custom2" id="modal_pedido">
  <form id="frm_pedido">
    <input type="text" class="hidden" id="id_pedido"> 
    <h3 class="text-center py-5 text-2xl">Registro de Pedido</h3>
   <div class="flex flex-col gap-10">
   <div>
    <label for="cliente">Cliente:</label>
    <input class="border rounded text-accent" type="text" name="cliente" id="cliente" required>
   </div>
   <div class="flex items-center gap-10">
     <div>
    <h2 class="text-xl">Lista de productos</h2>
     </div>
    <table class="w-full">
        <thead>
            <tr class="bg-primary text-white font-thin">
                <th>#</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tbProductos">
          
        </tbody>
    </table>
     </div>
</div>
   <div class="modal-footer flex">
   <button type="submit" class="btn btn-secondary px-10">Guardar</button>
    <button type="button" class="btn btn-secondary" id="btn-cerrar-modal-pedido">Cancelar</button>
  </div>
   </div>
  </form>
</dialog>

<dialog class="bg-slate-50 rounded px-10 py-5 border shadow-custom2" id="modal_detallepedido">
  <form id="frm_pedido">
    <input type="text" class="hidden" id="id_pedido"> 
    <h3 class="text-center py-5 text-2xl">Detalle del pedido</h3>
   <div class="flex flex-col gap-10">
   <div>
    <label for="cliente">Cliente:</label>
    <input class="border rounded text-accent" type="text" name="cliente" id="cliente" required>
   </div>
   <div class="flex items-center gap-10">
     <div>
    <h2 class="text-xl">Lista de productos</h2>
     </div>
    <table class="w-full">
        <thead>
            <tr class="bg-primary text-white font-thin">
                <th>#</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody id="tbDetallePedido">
          
        </tbody>
    </table>
     </div>
</div>
   <div class="modal-footer flex">
    <button type="button" class="btn btn-secondary" id="btn-cerrar-modal-detallepedido">Cerrar</button>
  </div>
   </div>
  </form>
</dialog>

<?php require_once('./components/Scripts.php') ?>
<script src="pedido.js"></script>
 