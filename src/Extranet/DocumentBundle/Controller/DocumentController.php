<?php

namespace Extranet\DocumentBundle\Controller;

use Extranet\DocumentBundle\Entity\Document;
use Extranet\DocumentBundle\Form\Type\Document\DocumentType;
use Extranet\DocumentBundle\Form\Type\Document\DocumentModifierType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DocumentController extends Controller
{
    public function indexAction()
    {
        $documents = $this->get('extranet_document.document_manager')->loadAll();

        return $this->render('ExtranetDocumentBundle:Document:index.html.twig', array(
            'documents' => $documents
        ));
    }

    public function afficherAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $document = $em->getRepository('ExtranetDocumentBundle:Document')->find($id);

        if (!$document) {
            $logger = $this->get('logger');
            $logger->info('Logger récupéré');
            $logger->err('Une erreur est survenue');

            return $this->redirect($this->generateUrl('extranet_document_homepage'));
        }

        return $this->render('ExtranetDocumentBundle:Document:afficher.html.twig', array(
            'document' => $document,
        ));
    }

    public function ajouterAction(Request $request)
    {

        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {

            $logger = $this->get('logger');
            $logger->info('Logger récupéré');
            $logger->err('Accés non autorisé');


            return $this->redirect($this->generateUrl('extranet_document_homepage'));
        }


        $utilisateur = $this->container->get('security.context')->getToken()->getUser();


        $document = Document::initDocument($utilisateur);


        $form = $this->creerAjouterForm($document);
        $form->handleRequest($request);


        if ($form->isValid())
        {
            $document->setDate(new \DateTime());

            $this->get('extranet_document.document_manager')->persistAndFlush($document);

            return $this->redirect($this->generateUrl('extranet_document_homepage', array('id' => $document->getId())));
        }

        return $this->render('ExtranetDocumentBundle:Document:ajouter.html.twig', array(
            'document' => $document,
            'form' => $form->createView(),
        ));
    }

    public function creerAjouterForm(Document $document)
    {
        $form = $this->createForm(new DocumentType(), $document, array(
            'action' => $this->generateUrl('extranet_document_ajouter'),
            'method' => 'POST'
        ));

        //$form->add('submit', 'submit');
        return $form;
    }

    public function modifierAction($id)
    {
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            //throw new AccessDeniedException('Accès limité aux admins.');
            $logger = $this->get('logger');
            $logger->info('Logger récupéré');
            $logger->err('Accés non autorisé');

            return $this->redirect($this->generateUrl('extranet_document_homepage'));
        }

        $document = $this->get('extranet_document.document_manager')->load($id);

        $utilisateur = $this->container->get('security.context')->getToken()->getUser();

      /* if ($utilisateur !== $document->getUtilisateur()) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'Accès refusé !'
            );
            return $this->redirect($this->generateUrl('extranet_document_homepage'));
        }*/


        $form = $this->creerModifierForm($document);

        $form->handleRequest($this->get('request'));

        if ($form->isValid()) {

            $this->get('extranet_document.document_manager')->persistAndFlush($document);

            return $this->redirect($this->generateUrl('extranet_document_homepage', array('id' => $document->getId())));
        }

        return $this->render('ExtranetDocumentBundle:Document:modifier.html.twig', array(
            'document' => $document,
            'form' => $form->createView(),
        ));
    }

    public function creerModifierForm(Document $document)
    {
        $form = $this->createForm(new DocumentModifierType(), $document, array(
            'action' => $this->generateUrl('extranet_document_modifier', array('id' => $document->getId())),
            'method' => 'POST'
        ));

       // $form->add('submit', 'submit');

        return $form;
    }

    public function supprimerAction($id)
    {
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            //throw new AccessDeniedException('Accès limité aux admins.');
            $logger = $this->get('logger');
            $logger->info('Logger récupéré');
            $logger->err('Accés non autorisé');

            return $this->redirect($this->generateUrl('extranet_document_homepage'));
        }
        $document = $this->get('extranet_document.document_manager')->load($id);
        $utilisateur = $this->container->get('security.context')->getToken()->getUser();

        /*if ($utilisateur !== $document->getUtilisateur()) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'Accès refusé !'
            );

            return $this->redirect($this->generateUrl('extranet_document_homepage'));
        }*/

        $this->get('extranet_document.document_manager')->removeDocument($document);

        return $this->redirect($this->generateUrl('extranet_document_homepage'));
    }

    public function utilisateurAction()
    {
        $utilisateur = $this->container->get('security.context')->getToken()->getUser();

        $documents = $this->get('extranet_document.document_manager')->loadByUser($utilisateur->getId());

        return $this->render('ExtranetDocumentBundle:Document:utilisateur.html.twig', array(
            'documents' => $documents
        ));
    }

    public function activerAction($id)
    {
        $document = $this->get('extranet_document.document_manager')->load($id);
        $utilisateur = $this->container->get('security.context')->getToken()->getUser();

        if ($utilisateur !== $document->getUtilisateur()) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'Accès refusé !'
            );

            return $this->redirect($this->generateUrl('extranet_document_homepage'));
        }

        $document->setActive(true);
        if ($this->get('extranet_document.document_manager')->saveDocument($document)) {

            return $this->redirect($this->generateUrl('extranet_document_homepage'));
        }

        return $this->render('ExtranetDocumentBundle:Document:supprimer.html.twig');
    }

    public function desactiverAction($id)
    {
        $document = $this->get('extranet_document.document_manager')->load($id);
        $utilisateur = $this->container->get('security.context')->getToken()->getUser();

        if ($utilisateur !== $document->getUtilisateur()) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'Accès refusé !'
            );

            return $this->redirect($this->generateUrl('extranet_document_homepage'));
        }

        $document->setActive(false);
        if ($this->get('extranet_document.document_manager')->saveDocument($document)) {

            return $this->redirect($this->generateUrl('extranet_document_homepage'));
        }

        return $this->render('ExtranetDocumentBundle:Document:supprimer.html.twig');
    }

    public function telechargerAction($id)
    {

        $document = $this->get('extranet_document.document_manager')->load($id);

        $response = new Response();

        $response->setContent($document->getMediasContent());

        $response->headers->set('Content-Type', '' . $document->getContentType() . '');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $document->getNom() . '"');
        $response->headers->set('Accept-Ranges', 'none');
        $response->headers->set('Content-Transfer-Encoding', '0');
        $response->headers->set('Cache-Control','no-cache');

        return $response;
    }
}