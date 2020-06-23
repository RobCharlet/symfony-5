<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/hello/{name}", name="homepage")
     * @param Request     $request
     * @param null|string $name
     *
     * @return Response
     */
    public function index(Request $request, string $name = '')
    {
        $greet = '';
        if ($name) {
            $greet = sprintf('<h1>Hello %s!</h1>', htmlspecialchars($name));
        }
        else if ($name=$request->query->get('hello')) {
            $greet = sprintf('<h1>Hello %s!</h1>', htmlspecialchars($name));
        }
        return new Response(<<<EOF
        <html>
            <body>
                $greet
                <img src="/images/under-construction.png" alt="Under Construction" width="300" height="200">
            </body>
        </html>
EOF
);
    }
}
