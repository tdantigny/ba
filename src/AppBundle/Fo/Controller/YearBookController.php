<?php

namespace AppBundle\Fo\Controller;

use AppBundle\Core\Entity\Yearbook;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactController
 * @package AppBundle\Fo\Controller
 * @Route("/annuaire")
 */
class YearBookController extends Controller
{
    /**
     * @Route("/", name="fo_year_book")
     * @Method({"GET"})
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $yearBooksPushed = $this->get('app_core_year_book')->getPushed();

        return $this->render(
            'YearBook/year-book.html.twig',
            [
                'pagination' => $this->get('app_core_year_book')->getPagination(
                    $request->query
                ),
                'yearBooksPushed' => $yearBooksPushed,
            ]
        );
    }

    /**
     * @Route("/vote", name="fo_year_book_vote", options={"expose"=true})
     * @Method({"POST"})
     * @param Request $request
     * @return Response
     */
    public function voteAction(Request $request)
    {
        $postData = $request->request;
        $yearBook = $this->get('app_core_year_book')->get($postData->get('yearBookId'));
        $rate = $postData->get('rate');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $this->get('app_core_vote_year_book')->rate(
            $yearBook,
            $user,
            $rate
        );
        $calculatedRate = $this->get('app_core_vote_year_book')->calculateRate($yearBook);

        $response = [
            'rate' => $rate,
            'calculatedRate' => $calculatedRate,
            'yearBookId' => $postData->get('yearBookId'),
        ];

        return new Response(
            json_encode($response),
            200
        );
    }

    /**
     * @Route("/go", name="fo_year_book_go", options={"expose"=true})
     * @Method({"POST"})
     * @param Request $request
     * @return Response
     */
    public function goAction(Request $request)
    {
        $postData = $request->request;
        $yearBook = $this->get('app_core_year_book')->get($postData->get('yearBookId'));
        $yearBook = $this->get('app_core_year_book')->incrementedCLick($yearBook);

        $response = [
            'numberOfClick' => $yearBook->getClick(),
            'yearBookId' => $postData->get('yearBookId'),
        ];

        return new Response(
            json_encode($response),
            200
        );
    }
}
