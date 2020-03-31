<?php

namespace PublicationBundle\Controller;

use PublicationBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Publication controller.
 *
 */
class PublicationController extends Controller
{
    /**
     * Lists all publication entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publications = $em->getRepository('PublicationBundle:Publication')->findAll();

        return $this->render('publication/index.html.twig', array(
            'publications' => $publications,
        ));
    }

    /**
     * Creates a new publication entity.
     *
     */
    public function newAction(Request $request)
    {
        $publication = new Publication();
        $form = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('brochure')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $publication->setBrochureFilename($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();

            return $this->redirectToRoute('publication_show', array('id' => $publication->getId()));
        }

        return $this->render('publication/new.html.twig', array(
            'publication' => $publication,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a publication entity.
     *
     */
    public function showAction(Publication $publication)
    {
        $deleteForm = $this->createDeleteForm($publication);

        return $this->render('publication/show.html.twig', array(
            'pub' => $publication,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing publication entity.
     *
     */
    public function editAction(Request $request, Publication $publication)
    {
        $deleteForm = $this->createDeleteForm($publication);
        $editForm = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $brochureFile = $editForm->get('brochure')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $publication->setBrochureFilename($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_edit', array('id' => $publication->getId()));
        }

        return $this->render('publication/edit.html.twig', array(
            'publication' => $publication,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a publication entity.
     *
     */
    public function deleteAction(Request $request, Publication $publication)
    {
        $form = $this->createDeleteForm($publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($publication);
            $em->flush();
        }

        return $this->redirectToRoute('publication_index');
    }

    /**
     * Creates a form to delete a publication entity.
     *
     * @param Publication $publication The publication entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publication $publication)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publication_delete', array('id' => $publication->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
