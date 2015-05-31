<?php

namespace Levi9\JamArchiveBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Levi9\JamArchiveBundle\Services\JamJarService;

class JamJarAdmin extends Admin
{
    public function prePersist($jamJar)
    {
        $amount = (int)$this->getForm()->get('amount')->getData();
        if ($amount > 1) {
            $this->getJamJarService()->cloneJams($jamJar, --$amount);
        }
    }

    /**
     * @param JamJarService $jamJarService
     */
    public function setJamJarService(JamJarService $jamJarService)
    {
        $this->jamJarService = $jamJarService;
    }

    /**
     * @return JamJarService
     */
    public function getJamJarService()
    {
        return $this->jamJarService;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('type', 'entity', ['class' => 'Levi9\JamArchiveBundle\Entity\JamType'])
            ->add('year', 'entity', ['class' => 'Levi9\JamArchiveBundle\Entity\JamYear'])
            ->add('comment', 'text', ['required' => false, 'label' => 'jam.jar.comment.label'])
        ;

        $jamJar = $this->getSubject();

        if (!$jamJar->getId()) {
            $formMapper->add('amount', 'number', ['mapped'=> false, 'data' => 1, 'label' => 'jam.jar.amount.label']);
        }
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
