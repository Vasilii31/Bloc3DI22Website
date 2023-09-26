<?php

    require('../Librairies/utils.php');

    init_php_session();
    clean_php_session();

    header("location: ../Views/auth.php");