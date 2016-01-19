<?php

namespace Extranet\MediaBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FileTypeExtension extends AbstractTypeExtension
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Retourne le nom du type de champ qui est étendu
     *
     * @return string Le nom du type qui est étendu
     */
    public function getExtendedType()
    {
        return 'file';
    }

    /**
     * Ajoute l'option file_path
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('file_path', 'image_type'));
    }


    /**
     * Passe l'url du media à la vue
     *
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('file_path', $options)) {
            $parentData = $form->getParent()->getData();

            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();

                // set complete url, not just the media name
                $fileUrl  = $this->getFileUrl($accessor->getValue($parentData, $options['file_path']), $view->parent->vars['full_name']);
               // $filePath = $parentData->getPath();

            } else {
                $fileUrl  = null;
                $filePath = null;
            }

            // définit une variable "file_url" qui sera disponible à l'affichage du champ
            $view->vars['file_url']  = $fileUrl;
            //$view->vars['file_path'] = $filePath;
        }
    }

    public function getFileUrl($filePath, $formName)
    {

        $parentFormName = substr($formName, 0, strpos($formName, '['));

        switch ($parentFormName) {
            case 'extranetdocumentbundle_document':
                return $this->container->getParameter('medias.repertoire.documents') . $filePath;
                break;
            default:
                return null;
                break;
        }

        return false;
    }

}
