<?php

    require('utils.php');

    init_php_session();
    clean_php_session();

    header("location: auth.php");