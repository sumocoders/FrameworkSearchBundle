<?php

namespace SumoCoders\FrameworkSearchBundle\Controller;

use SumoCoders\FrameworkSearchBundle\Form\Type\SearchType;
use SumoCoders\FrameworkSearchBundle\Helper\Search;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/search.{_format}", defaults={"_format"="html"}, requirements={"_format"="html|json"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $term = $request->get('term');
        $form = $this->createForm(
            new SearchType(),
            array('term' => $term)
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            return $this->redirect(
                $this->generateUrl(
                    'sumocoders_frameworksearch_default_index',
                    array(
                        'term' => $data['term']
                    )
                )
            );
        }

        $results = null;
        if ('' != $term) {
            $repository = $this->getDoctrine()->getRepository('SumoCodersFrameworkSearchBundle:IndexItem');
            $dispatcher = $this->get('event_dispatcher');
            $search = new Search($repository, $dispatcher, $term);

            $results = $search->search();
        }

        if ('' != $term) {
            $this->get('framework.breadcrumb_builder')
                ->addSimpleItem(
                    $term
                );
        }

        return array(
            'term' => $term,
            'form' => $form->createView(),
            'results' => $results,
        );
    }
}
