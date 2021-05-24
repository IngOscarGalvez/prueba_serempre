<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->

        <a href="/" class="brand-link">
            <img src="/img/Logo.png" alt="Josefa" class="brand-image" />
            <span class="brand-text font-weight-light"></span>
            <br />
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <nav class="mt-2">
                <ul
                    class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <router-link :to="{ name: 'users' }">
                            <a class="nav-link">
                                <em class="fas fa-users"></em>
                                <p>Admin de Usuarios</p>
                            </a>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link :to="{ name: 'cities' }">
                            <a class="nav-link">
                                <em class="fas fa-city"></em>
                                <p>Admin de Ciudades</p>
                            </a>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link :to="{ name: 'clients' }">
                            <a class="nav-link">
                                <em class="fas fa-user"></em>
                                <p>Admin de Clientes</p>
                            </a>
                        </router-link>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted.");
    }
};
</script>

<style>
body {
    width: 99.4%;
}

[class*="sidebar-dark-"] .sidebar a {
    color: #275c97;
}

.brand-link .brand-image {
    margin-left: 2.5rem;
    max-height: 52px;
    margin-top: -9px;
}
[class*="sidebar-dark-"] {
    background-color: #fff;
}

.VueTables__table {
    width: 100% !important;
}

.VueTables__columns-dropdown {
    margin-right: 70px;
}
</style>
