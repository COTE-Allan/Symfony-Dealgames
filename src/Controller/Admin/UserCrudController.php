<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            yield TextField::new('email'),
            yield TextField::new('username'),
            yield ChoiceField::new('roles')->autocomplete()->allowMultipleChoices()->setChoices([
                'Admin' => 'ROLE_ADMIN',
                'Utilisateur' => 'ROLE_USER',
            ])      
        ];
    }
}
