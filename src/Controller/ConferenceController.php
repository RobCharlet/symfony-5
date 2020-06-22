<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return new Response(<<<EOF
        <html>
            <body>
                <img src="/images/under-construction.png" alt="Under Construction" width="300" height="200">
            </body>
        </html>
EOF
);
    }
}
