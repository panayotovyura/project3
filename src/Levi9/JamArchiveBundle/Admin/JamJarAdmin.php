<?php

namespace Levi9\JamArchiveBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class JamJarAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('type', 'entity', ['class' => 'Levi9\JamArchiveBundle\Entity\JamType'])
            ->add('year', 'entity', ['class' => 'Levi9\JamArchiveBundle\Entity\JamYear'])
            ->add('comment', 'text', ['required' => false, 'label' => 'jam.jar.comment.label'])
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('type')
            ->add('year')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('type')
            ->add('year')
            ->add('comment')
        ;
    }
}
