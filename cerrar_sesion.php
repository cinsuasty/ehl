<?php
        session_start();
        session_destroy(); 
        echo '<script language="javascript">
                alert("Usted, ha cerrado sesión.");
                sessionStorage.clear();
                window.location="/../../index.html " 
            </script>';
?>