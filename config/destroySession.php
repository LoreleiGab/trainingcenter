<?php
session_start(['name' => 'trainingcenter']);
session_destroy();
echo '<script> window.location.href="'. SERVERURL .'" </script>';