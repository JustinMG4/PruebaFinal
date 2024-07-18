<?php
  include './layout/layout.php';
  include './components/SideBar.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="dashboard m-[130px] flex flex-col gap-10">
  <!-- <h2>Clientes</h2> -->
  <h2 class="text-accent text-2xl uppercase">Menú de Reservaciones</h2>
<!-- Form de Clientes -->
<div class="flex flex-col gap-10">
    <!-- Button -->
    <div>
    <button class="bg-primary text-white px-10" id="btn-abrir-modal-res">Nueva Reservacion</button>
    </div>
    <!-- Table -->
     <div class="flex items-center gap-10">
     <div>
    <h2 class="text-xl">Lista de Reservaciones</h2>
     </div>
    <table class="w-full">
        <thead>
            <tr class="bg-primary text-white font-thin">
                <th>#</th>
                <th>Huesped</th>
                <th>Fecha de entrada</th>
                <th>Fecha de salida</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpoReserva">
          
        </tbody>
    </table>
     </div>
</div>
</div>

<dialog class="bg-slate-50 rounded px-10 py-5 border shadow-custom2" id="modal_res">
  <form id="frm_reserva">
    <input type="text" class="hidden" id="id_reserva"> 
    <h3 class="text-center py-5 text-2xl">Registro de la Reserva</h3>
   <div class="flex flex-col gap-10">
   <div>
    <label for="id_huesped">Identificación del huesped:</label>
    <input class="border rounded text-accent" type="text" name="id_huesped" id="id_huesped" required>
   </div>
    <div>
    <label for="fecha_entrada">Fecha de entrada:</label>
    <input class="border rounded text-accent" type="date" name="fecha_entrada" id="fecha_entrada" required>
   </div>
   <div>
    <label for="fecha_salida">Fecha de salida:</label>
    <input class="border rounded text-accent" type="date" name="fecha_salida" id="fecha_salida" required>
   </div>
   <div>
    <label for="total">Total de la reserva:</label>
    <input class="border rounded text-accent" type="text" name="total" id="total" readonly>
   </div>
   <div class="flex items-center gap-10">
     <div>
    <h2 class="text-xl">Habitaciones Disponibles</h2>
     </div>
    <table class="w-full" id= "tabla_lista">
        <thead>
            <tr class="bg-primary text-white font-thin">
                <th>Habitacion Nº</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpoLista">
          
        </tbody>
    </table>
     </div>
   <div class="modal-footer flex">
   <button type="submit" class="btn btn-secondary px-10">Guardar</button>
    <button type="button" class="btn btn-secondary" id="btn-cerrar-modal-res">Cancelar</button>
  </div>
   </div>
  </form>
</dialog>



<dialog class="bg-slate-50 rounded px-10 py-5 border shadow-custom2" id="modal_detalle">
  <form id="frm_detalle">
    <input type="text" class="hidden" id="id_reservaD"> 
    <h3 class="text-center py-5 text-2xl">Detalle de la reserva</h3>
   <div class="flex flex-col gap-10">
   <div>
    <label for="id_huespede">Identificación del huesped:</label>
    <input class="border rounded text-accent" type="text" name="id_huespede" id="id_huespede" readonly>
   </div>
   <div>
    <label for="nombre">Huesped:</label>
    <input class="border rounded text-accent" type="text" name="nombre" id="nombre" readonly>
   </div>
    <div>
    <label for="entrada">Fecha de entrada:</label>
    <input class="border rounded text-accent" type="date" name="entrada" id="entrada" readonly>
   </div>
   <div>
    <label for="salida">Fecha de salida:</label>
    <input class="border rounded text-accent" type="date" name="salida" id="salida" readonly>
   </div>
   <div>
    <label for="totalD">Total de la reserva:</label>
    <input class="border rounded text-accent" type="text" name="totalD" id="totalD" readonly>
   </div>
   <div class="flex items-center gap-10">
     <div>
    <h2 class="text-xl">Habitaciones Reservadas</h2>
     </div>
    <table class="w-full" id= "tabla_listaRes">
        <thead>
            <tr class="bg-primary text-white font-thin">
                <th>Habitacion Nº</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Subtotal</th>>
            </tr>
        </thead>
        <tbody id="cuerpoDetalle">
          
        </tbody>
    </table>
     </div>
   <div class="modal-footer flex">
    <button type="button" class="btn btn-secondary" id="btn-cerrar-modal-D">Cerrar</button>
  </div>
   </div>
  </form>
</dialog>
<?php require_once('./components/Scripts.php') ?>
<script src="reservas.js"></script>
 
 