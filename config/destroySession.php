<?php
session_start(['name' => 'gesp']);
session_destroy();
echo '<script> window.location.href="'. SERVERURL .'" </script>';