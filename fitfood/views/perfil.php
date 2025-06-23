<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . base_url('login'));
    exit;
}

if ($_SESSION['user_tipo'] === 'nutricionista') {
    header('Location: ' . base_url('nutricionista/dashboard'));
} else {
    header('Location: ' . base_url('/'));
}
exit;
?>