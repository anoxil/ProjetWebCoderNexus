<!-- Navigation Bar -->
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">

    <!-- brand -->
    <a class="navbar-brand" href="index.php">
        <span class="fas fa-code"></span> CoderNexus
    </a>

    <!-- add tutorial -->
    <?php 
        if (isset($_SESSION["loginUser"]) && ($_SESSION["admin"] == 1)) {
            echo "<a class='ml-auto p-3' href='tutorial_add.php'>";
            echo "    Ajouter un tutoriel";
            echo "</a>";
        }
    ?>

    <!-- connection/profile dropdown -->
    <div class="dropdown">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php 
                if (isset($_SESSION["loginUser"])) { echo "Bonjour, ".$_SESSION["loginUser"]; }
                else { echo "Non connecté"; }
            ?>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#">
            <?php 
                if (isset($_SESSION["loginUser"])) { echo "<a href='profile.php'><span class='far fa-user-circle'></span> Mon profil</a>"; }
                else { echo "<a href='login.php'><span class='fas fa-sign-in-alt'></span> Se connecter</a>"; }
            ?>
            </a>
            <a class="dropdown-item" href="#">
            <?php 
                if (isset($_SESSION["loginUser"])) { echo "<a href='logout.php'><span class='fas fa-sign-out-alt'></span> Se déconnecter</a>"; }
                else { echo "<a href='signup.php'><span class='fas fa-user-plus'></span> S'inscrire</a>"; }
            ?>
            </a>
        </div>
    </div> 

</nav>