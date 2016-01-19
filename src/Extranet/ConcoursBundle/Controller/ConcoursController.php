<?php

namespace Extranet\ConcoursBundle\Controller;

use Extranet\ConcoursBundle\Entity\Concours;
use Extranet\ConcoursBundle\Entity\Reponse;
use Extranet\ConcoursBundle\Form\Type\Concours\ConcoursType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Extranet\ConcoursBundle\Form\Type\Concours\ConcoursModifierType;
use Extranet\ConcoursBundle\ExtranetConcoursBundle;

class ConcoursController extends Controller
{
    public function indexAction()
    {
    	$concours = $this->get('extranet_concours.concours_manager')->loadAll();
    	
        return $this->render('ExtranetConcoursBundle:Concours:index.html.twig', array('concours' => $concours));
    }
    
    public function ajouterAction(Request $request) {
    	if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $logger = $this->get('logger');
            $logger->info('Logger récupéré');
            $logger->err('Accés non autorisé');

            return $this->redirect($this->generateUrl('extranet_concours_homepage'));
        }
        
        $concours = new Concours();
        
        $form = $this->creerAjouterForm($concours);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $concours->setDatecreation(new \DateTime());

            $this->get('extranet_concours.concours_manager')->persistAndFlush($concours);

            return $this->redirect($this->generateUrl('extranet_concours_homepage', array('id' => $concours->getIdconcours())));
        }

        return $this->render('ExtranetConcoursBundle:Concours:ajouter.html.twig', array(
            'concours' => $concours,
            'form' => $form->createView(),
        ));
    }
    
    public function creerAjouterForm(Concours $concours)
    {
    	$form = $this->createForm(new ConcoursType(), $concours, array(
    			'action' => $this->generateUrl('extranet_concours_ajouter'),
    			'method' => 'POST'
    	));
    
    	return $form;
    }
    
    public function supprimerAction($idConcours) {
    	if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
    		$logger = $this->get('logger');
    		$logger->info('Logger récupéré');
    		$logger->err('Accés non autorisé');
    
    		return $this->redirect($this->generateUrl('extranet_concours_homepage'));
    	}
    	
    	$concours = $this->get('extranet_concours.concours_manager')->load($idConcours);
    	
    	$this->get('extranet_concours.concours_manager')->removeConcours($concours);
    	
    	return $this->redirect($this->generateUrl('extranet_concours_homepage'));
    }
    
    public function modifierAction($idConcours)
    {
    	if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
    		$logger = $this->get('logger');
    		$logger->info('Logger récupéré');
    		$logger->err('Accés non autorisé');
    
    		return $this->redirect($this->generateUrl('extranet_document_homepage'));
    	}
    
    	$concours = $this->get('extranet_concours.concours_manager')->load($idConcours);
    	//$listeReponses = $this->get('extranet_concours.reponse_manager')->findBy($concours);
    	
    	//print_r($listeReponses);
    	//exit;

    	$form = $this->creerModifierForm($concours);
    
    	$form->handleRequest($this->get('request'));
    
    	if ($form->isValid()) {
    		$reponse1 = new Reponse();
    		$reponse1->setLibelle('toto1');
    		$reponse1->setReponsecorrecte('1');
    		
    		$reponse2 = new Reponse();
    		$reponse2->setLibelle('toto2');
    		$reponse2->setReponsecorrecte('0');
    		
    		$reponse1->setConcours($concours);
    		$reponse2->setConcours($concours);
    		
    		$this->get('extranet_concours.concours_manager')->persistAndFlush($concours);
    		$this->get('extranet_concours.concours_manager')->persistAndFlush($reponse1);
    		$this->get('extranet_concours.concours_manager')->persistAndFlush($reponse2);
    
    		return $this->redirect($this->generateUrl('extranet_concours_homepage', array('id' => $concours->getIdConcours())));
    	}
    
    	return $this->render('ExtranetConcoursBundle:Concours:modifier.html.twig', array(
    			'concours' => $concours,
    			//'listeReponse' => $listeReponses,
    			'form' => $form->createView(),
    	));
    }
    
    public function creerModifierForm(Concours $concours)
    {
    	$form = $this->createForm(new ConcoursModifierType(), $concours, array(
    			'action' => $this->generateUrl('extranet_concours_modifier', array('idConcours' => $concours->getIdconcours())),
    			'method' => 'POST'
    	));
    
    	return $form;
    }
}
