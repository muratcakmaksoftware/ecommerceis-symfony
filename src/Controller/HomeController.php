<?php

namespace App\Controller;

use App\Helper\ResponseHelper;
use App\Service\CartService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/home")
 */
class HomeController extends AbstractController
{
    private TranslatorInterface $translator;
    private CacheInterface $cache;

    public function __construct(TranslatorInterface $translator, CacheInterface $cache)
    {
        $this->translator = $translator;
        $this->cache = $cache;
    }

    /**
     * @Route("")
     * @return void
     */
    public function index(Request $request)
    {
        //$request->setLocale('tr');
        //dd($this->translator->trans('test translation'));

        //dd($this->translator->trans('a.b.c'));
        $this->cache->get('mykey2', function (ItemInterface $item) {
            $item->set('myvalue');
                
        });
        dd('ok');
    }
}
