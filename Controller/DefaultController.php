<?php

namespace SumoCoders\FrameworkSearchBundle\Controller;

use SumoCoders\FrameworkSearchBundle\Entity\SearchResult;
use SumoCoders\FrameworkSearchBundle\Form\Type\SearchType;
use SumoCoders\FrameworkSearchBundle\Helper\Search;
use SumoCoders\FrameworkSearchBundle\Helper\SearchHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/search")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $term = $request->get('q');
        $form = $this->createForm(
            new SearchType(
                $this->get('translator')
            ),
            array('q' => $term)
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            return $this->redirect(
                $this->generateUrl(
                    'sumocoders_frameworksearch_default_index',
                    array(
                        'q' => $data['q']
                    )
                )
            );
        }

        $results = null;
        if ($term != '') {
            $repository = $this->getDoctrine()->getRepository('SumoCodersFrameworkSearchBundle:IndexItem');
            $dispatcher = $this->get('event_dispatcher');
            $search = new Search($repository, $dispatcher);

            $search->setTerm($term);
            $search->search();

            $results = $search->getResults();
        }

        return array(
            'term' => $term,
            'form' => $form->createView(),
            'results' => $results,
        );
    }
}
