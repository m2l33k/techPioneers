<?php
// src/Enum/RoleUserEnum.php
namespace App\Enum;

enum RoleUserEnum: string
{
    case STUDENT = 'Etudiant';
    case TEACHER = 'Enseignant';
    case ADMIN = 'Admin';
}

?>