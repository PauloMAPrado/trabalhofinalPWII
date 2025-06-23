<?php
namespace Controllers;

class Install {
    public function show() {
        include __DIR__ . '/../views/install.php';
    }
    
    public function install() {
        $this->show();
    }
}