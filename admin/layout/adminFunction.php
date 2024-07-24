<?php
include "../database/db.php";


function msg($icon,$msg)
{
    echo '<script>
    Swal.fire({
        icon: "'.$icon.'",
        text: "' . $msg . '"
    });
    </script>';
   return ;
}

function msg_loc($icon,$msg,$loc)
{

    echo '<script> 
        Swal.fire({
            
            text: "' . $msg . '",
            icon: "'.$icon.'",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "' . $loc . '"; // Redirect to home page
            }
        });
    </script>';
    exit();

}

?>