<?php
// src/Enum/RoleUserEnum.php
namespace App\Enum;

enum Role_UserEnum: string
{
    case STUDENT = 'Etudiant';
    case TEACHER = 'Enseignant';
    case ADMIN = 'admin';
}

?>