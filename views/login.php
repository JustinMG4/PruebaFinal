<?php
include './layout/layout.php';
?>
<body>
  

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="relative flex flex-col m-6 space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0">
        <!-- left side -->
        <div class="flex flex-col justify-center p-8 md:p-14">
            <h2 class="mb-3 text-6xl">Bienvenido de nuevo!</h2>
            <span class="font-light text-accent mb-8">
                Inicia sesión para continuar
            </span>
            
            <!-- <form method="post" action=".././controllers/usuario.controller.php?op=login"> -->
            <form method="post" action="dashboard.php">
                <?php
                if (isset($_GET['op'])) {
                    switch ($_GET['op']) {
                        case '1':
                            ?>
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    El usuario o la contraseña son incorrectos, intente de nuevo
                                </div>
                            </div>
                            <?php
                            break;
                        case '2':
                            ?>
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    Complete las casillas
                                </div>
                            </div>
                            <?php
                    }
                }
                ?>
                <div class="py-4">
                    <span class="mb-2 text-md">Correo Electrónico</span>
                    <input
                        type="text"
                        class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500"
                        name="correo"
                        id="correo"
                        placeholder="Ingrese su usuario o correo"
                        autofocus
                        required
                    />
                </div>
                <div class="py-4">
                    <span class="mb-2 text-md">Contraseña</span>
                    <input
                        type="password"
                        name="contrasenia"
                        id="contrasenia"
                        class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500"
                        placeholder="Contraseña"
                        required
                    />
                </div>
                <div class="flex justify-between w-full py-4">
                    <div class="mr-24">
                        <input type="checkbox" name="remember-me" id="remember-me" class="mr-2" />
                        <span class="text-md">Remember for 30 days</span>
                    </div>
                </div>
                <button
                    class="w-full bg-primary text-white p-2 rounded-lg mb-6 hover:bg-white hover:text-black hover:border hover:border-gray-300"
                    type="submit"
                >
                    Iniciar Sesión
                </button>
            </form>
        </div>
        <!-- right side -->
        <div class="relative">
            <img
                src="../public/images/login.png"
                alt="img"
                class="w-[400px] h-full hidden rounded-r-2xl md:block object-cover"
            />
            <!-- text on image  -->
            <div
                class="absolute hidden bottom-10 right-6 p-6 bg-white bg-opacity-30 backdrop-blur-sm rounded drop-shadow-lg md:block"
            >
            <span class="text-white text-xl">
            "En el Gimnasio "Ciudad Verde", cada repetición te acerca más a tu mejor versión."
            </span>
            </div>
        </div>
    </div>
</div>

<!-- script JQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
